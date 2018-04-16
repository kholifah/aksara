<?php

namespace Plugins\SampleMaster\Repositories;

use Aksara\Support\Contracts\HttpCrudRepository;
use Aksara\TableView\TableRepository;
use Aksara\Support\EloquentRepository;
use Plugins\SampleMaster\Models\Supplier;

class SupplierRepository
    extends EloquentRepository implements HttpCrudRepository, TableRepository
{
    public function __construct(Supplier $model)
    {
        $this->model = $model;
    }
}
