<?php
namespace Aksara\Facades;

use Illuminate\Support\Facades\Facade;

class AssetQueueFacade extends Facade
{
    protected static function getFacadeAccessor()
    {
        return 'asset_queue';
    }
}




