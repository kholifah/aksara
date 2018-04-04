<?php
namespace App\Aksara\Core\Asset\Http;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Aksara\ModuleRegistry\ModuleRegistryHandler;

class StaticFileController extends Controller
{
    public function __construct(ModuleRegistryHandler $moduleRegistry)
    {
        $this->moduleRegistry = $moduleRegistry;
    }

    public function serveV2($module_name)
    {
        if (!$this->moduleRegistry->isRegistered($module_name)) {
            abort(404,'file not found');
            die();
        }

        $module = $this->moduleRegistry->getManifest($module_name);

        $routeParams = \Route::getCurrentRoute()->parameters();
        unset($routeParams['module_name']);
        $pathAsset = implode('/', $routeParams);

        $realPath = $module->getModulePath()->asset() . '/' . $pathAsset;
        $this->readFile($realPath);
    }

    public function serveV1($module_type, $module_name)
    {
        if ( str_contains(\Request::url(), '/Admin/') || str_contains(\Request::url(), '/FrontEnd/')  ) {
            $path = '/Modules/Themes/'.$module_type.'/'.$module_name.'/assets/';
        } else {
            $path = '/Modules/'.$module_type.'/'.$module_name.'/assets/';
        }

        $routeParams = \Route::getCurrentRoute()->parameters();

        unset($routeParams['module_type']);
        unset($routeParams['module_name']);

        $pathAsset = implode('/', $routeParams);

        // Security
        $pathAsset = str_replace('..', '', $pathAsset);

        // full path
        $path = $path.$pathAsset;
        $realPath = app_path().$path;

        $this->readFile($realPath);
    }

    private function readFile($realPath)
    {
        if (!file_exists($realPath)) {
            abort(404,'file not found');
            die();
        }

        $extension = \File::extension($realPath);

        $mimes = new \Mimey\MimeTypes;

        $mime = $mimes->getMimeType($extension); // application/json

        header("Content-Type: ".$mime);
        readfile($realPath); // Reading the file into the output buffer
        exit;
    }
}
