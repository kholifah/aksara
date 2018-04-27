<?php

namespace Plugins\SampleTransaction;

use Plugins\SampleMaster\Repositories\ProductRepository;

class ProductPriceCalculator
{
    private $repo;
    private $calculator;

    public function __construct(
        ProductRepository $repo,
        PriceCalculator $calculator
    ){
        $this->repo = $repo;
        $this->calculator = $calculator;
    }

    public function calculate($productId, $qty = 0, $discount = 0)
    {
        $product = $this->repo->find($productId);
        if (!$product) {
            return $this->calculator->empty();
        }

        return $this->calculator->calculate($product->price, $qty, $discount);
    }
}
