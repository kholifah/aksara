<?php
namespace Plugins\PostType\Facades;

use Illuminate\Support\Facades\Facade;

class MetaboxFacade extends Facade
{
    protected static function getFacadeAccessor()
    {
        return 'metabox';
    }
}



