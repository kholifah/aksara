<?php
namespace App\Modules\Plugins\ImageService;

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
    public function registerImageSize(ImageSize $size)
    {
        $imageSizes = $this->config->get('aksara.post-type.image-sizes',[]);

        if ($size->getWidth() == 0 && $size->getHeight() == 0) {
            throw new \Exception(
                'Width and height of image size must be greater than 0');
        }

        $sizeArray = $size->toArray();

        $this->config->set('aksara.post-type.image-sizes',
            array_merge($imageSizes, $sizeArray)
        );

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

    public function getRegisteredImage(Size $size)
    {
        $width = $size->getWidth();
        $height = $size->getHeight();

        $imageSizes = $this->config->get('aksara.post-type.image-sizes',[]);
        $imageSizeId = false;

        foreach ($imageSizes as $imageSizeKey => $imageSize) {
            if ($imageSize['width'] == $size->getWidth()
                && $imageSize['height'] == $size->getHeight()) {
                $imageSizeId = $imageSizeKey;
            }
        }

        if (!$imageSizeId) {
            return false;
        }

        return ImageSize::fromArray($imageSizeId, $imageSizes[$imageSizeId]);
    }
}
