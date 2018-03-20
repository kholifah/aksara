<?php
namespace Plugins\ImageService\Drivers;

use Plugins\ImageService\ImageManagerContract;
use Plugins\ImageService\FileContract;
use Intervention\Image\ImageManager;
use Mimey\MimeTypes;

class Intervention implements ImageManagerContract
{
    private $mimes;
    private $imgManager;
    private $file;

    public function __construct(
        MimeTypes $mimes,
        ImageManager $imgManager,
        FileContract $file
    ){
        $this->mimes = $mimes;
        $this->imgManager = $imgManager;
        $this->file = $file;
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
        $extension = $this->file->extension($path);
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
