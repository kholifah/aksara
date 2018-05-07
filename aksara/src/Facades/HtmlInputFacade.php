<?php
namespace Aksara\Facades;

use Illuminate\Support\Facades\Facade;

class HtmlInputFacade extends Facade
{
    protected static function getFacadeAccessor()
    {
        return 'html_input_factory';
    }
}


