<?php
namespace App\Modules\Plugins\ImageService;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class ImageServiceController extends Controller
{
    /** @var Media */
    private $resizer;

    public function __construct(
        Resizer $resizer
    ){
        $this->resizer = $resizer;
    }

    public function serve(Request $request)
    {
        $path = $request->path();
        $resized = $this->resizer->resize($path);

        if (!file_exists($resized)) {
            abort(404,'file not found');
        }

        return redirect($resized);
    }
}

