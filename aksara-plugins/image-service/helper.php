<?php

use Plugins\ImageService\ImageSize;
use Plugins\ImageService\ImageSizeConfig;

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
    $size = new ImageSize($name, $width, $height, $crop, $aspectRatio);
    return \ImageConfig::registerImageSize($size);
}

function get_image_size($id, $imageUrl)
{
    return \ImageConfig::getImageSize($id, $imageUrl);
}

function get_resized_image($url)
{
    return \ImageService::resize($url);
}

