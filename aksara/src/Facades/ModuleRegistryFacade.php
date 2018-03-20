<?php
namespace Aksara\Facades;

use Illuminate\Support\Facades\Facade;

class ModuleRegistryFacade extends Facade
{
    protected static function getFacadeAccessor()
    {
        return 'module_registry';
    }
}


