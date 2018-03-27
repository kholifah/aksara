<?php
namespace Plugins\PostType\Facades;

use Illuminate\Support\Facades\Facade;

class FrontEndFacade extends Facade
{
    protected static function getFacadeAccessor()
    {
        return 'posttype_frontend';
    }
}


