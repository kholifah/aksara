<?php

namespace Plugins\SampleMaster\Http\Controllers;

use Aksara\TableView\Controller\AbstractTableController;
use Plugins\SampleMaster\Repositories\ProductRepository;
use Plugins\SampleMaster\Presenters\ProductTablePresenter;

class ProductTable extends AbstractTableController
{
    public function __construct(
        ProductRepository $repo,
        ProductTablePresenter $table
    ){
        parent::__construct($repo, $table);
    }

    public function filterPastExpired($model)
    {
        return $model->where('date_expired', '<', date('Y-m-d'));
    }

    public function filterNotExpired($model)
    {
        return $model->where('date_expired', '>=', date('Y-m-d'));
    }

    public function filterCriticalStock($model)
    {
        return $model->where('stock', '<', 100);
    }

    public function filterExceedingStock($model)
    {
        return $model->where('stock', '>', 1000);
    }
}

