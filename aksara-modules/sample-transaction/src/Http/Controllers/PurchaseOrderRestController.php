<?php

namespace Plugins\SampleTransaction\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Plugins\SampleTransaction\ProductPriceCalculator;

class PurchaseOrderRestController extends Controller
{
    private $calculator;

    public function __construct(ProductPriceCalculator $calculator)
    {
        $this->calculator = $calculator;
    }

    public function getPriceInfo(Request $request)
    {
        $price = $this->calculator->calculate(
            $request->get('product_id') ?? 0,
            $request->get('qty'),
            $request->get('discount')
        );

        return response()->json($price);
    }
}
