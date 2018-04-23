<?php

namespace Plugins\SampleTransaction\Repositories;

use Aksara\Support\Contracts\HttpCrudRepository;
use Aksara\TableView\TableRepository;
use Aksara\Support\EloquentRepository;
use Plugins\SampleTransaction\Models\PurchaseOrder;

class PurchaseOrderRepository
    extends EloquentRepository implements TableRepository, HttpCrudRepository
{
    public function __construct(PurchaseOrder $model)
    {
        $this->model = $model;
    }
}
