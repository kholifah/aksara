<?php

namespace Plugins\SampleTransaction\Http\Controllers;

use Aksara\TableView\Controller\AbstractTableController;
use Plugins\SampleTransaction\Repositories\PurchaseOrderItemRepository;
use Plugins\SampleTransaction\Presenters\PurchaseOrderItemTablePresenter;
use Plugins\SampleTransaction\Models\PurchaseOrder;

class PurchaseOrderItemTable extends AbstractTableController
{
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
