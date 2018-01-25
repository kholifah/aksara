<?php
namespace App\Aksara\Core\ModuleManager\Http;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Aksara\Core\Module;
use Aksara\ModuleActivationCheckInfo;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Aksara\ModuleStatus\ModuleStatus;

class ModuleManagerController extends Controller
{
    private $module;
    private $moduleStatus;

    public function __construct(
        Module $module,
        ModuleStatus $moduleStatus
    ){
        $this->module = $module;
        $this->moduleStatus = $moduleStatus;
    }

    public function index()
    {
        $module = $this->module;
        $module->moduleStatusChangeListener();

        $param = compact('module');

        return view('core:module-manager::index', $param)->render();
    }

    public function activationCheck($type, $slug)
    {
        $modules = config('aksara.modules');

        if (!isset($modules[$type][$slug])) {
            throw new NotFoundHttpException('Module not found');
        }

        //TODO: refactor to separate module dependency resolver
        $dependenciesInfo = $this->getDependenciesRecursive(
            $modules, $type, $slug
        );

        //TODO: refactor to separate migration resolver
        $migrations = $this->getPendingMigrations($type, $slug, $dependenciesInfo);

        $data = new ModuleActivationCheckInfo(
            $type,
            $slug,
            $dependenciesInfo,
            $migrations
        );

        return view('core:module-manager::activation-check', $data->toArray());
    }

    private function getPendingMigrations($type, $slug, $dependenciesInfo)
    {
        $selfMigrations = [];
        if (!migration_complete($type, $slug)) {
            $selfMigrations = migration_path($type, $slug);
        }
        $depsMigrations = [];

        foreach ($dependenciesInfo as $dependencyInfo) {
            if (migration_complete(
                $dependencyInfo->getType(),
                $dependencyInfo->getModuleName()
            )){
                continue;
            }
            $depsMigration = migration_path(
                $dependencyInfo->getType(),
                $dependencyInfo->getModuleName()
            );
            $depsMigrations = array_merge($depsMigrations, $depsMigration);
        }

        return array_merge($selfMigrations, $depsMigrations);
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
            $modules = config('aksara.modules');

            if (!isset($modules[$type][$slug])) {
                throw new NotFoundHttpException('Module not found');
            }

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
                $type, $slug, $dependenciesInfo);

            if (count($pendingMigrations) > 0) {
                throw new \Exception('Pending migration found');
            }

            $module = $modules[$type][$slug];
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
                if (!$this->module->activateModule(
                    $itemToBeActivated->getType(),
                    $itemToBeActivated->getModuleName())
                ){
                    //rollback
                    foreach ($activated as $itemActivated) {
                        $this->module->deactivateModule(
                            $itemActivated->getType(),
                            $itemActivated->getModuleName()
                        );
                    }
                    //raise error
                    throw new \Exception('Error occured when activating module');
                }
                $activated[] = $itemToBeActivated;
            }

            foreach ($activated as $itemActivated) {
                admin_notice('success',
                    $itemActivated->getType() .
                    ' - ' .
                    $itemActivated->getModuleName() .
                    ' berhasil diaktifkan.'
                );
            }
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

    public function activate($type, $slug)
    {
        $this->module->initActivation($slug,$type);

        return redirect()->route('module-manager.activation-info', [
            'slug'=>$slug,'type'=>$type]);
    }

    // Test plugin activation and admin rendering
    public function activationInfo($type, $slug)
    {
        $activatedModule = \get_options('module_activation', false);
        $this->module->moduleStatusChangeListener();

        // failed
        if (!$activatedModule || !$this->module->getModuleStatus(
            $activatedModule['moduleType'],
            $activatedModule['moduleName'])
        ){
            return redirect()->route('module-manager.index');
        }

        // success
        return view('core:module-manager::activation-info',
            compact('activatedModule'))->render();
    }

    public function deactivate($type,$slug)
    {
        $this->module->initDeactivation($slug, $type);

        return redirect()->route('module-manager.index');
    }
}
