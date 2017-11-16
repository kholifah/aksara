<?php
namespace App\Modules\Plugins\PostType\Http;

use App\Http\Controllers\Controller;
use App\Modules\Plugins\PostType\Media;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;
use Mimey\MimeTypes;

class MediaController extends Controller
{
    /** @var Media */
    private $media;
    private $mimes;

    public function __construct(Media $media, MimeTypes $mimes)
    {
        $this->media = $media;
        $this->mimes = $mimes;
    }

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

    public function serveImage()
    {
        $path = \Request::path();

        $extension = \File::extension($path);
        $mime = $this->mimes->getMimeType($extension);
        $path = $this->media->generateImageSize($path);

        if (!file_exists($path)) {
            abort(404,'file not found');
        }

        header("Content-Type: ".$mime);
        readfile($path); // Reading the file into the output buffer
        exit;
    }

}
