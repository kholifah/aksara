<?php

namespace Plugins\SampleMaster\Repositories;

use Aksara\TableView\TableRepository;
use Aksara\Support\EloquentRepository;
use Plugins\SampleMaster\Models\Store;

class ProductStoreRepository
    extends EloquentRepository implements TableRepository
{
    public function setParentModel(Store $store)
    {
        $this->model = $store->products();
    }

    public function delete($id)
    {
        return $this->model->detach($id);
    }
}



