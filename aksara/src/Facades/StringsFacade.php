<?php
namespace Aksara\Facades;

use Illuminate\Support\Facades\Facade;

class StringsFacade extends Facade
{
    protected static function getFacadeAccessor()
    {
        return 'support_strings';
    }
}

