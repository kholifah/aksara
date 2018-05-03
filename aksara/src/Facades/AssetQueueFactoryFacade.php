<?php
namespace Aksara\Facades;

use Illuminate\Support\Facades\Facade;

class AssetQueueFactoryFacade extends Facade
{
    protected static function getFacadeAccessor()
    {
        return 'asset_queue_factory';
    }
}

