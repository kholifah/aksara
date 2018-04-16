<?php

namespace Plugins\SampleMaster\Repositories;

use Aksara\Support\Contracts\HttpCrudRepository;
use Aksara\TableView\TableRepository;
use Aksara\Support\EloquentRepository;
use Plugins\SampleMaster\Models\Product;

class ProductRepository
    extends EloquentRepository implements HttpCrudRepository, TableRepository
{
    public function __construct(Product $model)
    {
        $this->model = $model;
    }
}


