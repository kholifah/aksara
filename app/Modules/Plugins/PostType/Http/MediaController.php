<?php
namespace App\Modules\Plugins\PostType\Http;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\File;


class MediaController extends Controller
{
        public function mediaManager()
       {
           aksara_media_uploader();
           return view('plugin:post-type::media.upload');
       }
       public function upload(Request $request)
       {
          $mediaUpload = new \App\Modules\Plugins\PostType\MediaUpload($request);

          $response = $mediaUpload->handle();

          return $response;
       }

       function serveImage()
       {
           $path = \Request::path();

           $media = \App::make('App\Modules\Plugins\PostType\Media');

           $path = $media->generateImageSize($path);

           if (!file_exists($path)) {
               abort(404,'file not found');
           }

           // get extension
           $extension = \File::extension($path);

           $mimes = new \Mimey\MimeTypes;

           // Convert extension to MIME type:
           $mime = $mimes->getMimeType($extension); // application/json

           header("Content-Type: ".$mime);
           readfile($path); // Reading the file into the output buffer
           exit;

       }

}
