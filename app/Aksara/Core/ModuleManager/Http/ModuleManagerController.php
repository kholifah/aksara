<?php
namespace App\Aksara\Core\ModuleManager\Http;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class ModuleManagerController extends Controller
{
    public function index()
    {
        $module = \App::make('module');
        $module->moduleStatusChangeListener();

        $param = compact('module');

        return view('core:module-manager::index', $param)->render();
    }

    public function activate($type, $slug)
    {
        $module = \App::make('module');

        $module->initActivation($slug,$type);

        return redirect()->route('module-manager.activation-info', ['slug'=>$slug,'type'=>$type]);
    }

    // Test plugin activation and admin rendering
    public function activationInfo($type, $slug)
    {
        $activatedModule = \get_options('module_activation', false);

        $module = \App::make('module');
        $module->moduleStatusChangeListener();

        // failed
        if (!$activatedModule || !$module->getModuleStatus($activatedModule['moduleType'], $activatedModule['moduleName'])) {
            return redirect()->route('module-manager.index');
        }

        // success
        return view('core:module-manager::activation-info', compact('activatedModule'))->render();
    }

    public function deactivate($type,$slug)
    {
        $module = \App::make('module');

        $module->initDeactivation($slug, $type);

        return redirect()->route('module-manager.index');
    }
}
