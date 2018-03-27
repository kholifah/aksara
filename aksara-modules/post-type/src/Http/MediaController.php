<?php
namespace Plugins\PostType\Http;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Plugins\PostType\MediaUpload\MediaUploadInterface;

class MediaController extends Controller
{
    private $uploader;

    public function __construct(MediaUploadInterface $uploader)
    {
        $this->uploader = $uploader;
    }

    public function mediaManager()
    {
        aksara_media_uploader();
        return view('post-type::media.upload');
    }

    public function upload(Request $request)
    {
        $response = $this->uploader->handle($request);
        return $response;
    }

}
