<?php
namespace App\Modules\Plugins\PostType;

use Aksara\Repository\ConfigRepository;
use Intervention\Image\ImageManager;
use Mimey\MimeTypes;

class AksaraImageResize
{
    private $mimes;
    private $imgManager;

    public function __construct(
        MimeTypes $mimes,
        ImageManager $imgManager,
        ConfigRepository $config
    ){
        $this->mimes = $mimes;
        $this->imgManager = $imgManager;
        $this->config = $config;
    }

    public function registerRoute()
    {
        $pathArray = [];

        // register assets path with depth of 10 folder
        for ($i=1;$i<=10;$i++) {
            $path = '{path_'.$i.'}';

            array_push($pathArray, $path);

            $pathRegisterRoute = implode('/', $pathArray);

            $serveImagePath = '/uploads/'.$pathRegisterRoute;

            \Route::get($serveImagePath, '\App\Modules\Plugins\PostType\Http\MediaController@serveImage');
        }
    }

    /**
     * [registerImageSize description]
     * @param  string  $name   Image size id
     * @param  integer $width  Image width
     * @param  integer $height Image height
     * @param  boolean $crop   Crop center on Image
     * @param  boolean $aspectRatio   Preserve aspect ratio
     * @return boolean
     */
    public function registerImageSize($name, $width = 0, $height = 0, $crop = true, $aspectRatio = true)
    {
        $imageSizes = $this->config->get('aksara.post-type.image-sizes',[]);

        if( $width == 0 && $height == 0 ) {
            throw new \Exception('Width and height of image size must be greater than 0');
        }

        $name = aksara_slugify($name);

        $imageSizes[$name] = [
            'width' => $width,
            'height' => $height,
            'crop'  => $crop,
            'aspect_ratio'=> $aspectRatio
        ];

        $this->config->set('aksara.post-type.image-sizes',$imageSizes);

        return true;
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

    public function resize($path)
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

        \Log::info("Extra: $pathExtraPart");
        \Log::info("Original: $originalPath");

        // Check original file exist
        if( !file_exists($originalPath) ) {
            return false;
        }

        $path = base_path().'/public/'.$path;

        $matches = str_replace(".","",$matches[0]);
        $matches = explode("x", $matches);

        $imageSizes = $this->config->get('aksara.post-type.image-sizes',[]);
        $imageSizeId = false;

        foreach ($imageSizes as $imageSizeKey => $imageSize) {
            if ($imageSize['width'] == $matches[0]
                && $imageSize['height'] == $matches[1]) {
                $imageSizeId = $imageSizeKey;
            }
        }

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
