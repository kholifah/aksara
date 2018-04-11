<?php
namespace Aksara\Facades;

use Illuminate\Support\Facades\Facade;

class AksaraRouteFacade extends Facade
{
    protected static function getFacadeAccessor()
    {
        return 'aksara_router';
    }
}


