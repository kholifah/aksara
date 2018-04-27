<?php

namespace Plugins\SampleTransaction\Http\Controllers;

use Aksara\TableView\Controller\AbstractTableController;
use Aksara\TableView\Controller\Concerns\HasDestroyAction;
use Plugins\SampleTransaction\Repositories\PurchaseOrderItemRepository;
use Plugins\SampleTransaction\Presenters\PurchaseOrderItemTablePresenter;
use Plugins\SampleTransaction\Models\PurchaseOrder;

class PurchaseOrderItemTable extends AbstractTableController
{
    use HasDestroyAction;

    public function __construct(
        PurchaseOrderItemRepository $repo,
        PurchaseOrderItemTablePresenter $table
    ){
        parent::__construct($repo, $table);
    }

    public function setParentModel(PurchaseOrder $po)
    {
        $this->repo->setParentModel($po);
    }
}
