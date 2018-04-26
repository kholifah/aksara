<?php

namespace Plugins\SampleMaster\Http\Controllers;

use Aksara\TableView\Controller\AbstractTableController;
use Aksara\TableView\Controller\Concerns\HasDestroyAction;
use Plugins\SampleMaster\Repositories\ProductStoreRepository;
use Plugins\SampleMaster\Presenters\ProductStoreTablePresenter;
use Plugins\SampleMaster\Models\Store;

class ProductStoreTable extends AbstractTableController
{
    use HasDestroyAction;

    public function __construct(
        ProductStoreRepository $repo,
        ProductStoreTablePresenter $table
    ){
        parent::__construct($repo, $table);
    }

    public function setParentModel(Store $store)
    {
        $this->repo->setParentModel($store);
    }
}


