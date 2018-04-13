<?php

namespace Plugins\SampleMaster\Repositories;

use Aksara\Support\Contracts\HttpCrudRepository;
use Aksara\TableView\TableRepository;
use Aksara\Support\Traits\EloquentRepository;
use Plugins\SampleMaster\Models\Product;

class ProductRepository implements HttpCrudRepository, TableRepository
{
    use EloquentRepository;

    public function __construct(Product $model)
    {
        $this->model = $model;
    }
}


