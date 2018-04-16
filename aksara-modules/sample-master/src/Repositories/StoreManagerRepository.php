<?php

namespace Plugins\SampleMaster\Repositories;

use Aksara\Support\Contracts\HttpCrudRepository;
use Aksara\TableView\TableRepository;
use Aksara\Support\EloquentRepository;
use Plugins\SampleMaster\Models\StoreManager;

class StoreManagerRepository
    extends EloquentRepository implements HttpCrudRepository, TableRepository
{
    public function __construct(StoreManager $model)
    {
        $this->model = $model;
    }
}


