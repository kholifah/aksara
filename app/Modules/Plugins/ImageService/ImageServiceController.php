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
    private $cruncher;

    public function __construct(
        MimeTypes $mimes,
        Cruncher $cruncher
    ){
        $this->mimes = $mimes;
        $this->cruncher = $cruncher;
    }

    public function serve(Request $request)
    {
        $path = $request->path();

        $extension = \File::extension($path);
        $mime = $this->mimes->getMimeType($extension);
        $path = $this->cruncher->crunch($path);

        if (!file_exists($path)) {
            abort(404,'file not found');
        }

        header("Content-Type: ".$mime);
        readfile($path); // Reading the file into the output buffer
        exit;
    }
}

