<?php
namespace Plugins\PostType\Facades;

use Illuminate\Support\Facades\Facade;

class MediaFacade extends Facade
{
    protected static function getFacadeAccessor()
    {
        return 'media';
    }
}


