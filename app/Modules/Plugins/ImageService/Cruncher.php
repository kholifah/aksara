<?php
namespace App\Modules\Plugins\ImageService;

use Intervention\Image\ImageManager;
use Mimey\MimeTypes;

class Cruncher
{
    private $mimes;
    private $imgManager;
    private $imgConfig;

    public function __construct(
        MimeTypes $mimes,
        ImageManager $imgManager,
        ImageSizeConfig $imgConfig
    ){
        $this->mimes = $mimes;
        $this->imgManager = $imgManager;
        $this->imgConfig = $imgConfig;
    }


    private function isCrunchable($path)
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

    public function crunch($path)
    {
        if (!$this->isCrunchable($path)) {
            return false;
        }

        // Check if it is registered image
        preg_match("/([0-9]*)x([0-9]*)(.*)\./", $path, $matches);

        // not a custom image size pattern
        if(!isset($matches[0])) {
            return false;
        }
        $pathExtraPart = $matches[0];

        $trail = $matches[3];
        if (!empty($trail)) {
            return false;
        }

        $originalPath = base_path()
            .'/public/'
            . str_replace("-{$pathExtraPart}", ".", $path);

        // Check original file exist
        if( !file_exists($originalPath) ) {
            return false;
        }

        $path = base_path().'/public/'.$path;

        $matches = str_replace(".","",$matches[0]);
        $matches = explode("x", $matches);

        $width = $matches[0];
        $height = $matches[1];

        list($imageSizes, $imageSizeId) = $this->imgConfig->getRegisteredImage($width, $height);

        if (!$imageSizeId) {
            return false;
        }

        $aspectRatio = $imageSizes[$imageSizeId]['aspect_ratio'];

        if( $imageSizes[$imageSizeId]['width'] == 0 || $imageSizes[$imageSizeId]['width'] == false ) {
            $imageSizes[$imageSizeId]['width'] =  $aspectRatio == true ? null : 9000;
        }

        if( $imageSizes[$imageSizeId]['height'] == 0 || $imageSizes[$imageSizeId]['height'] == false ) {
            $imageSizes[$imageSizeId]['height'] =  $aspectRatio == true ? null : 9000;
        }

        // Mulai INTERVENSI :D
        try {
            $image = $this->imgManager->make($originalPath);
            // Hard Crop
            if( $aspectRatio) {
                $image->resize($imageSizes[$imageSizeId]['width'], $imageSizes[$imageSizeId]['height'],function($constraint) {
                    $constraint->aspectRatio();
                    $constraint->upsize();
                });
            }
            elseif( $imageSizes[$imageSizeId]['crop'] == true ) {
                $image->fit($imageSizes[$imageSizeId]['width'], $imageSizes[$imageSizeId]['height'],function($constraint) {
                    // $constraint->aspectRatio();
                    $constraint->upsize();
                });
            }
            else {
                $image->crop($imageSizes[$imageSizeId]['width'], $imageSizes[$imageSizeId]['height'],function($contsraint) {
                    $constraint->aspectRatio();
                });
            }


            // finally we save the image as a new file
            $image->save($path);
        }
        catch (\Exception $e) {
            throw new \Exception("Image resize failed : $e");
        }

        return $path;

    }
}

