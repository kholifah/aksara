<?php
namespace Plugins\PostType\Http;

use App\Http\Controllers\Controller;
use Plugins\PostType\Media;
use Illuminate\Http\Request;

class MediaController extends Controller
{
    public function mediaManager()
    {
        aksara_media_uploader();
        return view('post-type::media.upload');
    }

    public function upload(Request $request)
    {
        $mediaUpload = new \Plugins\PostType\MediaUpload($request);

        $response = $mediaUpload->handle();

        return $response;
    }

}
