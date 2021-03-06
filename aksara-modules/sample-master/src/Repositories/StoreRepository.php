<?php

namespace Plugins\SampleMaster\Repositories;

use Aksara\Support\Contracts\HttpCrudRepository;
use Aksara\TableView\TableRepository;
use Aksara\Support\EloquentRepository;
use Illuminate\Http\Request;
use Plugins\SampleMaster\Models\Store;

class StoreRepository
    extends EloquentRepository implements HttpCrudRepository, TableRepository
{
    public function __construct(Store $model)
    {
        $this->model = $model;
    }
}

