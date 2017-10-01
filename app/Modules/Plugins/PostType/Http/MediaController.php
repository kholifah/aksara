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

}
