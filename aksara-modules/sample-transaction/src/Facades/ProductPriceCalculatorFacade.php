<?php
namespace Plugins\SampleTransaction\Facades;

use Illuminate\Support\Facades\Facade;

class ProductPriceCalculatorFacade extends Facade
{
    protected static function getFacadeAccessor()
    {
        return 'price_calc';
    }
}

