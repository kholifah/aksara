<?php
namespace Plugins\ImageService\Facades;

use Illuminate\Support\Facades\Facade;

class ImageConfig extends Facade
{
    protected static function getFacadeAccessor()
    {
        return self::class;
    }
}
