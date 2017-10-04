<?php
namespace App\Aksara\Core\Asset\Http;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class StaticFileController extends Controller
{
    public function serve($module_type, $module_name)
    {
        // if( $routeParams['module_type'] == 'plugins' )
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

        if (!file_exists($realPath)) {
            abort(404,'file not found');
        }

        // get extension
        $extension = \File::extension($realPath);

        $mimes = new \Mimey\MimeTypes;

        // Convert extension to MIME type:
        $mime = $mimes->getMimeType($extension); // application/json

        header("Content-Type: ".$mime);
        readfile($realPath); // Reading the file into the output buffer
        exit;
    }
}
