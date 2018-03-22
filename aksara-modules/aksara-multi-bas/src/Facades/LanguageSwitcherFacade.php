<?php
namespace Plugins\AksaraMultiBas\Facades;

use Illuminate\Support\Facades\Facade;

class LanguageSwitcherFacade extends Facade
{
    protected static function getFacadeAccessor()
    {
        return 'language_switcher';
    }
}
