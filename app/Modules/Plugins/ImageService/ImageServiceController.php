<?php
namespace App\Modules\Plugins\ImageService;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\File;
use Illuminate\Http\Request;
use Mimey\MimeTypes;

class ImageServiceController extends Controller
{
    /** @var Media */
    private $mimes;
    private $resizer;

    public function __construct(
        MimeTypes $mimes,
        Resizer $resizer
    ){
        $this->mimes = $mimes;
        $this->resizer = $resizer;
    }

    public function serve(Request $request)
    {
        $path = $request->path();

        $extension = \File::extension($path);
        $mime = $this->mimes->getMimeType($extension);
        $path = $this->resizer->resize($path);

        if (!file_exists($path)) {
            abort(404,'file not found');
        }

        header("Content-Type: ".$mime);
        readfile($path); // Reading the file into the output buffer
        exit;
    }
}

