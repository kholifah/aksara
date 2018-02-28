<?php
namespace App\Modules\Plugins\ImageService;

use Aksara\Repository\ConfigRepository;

class ImageSizeConfig
{
    private $config;

    public function __construct(
        ConfigRepository $config
    ){
        $this->config = $config;
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

    public function getImageSize($id, $imageUrl)
    {
        $imageSizes = $this->config->get('aksara.post-type.image-sizes',[]);
        if( !isset($imageSizes[$id]) )
            return $imageUrl;

        $pos = strrpos($imageUrl, '.');
        return substr($imageUrl, 0, $pos) .
            "-{$imageSizes[$id]['width']}x{$imageSizes[$id]['height']}" .
            substr($imageUrl, $pos);
    }

    public function getRegisteredImage(string $width, string $height)
    {
        $imageSizes = $this->config->get('aksara.post-type.image-sizes',[]);
        $imageSizeId = false;

        foreach ($imageSizes as $imageSizeKey => $imageSize) {
            if ($imageSize['width'] == $width
                && $imageSize['height'] == $height) {
                $imageSizeId = $imageSizeKey;
            }
        }

        if (!$imageSizeId) {
            return false;
        }

        return array ($imageSizes, $imageSizeId);
    }
}
