<?php

namespace Plugins\SampleMaster\Http\Controllers;

use Aksara\TableView\AbstractTableController;
use Plugins\SampleMaster\Repositories\ProductStoreRepository;
use Plugins\SampleMaster\Presenters\ProductStoreTablePresenter;
use Plugins\SampleMaster\Models\Store;

class ProductStoreTable extends AbstractTableController
{
    protected $searchable = [
        'name',
        'code',
    ];

    protected $sortable = [
        'name',
        'code',
    ];

    protected $defaultSortColumn = 'name';

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


