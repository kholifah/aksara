<?php
namespace Plugins\AksaraMultiBas\Facades;

use Illuminate\Support\Facades\Facade;

class TranslationEngineFacade extends Facade
{
    protected static function getFacadeAccessor()
    {
        return 'translation_engine';
    }
}

