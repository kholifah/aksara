<?php
namespace Plugins\PostType\Facades;

use Illuminate\Support\Facades\Facade;

class PermalinkFacade extends Facade
{
    protected static function getFacadeAccessor()
    {
        return 'permalink';
    }
}

