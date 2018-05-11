<?php

namespace Plugins\SampleTransaction\Capabilities;

use Plugins\SampleTransaction\Repositories\PurchaseOrderRepository;

class EditPurchaseOrder
{
    private $poRepo;

    public function __construct(PurchaseOrderRepository $poRepo)
    {
        $this->poRepo = $poRepo;
    }

    public function can($poId)
    {
        $po = $this->poRepo->find($poId);

        if ($po->created_by == \Auth::user()->id) {
            return true;
        }
        return false;
    }

}


