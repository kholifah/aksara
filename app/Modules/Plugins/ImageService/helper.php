<?php

use App\Modules\Plugins\ImageService\ImageSize;
use App\Modules\Plugins\ImageService\ImageSizeConfig;

/**
 * [registerImageSize description]
 * @param  string  $name   Image size id
 * @param  integer $width  Image width
 * @param  integer $height Image height
 * @param  boolean $crop   Crop center on Image
 * @param  boolean $aspectRatio   Preserve aspect ratio
 * @return boolean
 */
function register_image_size($name, $width = 0, $height = 0, $crop = true, $aspectRatio = true)
{
    $config = app(ImageSizeConfig::class);
    return $config->registerImageSize($name, $width, $height, $crop, $aspectRatio );
}

function get_image_size($id, $imageUrl)
{
    $config = app(ImageSizeConfig::class);
    return $config->getImageSize($id, $imageUrl);
}

