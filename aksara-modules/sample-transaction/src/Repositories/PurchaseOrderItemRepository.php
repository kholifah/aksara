<?php

namespace Plugins\SampleTransaction\Repositories;

use Aksara\TableView\TableRepository;
use Aksara\Support\EloquentRepository;
use Plugins\SampleTransaction\Models\PurchaseOrder;

class PurchaseOrderItemRepository
    extends EloquentRepository implements TableRepository
{
    public function setParentModel(PurchaseOrder $po)
    {
        $this->model = $po->items();
    }
}




