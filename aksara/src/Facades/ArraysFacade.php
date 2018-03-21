<?php
namespace Aksara\Facades;

use Illuminate\Support\Facades\Facade;

class ArraysFacade extends Facade
{
    protected static function getFacadeAccessor()
    {
        return 'support_arrays';
    }
}

