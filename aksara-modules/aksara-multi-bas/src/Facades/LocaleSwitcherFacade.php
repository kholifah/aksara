<?php
namespace Plugins\AksaraMultiBas\Facades;

use Illuminate\Support\Facades\Facade;

class LocaleSwitcherFacade extends Facade
{
    protected static function getFacadeAccessor()
    {
        return 'locale_switcher';
    }
}
