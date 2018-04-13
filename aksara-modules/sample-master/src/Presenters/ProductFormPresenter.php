<?php

namespace Plugins\SampleMaster\Presenters;

use Plugins\SampleMaster\Repositories\SupplierRepository;

class ProductFormPresenter
{
    private $supplierRepo;

    public function __construct(SupplierRepository $supplierRepo)
    {
        $this->supplierRepo = $supplierRepo;
    }

    public function create($product)
    {
        $suppliers = $this->supplierRepo->all();
        $supplierArray = [];

        foreach ($suppliers as $supplier) {
            $supplierArray[$supplier->id] = $supplier->supplier_name;
        }

        return [
            'product' => $product,
            'suppliers' => $supplierArray,
        ];
    }
}
