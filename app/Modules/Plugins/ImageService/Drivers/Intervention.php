<?php
namespace App\Modules\Plugins\ImageService\Drivers;

use App\Modules\Plugins\ImageService\ImageManagerContract;
use Intervention\Image\ImageManager;
use Mimey\MimeTypes;

class Intervention implements ImageManagerContract
{
    private $mimes;
    private $imgManager;

    public function __construct(
        MimeTypes $mimes,
        ImageManager $imgManager
    ){
        $this->mimes = $mimes;
        $this->imgManager = $imgManager;
    }

    public function make($imagePath)
    {
        if (!$this->isSupported($imagePath)) {
            return false;
        }

        return $this->imgManager->make($imagePath);
    }

    private function isSupported($path)
    {
        $extension = \File::extension($path);
        $mime = $this->mimes->getMimeType($extension);

        $supported = [
            'image/jpeg',
            'image/png',
            'image/gif',
            'image/webp',
        ];

        if (in_array($mime, $supported)) {
            return true;
        }

        return false;
    }
}
