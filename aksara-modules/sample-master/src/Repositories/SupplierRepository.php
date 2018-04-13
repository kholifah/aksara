<?php

namespace Plugins\SampleMaster\Repositories;

use Aksara\Support\Contracts\HttpCrudRepository;
use Aksara\TableView\TableRepository;
use Aksara\Support\Traits\EloquentRepository;
use Plugins\SampleMaster\Models\Supplier;
use Illuminate\Http\Request;

class SupplierRepository implements HttpCrudRepository, TableRepository
{
    use EloquentRepository;

    public function __construct(Supplier $model)
    {
        $this->model = $model;
    }
}
