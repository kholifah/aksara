<?php

namespace Plugins\SampleTransaction\Http\Controllers;

use Aksara\TableView\Controller\AbstractTableController;
use Plugins\SampleTransaction\Repositories\PurchaseOrderRepository;
use Plugins\SampleTransaction\Presenters\PurchaseOrderTablePresenter;

class PurchaseOrderTable extends AbstractTableController
{
    public function __construct(
        PurchaseOrderRepository $repo,
        PurchaseOrderTablePresenter $table
    ){
        parent::__construct($repo, $table);
    }

    public function filterDraft($model)
    {
        return $model->where('is_applied', false)->where('is_void', false);
    }

    public function filterApplied($model)
    {
        return $model->where('is_applied', true)->where('is_void', false);
    }

    public function filterVoid($model)
    {
        return $model->where('is_void', true);
    }
}


