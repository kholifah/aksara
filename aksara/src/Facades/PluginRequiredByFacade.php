<?php
namespace Aksara\Facades;

use Illuminate\Support\Facades\Facade;

class PluginRequiredByFacade extends Facade
{
    protected static function getFacadeAccessor()
    {
        return 'plugin_required_by';
    }
}





