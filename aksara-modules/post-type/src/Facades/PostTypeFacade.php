<?php
namespace Plugins\PostType\Facades;

use Illuminate\Support\Facades\Facade;

class PostTypeFacade extends Facade
{
    protected static function getFacadeAccessor()
    {
        return 'post';
    }
}



