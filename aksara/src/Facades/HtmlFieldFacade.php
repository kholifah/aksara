<?php
namespace Aksara\Facades;

use Illuminate\Support\Facades\Facade;

class HtmlFieldFacade extends Facade
{
    protected static function getFacadeAccessor()
    {
        return 'field_factory';
    }
}


