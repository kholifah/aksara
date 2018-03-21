<?php
namespace Aksara\Facades;

use Illuminate\Support\Facades\Facade;

class AssetRendererFacade extends Facade
{
    protected static function getFacadeAccessor()
    {
        return 'asset_renderer';
    }
}



