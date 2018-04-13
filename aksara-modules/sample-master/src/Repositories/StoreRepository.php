<?php

namespace Plugins\SampleMaster\Repositories;

use Aksara\Support\Contracts\HttpCrudRepository;
use Aksara\TableView\TableRepository;
use Aksara\Support\Traits\EloquentRepository;
use Plugins\SampleMaster\Models\Store;

class StoreRepository implements HttpCrudRepository, TableRepository
{
    use EloquentRepository;

    public function __construct(Store $model)
    {
        $this->model = $model;
    }
}

