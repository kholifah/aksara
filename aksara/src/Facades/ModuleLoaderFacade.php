<?php
namespace Aksara\Facades;

use Illuminate\Support\Facades\Facade;

class ModuleLoaderFacade extends Facade
{
    protected static function getFacadeAccessor()
    {
        return 'module_loader';
    }
}



