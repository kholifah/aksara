<?php
namespace App\Modules\Plugins\PostType;

use Intervention\Image\ImageManager as ImageManager;
use Mimey\MimeTypes;

class Media
{
    private $mimes;

    public function __construct(MimeTypes $mimes)
    {
        $this->mimes = $mimes;
    }

    public function init()
    {
        \Eventy::addAction('aksara.init', [$this,'registerPostType'], 20);
        \Eventy::addAction('aksara.init', [$this,'registerRoute'], 20);
        // add route
        \Eventy::addAction('aksara.routes.admin', function () {
            \Route::get('media/upload', ['as'=>'admin.media.upload-view','uses'=>'\App\Modules\Plugins\PostType\Http\MediaController@mediaManager']);
            \Route::post('media/upload', ['as'=>'admin.media.upload','uses'=>'\App\Modules\Plugins\PostType\Http\MediaController@upload']);
        });
    }

    public function registerPostType()
    {
        $post = \App::make('post');

        // Register Post
        $argsPost = [
            'label' => [
                'name' => 'Media'
            ],
            'priority'=>20,
            'icon' => 'ti-gallery',
            'publicly_queryable'=>false,
            'supports' => []
        ];

        $post->registerPostType('media', $argsPost);
        remove_admin_sub_menu('admin.media.create');
    }

    public function registerRoute()
    {
        $pathArray = [];

        // register assets path with depth of 10 folder
        for ($i=1;$i<=10;$i++) {
            $path = '{path_'.$i.'}';

            array_push($pathArray, $path);

            $pathRegisterRoute = implode('/', $pathArray);

            \Route::get('/uploads/{year}/{month}/'.$pathRegisterRoute, '\App\Modules\Plugins\PostType\Http\MediaController@serveImage');
        }
    }

    public function enqueueScript()
    {
        // only embed one times
        if (\Config::get('aksara_media_uploader', false)) {
            return;
        }
        \Config::set('aksara_media_uploader', true);

        aksara_admin_enqueue_script(url('assets/modules/Plugins/PostType/js/media-uploader.js'), 'aksara-media-uploader', 20, true);
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
        $imageSizes = \Config::get('aksara.post-type.image-sizes',[]);

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

        \Config::set('aksara.post-type.image-sizes',$imageSizes);

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

    function generateImageSize($path)
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

        $imageSizes = \Config::get('aksara.post-type.image-sizes',[]);
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
            $image = new ImageManager(array('driver' => 'gd'));
            $image = $image->make($originalPath);
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
                    // $constraint->upsize();
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
