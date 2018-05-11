<?php

namespace Plugins\SampleMaster\Capabilities;

use Plugins\SampleMaster\Repositories\SupplierRepository;

class EditSupplier
{
    private $supplierRepo;

    public function __construct(SupplierRepository $supplierRepo)
    {
        $this->supplierRepo = $supplierRepo;
    }

    public function can($supplierId)
    {
        $supplier = $this->supplierRepo->find($supplierId);

        if ($supplier->created_by == \Auth::user()->id) {
            return true;
        }
        return false;
    }

}
