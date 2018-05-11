<?php

namespace Plugins\SampleMaster\Capabilities;

use Plugins\SampleMaster\Repositories\ProductRepository;

class DeleteProduct
{
    private $productRepo;

    public function __construct(ProductRepository $productRepo)
    {
        $this->productRepo = $productRepo;
    }

    public function can($productId)
    {
        $product = $this->productRepo->find($productId);

        if ($product->created_by == \Auth::user()->id) {
            return true;
        }
        return false;
    }

}


