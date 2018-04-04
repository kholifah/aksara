<?php
namespace App\Aksara\Core\ModuleManager\Http;

use Aksara\MigrationInfo;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Aksara\Core\Module;
use Aksara\ModuleActivationCheckInfo;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Aksara\ModuleStatus\ModuleStatus;
use Aksara\ModuleDependency\PluginRequiredBy;
use Aksara\ModuleKey;
use Aksara\UpdateModuleStatus\UpdateModuleStatusHandler;
use Aksara\ModuleRegistry\ModuleRegistryHandler;

class ModuleManagerController extends Controller
{
    private $module;
    private $moduleStatus;
    private $pluginRequiredBy;
    private $updateModuleStatus;
    private $moduleRegistry;

    public function __construct(
        Module $module,
        ModuleStatus $moduleStatus,
        PluginRequiredBy $pluginRequiredBy,
        UpdateModuleStatusHandler $updateModuleStatus,
        ModuleRegistryHandler $moduleRegistry
    ){
        $this->module = $module;
        $this->moduleStatus = $moduleStatus;
        $this->pluginRequiredBy = $pluginRequiredBy;
        $this->updateModuleStatus = $updateModuleStatus;
        $this->moduleRegistry = $moduleRegistry;
    }

    private function getModulesMerged()
    {
        //Modules V1
        $modules = config('aksara.modules');

        //Plugins V2
        $grouped = $this->moduleRegistry->getRegisteredModulesGrouped();
        foreach ($grouped as $type => $plugins) {
            $pluginsArray = array();

            foreach ($plugins as $plugin) {
                $arrayItem = $plugin->toManifestArray();
                $arrayItem[$plugin->getName()]['version'] = 2;
                $pluginsArray = array_merge($pluginsArray, $arrayItem);
            }

            if (isset($modules[$type])) {
                $modules[$type] = array_merge($modules[$type], $pluginsArray);
            } else {
                $modules[$type] = $pluginsArray;
            }
        }
        return $modules;
    }

    private function getModule($type, $name)
    {
        $modules = $this->getModulesMerged();
        if (!isset($modules[$type][$name])) {
            throw new NotFoundHttpException('Module not found');
        }
        return $modules[$type][$name];
    }

    public function index()
    {
        $moduleV1 = $this->module;
        $moduleV1->moduleStatusChangeListener();

        $pluginRequiredBy = $this->pluginRequiredBy;

        $moduleGroup = $this->moduleRegistry->getRegisteredModulesGrouped();

        $param = compact('moduleV1', 'pluginRequiredBy', 'moduleGroup');

        return view('core:module-manager::index', $param)->render();
    }

    public function activationCheck($type, $slug)
    {
        $modules = $this->getModulesMerged();
        $module = $this->getModule($type, $slug);

        //TODO: refactor to separate module dependency resolver
        $dependenciesInfo = $this->getDependenciesRecursive(
            $modules, $type, $slug
        );

        //TODO: refactor to separate migration resolver
        $migrations = $this->getPendingMigrations(
            $type, $slug, $dependenciesInfo, isset($module['version']) ? $module['version'] : 1
        );

        $data = new ModuleActivationCheckInfo(
            $type,
            $slug,
            $dependenciesInfo,
            $migrations
        );

        return view('core:module-manager::activation-check', $data->toArray());
    }

    private function getPendingMigrations(
        $type, $slug, $dependenciesInfo, $version = 1
    ){
        $selfMigrations = [];
        if (!migration_complete($type, $slug)) {
            $paths = migration_path($type, $slug);
            $selfMigrations = MigrationInfo::bulk($type, $slug, $paths, $version);
        }
        $depsMigrations = [];

        foreach ($dependenciesInfo as $dependencyInfo) {
            if (migration_complete(
                $dependencyInfo->getType(),
                $dependencyInfo->getModuleName()
            )){
                continue;
            }
            $dep = $this->getModule(
                $dependencyInfo->getType(),
                $dependencyInfo->getModuleName()
            );
            $paths = migration_path(
                $dependencyInfo->getType(),
                $dependencyInfo->getModuleName()
            );
            $depsMigration = MigrationInfo::bulk(
                $dependencyInfo->getType(),
                $dependencyInfo->getModuleName(),
                $paths,
                isset($dep['version']) ? $dep['version'] : 1
            );
            $depsMigrations = array_merge($depsMigrations, $depsMigration);
        }

        $migrations = array_unique(array_merge($selfMigrations, $depsMigrations));
        return $migrations;
    }

    private function getDependenciesRecursive($modules, $type, $slug)
    {
        $dependencies = $this->resolveDependencies($modules, $type, $slug);
        $collection = collect($dependencies);

        $statusCollection = $collection->map(function ($item, $key) {
            $statusInfo = $this->moduleStatus->getStatus($item['type'], $item['name']);
            return $statusInfo;
        });
        return $statusCollection->reverse()->values()->all();
    }

    private function getModuleType($moduleName)
    {
        $type = 'plugin';
        $legacy = $this->moduleRegistry->isRegistered($moduleName) ? false : true;
        if (!$legacy) {
            $registeredModule = $this->moduleRegistry->getManifest($moduleName);
            $type = $registeredModule->getType();
        }
        return $type;
    }

