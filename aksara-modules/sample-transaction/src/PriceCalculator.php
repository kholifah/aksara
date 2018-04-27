<?php

namespace Plugins\SampleTransaction;

class PriceCalculator
{
    public function empty()
    {
        return [
            'sub_total' => 0,
            'unit_price' => 0,
        ];
    }

    public function calculate($price, $qty = 0, $discount = 0)
    {
        if (is_null($qty)) {
            $qty = 0;
        }
        if (is_null($discount)) {
            $discount = 0;
        }
        $grossTotal = $qty * $price;
        $discount = $grossTotal * ($discount / 100);
        return [
            'sub_total' => $grossTotal - $discount,
            'unit_price' => $price,
        ];
    }

}
