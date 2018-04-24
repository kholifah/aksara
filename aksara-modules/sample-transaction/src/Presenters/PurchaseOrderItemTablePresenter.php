<?php

namespace Plugins\SampleTransaction\Presenters;

use Aksara\TableView\Presenter\BasicTablePresenter;
use Aksara\TableView\Presenter\Components\DefaultSearch;

class PurchaseOrderItemTablePresenter extends BasicTablePresenter
{
    protected $inputPrefix = 'item';

    protected function getColumns()
    {
        return [
            'product_name' => __('sample-transaction::po.labels.product'),
            'qty' => __('sample-transaction::po.labels.qty'),
            'unit_price' => __('sample-transaction::po.labels.unit_price'),
            'discount' => __('sample-transaction::po.labels.discount'),
            'sub_total' => __('sample-transaction::po.labels.sub_total'),
        ];
    }
}

