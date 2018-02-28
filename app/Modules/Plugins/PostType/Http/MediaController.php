<?php
namespace App\Modules\Plugins\PostType\Http;

use App\Http\Controllers\Controller;
use App\Modules\Plugins\PostType\Media;
use Illuminate\Http\Request;

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
