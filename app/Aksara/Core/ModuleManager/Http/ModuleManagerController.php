<?php
namespace App\Aksara\Core\ModuleManager\Http;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Aksara\Core\Module;

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
