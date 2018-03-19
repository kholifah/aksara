<?php
namespace Aksara\Facades;

use Illuminate\Support\Facades\Facade;

class PluginRegistryFacade extends Facade
{
    protected static function getFacadeAccessor()
    {
        return 'plugin_registry';
    }
}


