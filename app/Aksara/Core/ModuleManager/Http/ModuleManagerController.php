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

        foreach ($modules as &$type) {
            foreach ($type as &$module) {
                $module['version'] = 1;
            }
        }

        //Plugins V2
        $plugins = $this->moduleRegistry->getRegisteredModules();
        $pluginsArray = array();

        foreach ($plugins as $plugin) {
            $arrayItem = $plugin->toManifestArray();
            $arrayItem[$plugin->getName()]['version'] = 2;
            $pluginsArray = array_merge($pluginsArray, $arrayItem);
        }

        $modules['plugin'] = array_merge($modules['plugin'], $pluginsArray);
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
        $module = $this->module;
        $module->moduleStatusChangeListener();

        $pluginRequiredBy = $this->pluginRequiredBy;

        $plugins = $this->moduleRegistry->getRegisteredModules();

        $param = compact('module', 'pluginRequiredBy', 'plugins');

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
            $type, $slug, $dependenciesInfo, $module['version']
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
                $dep['version']
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
            $statusInfo = $this->moduleStatus->getStatus('plugin', $item);
            return $statusInfo;
        });
        return $statusCollection->reverse()->values()->all();
    }

    private function resolveDependencies($modules, $type, $slug)
    {
        if (!isset($modules[$type][$slug])) {
            throw new NotFoundHttpException('Module not found');
        }
        $module = $modules[$type][$slug];
        if (isset($module['dependencies']) && !empty($module['dependencies'])) {
            $childDeps = [];
            foreach ($module['dependencies'] as $dep) {
                $childDep = $this->resolveDependencies(
                    $modules,
                    'plugin',
                    $dep
                );
                foreach ($childDep as $dep) {
                    if (!in_array($dep, $childDeps)) {
                        $childDeps[] = $dep;
                    }
                }
            }
            $result = $module['dependencies'];
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
                throw new NotFoundHttpException('Module not found');
            }

            $module = $modules[$type][$slug];

            $dependenciesInfo = $this->getDependenciesRecursive(
                $modules, $type, $slug);

            $unregistered = collect($dependenciesInfo)
                ->filter(function ($item, $key) {
                    return !$item->getIsRegistered();
                })->count();

            if ($unregistered > 0) {
                throw new \Exception('Unregistered dependency found');
            }

            $pendingMigrations = $this->getPendingMigrations(
                $type, $slug, $dependenciesInfo, $module['version']
            );

            if (count($pendingMigrations) > 0) {
                throw new \Exception('Pending migration found');
            }

            $moduleInfo = $this->moduleStatus->getStatus($type, $slug);

            //TODO refactor to combine with unregistered detection above
            if (!$moduleInfo->getIsRegistered()) {
                throw new \Exception("$type - $slug is not registered");
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
                        throw new \Exception('Error occured when activating module');
                    }
                } else {
                    if ($itemToBeActivated->getType() == 'plugin') {
                        $this->moduleRegistry->activateModule(
                            $itemToBeActivated->getModuleName());
                    }
                }
                $activated[] = $itemToBeActivated;
            }

            session()->put('activating_module', $activated);

            return redirect()->route('module-manager.index');
        } catch (\Exception $e) {
            admin_notice('warning',
                $type .
                ' - ' .
                $slug .
                ' gagal diaktifkan:' . $e->getMessage()
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
                        'Cannot deactivate ' . $type . ' - ' . $slug .
                        ' because used in another module(s)'
                    );
                }
            }
            if ($this->moduleStatus->getVersion($type, $slug) == 1) {
                $this->updateModuleStatus->deactivate(new ModuleKey($type, $slug));
            } else {
                if (strtolower($type) == 'plugin') {
                    $this->moduleRegistry->deactivateModule($slug);
                }
            }
            session()->put('deactivating_module', new ModuleKey($type, $slug));

            return redirect()->route('module-manager.index');
        } catch (\Exception $e) {
            admin_notice('warning',
                $type .
                ' - ' .
                $slug .
                ' gagal diaktifkan:' . $e->getMessage()
            );
            return redirect()->route('module-manager.index');
        }
    }
}
