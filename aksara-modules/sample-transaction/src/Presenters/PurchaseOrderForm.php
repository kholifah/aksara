<?php

namespace Plugins\SampleTransaction\Presenters;

use Plugins\SampleMaster\Repositories\SupplierRepository;

class PurchaseOrderForm
{
    private $supplierRepo;

    public function __construct(SupplierRepository $supplierRepo)
    {
        $this->supplierRepo = $supplierRepo;
    }

    public function create($purchaseOrder)
    {
        $suppliers = $this->supplierRepo->all();
        $supplierArray = [];

        foreach ($suppliers as $supplier) {
            $supplierArray[$supplier->id] = $supplier->supplier_name;
        }

        return [
            'po' => $purchaseOrder,
            'suppliers' => $supplierArray,
        ];
    }
}
