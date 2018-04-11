<?php
namespace Aksara\Facades;

use Illuminate\Support\Facades\Facade;

class AdminMenuFacade extends Facade
{
    protected static function getFacadeAccessor()
    {
        return 'admin_menu';
    }
}