    private function resolveDependencies($modules, $type, $slug)
    {
        if (!isset($modules[$type][$slug])) {
            throw new NotFoundHttpException(
                __('core:module-manager::message.module-not-found-message'));
        }
        $module = $modules[$type][$slug];
        if (isset($module['dependencies']) && !empty($module['dependencies'])) {
            $childDeps = [];
            foreach ($module['dependencies'] as $moduleDep) {
                $depType = $this->getModuleType($moduleDep);
                $childDep = $this->resolveDependencies(
                    $modules,
                    $depType,
                    $moduleDep
                );
                foreach ($childDep as $dep) {
                    if (!in_array($dep, $childDeps)) {
                        $childDeps[] = $dep;
                    }
                }
            }
            $result = array_map(
                function ($item) {
                    $type = $this->getModuleType($item);
                    return [
                        'name' => $item,
                        'type' => $type,
                    ];

                }, $module['dependencies']
            );
            foreach ($childDeps as $dep) {
                if (!in_array($dep, $result)) {
                    $result[] = $dep;
                }
            }
            return $result;
        }
        return [];
    }

    public function recursiveActivate($type, $slug)
    {
        try {
            $modules = $this->getModulesMerged();

            if (!isset($modules[$type][$slug])) {
                throw new NotFoundHttpException(__('core:module-manager::message.module-not-found-message'));
            }

            $module = $modules[$type][$slug];

            $dependenciesInfo = $this->getDependenciesRecursive(
                $modules, $type, $slug);

            $unregistered = collect($dependenciesInfo)
                ->filter(function ($item, $key) {
                    return !$item->getIsRegistered();
                })->count();

            if ($unregistered > 0) {
                throw new \Exception(__('core:module-manager::message.unregistered-dependency-message'));
            }

            $pendingMigrations = $this->getPendingMigrations(
                $type, $slug, $dependenciesInfo, isset($module['version']) ? $module['version'] : 1
            );

            if (count($pendingMigrations) > 0) {
                throw new \Exception(__('core:module-manager::message.pending-migration-message'));
            }

            $moduleInfo = $this->moduleStatus->getStatus($type, $slug);

            //TODO refactor to combine with unregistered detection above
            if (!$moduleInfo->getIsRegistered()) {
                throw new \Exception(__('core:module-manager::message.unregistered-message', ['moduleType' => $type, 'moduleName' => $slug]));
            }

            $inactiveOnly = collect($dependenciesInfo)
                ->filter(function ($item, $key) {
                    return !$item->getIsActive();
                })->values()->all();

            $toBeActivated = array_merge($inactiveOnly, [ $moduleInfo ]);
            $activated = [];

            foreach ($toBeActivated as $itemToBeActivated) {
                if ($itemToBeActivated->getVersion() == 1) {
                    if (!$this->updateModuleStatus->activate(
                        new ModuleKey(
                            $itemToBeActivated->getType(),
                            $itemToBeActivated->getModuleName())
                        )
                    ){
                        //rollback
                        foreach ($activated as $itemActivated) {
                            $this->updateModuleStatus->deactivate(
                                new ModuleKey(
                                    $itemActivated->getType(),
                                    $itemActivated->getModuleName()
                                )
                            );
                        }
                        //raise error
                        throw new \Exception(__('core:module-manager::message.error-activating-module-message'));
                    }
                } else {
                    $this->moduleRegistry->activateModule(
                        $itemToBeActivated->getModuleName());
                }
                $activated[] = $itemToBeActivated;
                admin_notice('success', __('core:module-manager::message.activate-module-successfully', [
                        'moduleType' => $itemToBeActivated->getType(),
                        'moduleName' => $itemToBeActivated->getModuleName(),
                    ])
                );
            }

            session()->put('activating_module', $activated);

            return redirect()->route('module-manager.index');
        } catch (\Exception $e) {
            admin_notice('warning',
                 __('core:module-manager::message.fail-activate-module-message', ['moduleType' => $type, 'moduleName' => $slug, 'error' => $e->getMessage()])
            );
            return redirect()->route('module-manager.index');
        }
    }

    public function deactivate($type, $slug)
    {
        try {
            if (strtolower($type) == 'plugin') {
                if ($this->pluginRequiredBy->isRequired($slug)) {
                    throw new \Exception(
                        __('core:module-manager::message.cannot-deactivate-module-message', ['moduleType' => $type, 'moduleName' => $slug])
                    );
                }
            }
            if ($this->moduleStatus->getVersion($type, $slug) == 1) {
                $this->updateModuleStatus->deactivate(new ModuleKey($type, $slug));
            } else {
                $this->moduleRegistry->deactivateModule($slug);
            }
            admin_notice('success',
                __('core:module-manager::message.deactivate-module-successfully', [
                    'moduleType' => $type,
                    'moduleName' => $slug,
                ])
            );
            session()->put('deactivating_module', new ModuleKey($type, $slug));

            return redirect()->route('module-manager.index');
        } catch (\Exception $e) {
            admin_notice('warning',
                __('core:module-manager::message.fail-deactivate-module-message', ['moduleType' => $type, 'moduleName' => $slug, 'error' => $e->getMessage()])
            );
            return redirect()->route('module-manager.index');
        }
    }
}
