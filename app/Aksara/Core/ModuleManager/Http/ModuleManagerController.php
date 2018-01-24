<?php
namespace App\Aksara\Core\ModuleManager\Http;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Aksara\Core\Module;
use Aksara\ModuleActivationCheckInfo;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

class ModuleManagerController extends Controller
{
    private $module;

    public function __construct(Module $module)
    {
        $this->module = $module;
    }

    public function index()
    {
        $module = $this->module;
        $module->moduleStatusChangeListener();

        $param = compact('module');

        return view('core:module-manager::index', $param)->render();
    }

    //TODO: refactor to separate module dependency resolver
    private function resolveDependency($modules, $type, $slug)
    {
        if (!isset($modules[$type][$slug])) {
            throw new NotFoundHttpException('Module not found');
        }
        $module = $modules[$type][$slug];
        if (isset($module['dependencies']) && !empty($module['dependencies'])) {
            $childDeps = [];
            foreach ($module['dependencies'] as $dep) {
                $childDep = $this->resolveDependency(
                    $modules,
                    'plugin',
                    $dep
                );
                if (!empty($childDep)) {
                    $childDeps = array_merge($childDeps, $childDep);
                }
            }
            $result = array_merge($module['dependencies'], $childDeps);
            return $result;
        }
        return [];
    }

    public function activationCheck($type, $slug)
    {
        $modules = config('aksara.modules');
        if (!isset($modules[$type][$slug])) {
            throw new NotFoundHttpException('Module not found');
        }
        $dependencies = $this->resolveDependency($modules, $type, $slug);

        //TODO get migration commands recursively
        $migrations = [];

        $data = new ModuleActivationCheckInfo(
            $type,
            $slug,
            $dependencies,
            []
        );

        //render activation-check page
        return view('core:module-manager::activation-check', $data->toArray());
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
