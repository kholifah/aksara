<?php
namespace App\Aksara\Core\ModuleManager\Http;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class ModuleManagerController extends Controller
{
  function index()
  {
    $module = \App::make('module');
    $param = compact('module');

    return view('core:module-manager::index',$param)->render();
  }

  function activate(Request $request, $slug)
  {
    $module = \App::make('module');

    $module->initActivation($slug);

    return redirect()->route('module-manager.activation-info',['slug'=>$slug]);
  }

  // Test plugin activation and admin rendering
  function activationInfo(Request $reqeuest,$slug)
  {
    $activatedModule = \get_options('module_activation',false);

    $module = \App::make('module');

    // failed
    if( !$activatedModule || !$module->getModuleStatus($activatedModule['moduleType'],$activatedModule['moduleName']) )
        return redirect()->route('module-manager.index');

    // success
    return view('core:module-manager::activation-info',compact('activatedModule'))->render();
  }

  function deactivate($slug)
  {
    $module = \App::make('module');

    if( $module->deactivateModule('plugin',$slug) )
        admin_notice('success',$slug.' deactivated');

    return redirect()->route('module-manager.index');
  }
}
