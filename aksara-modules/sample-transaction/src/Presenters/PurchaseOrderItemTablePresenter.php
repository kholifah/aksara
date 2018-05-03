<?php

namespace Plugins\SampleTransaction\Presenters;

use Aksara\TableView\Presenter\BasicTablePresenter;
use Aksara\TableView\Presenter\Components\DestroyBulkAction;

class PurchaseOrderItemTablePresenter extends BasicTablePresenter
{
    use DestroyBulkAction;

    protected $inputPrefix = 'item';

    protected function getColumns()
    {
        return [
            'product_name' => __('sample-transaction::po.labels.product'),
            'qty' => __('sample-transaction::po.labels.qty'),
            'unit_price' => [
                'label' => __('sample-transaction::po.labels.unit_price'),
                'formatter' => function ($unit_price) {
                    return number_format($unit_price, 2);
                },
            ],
            'discount' => [
                'label' => __('sample-transaction::po.labels.discount'),
                'formatter' => function ($discount) {
                    return sprintf('%d %%', $discount);
                },
            ],
            'sub_total' => [
                'label' => __('sample-transaction::po.labels.sub_total'),
                'formatter' => function ($sub_total) {
                    return number_format($sub_total, 2);
                },
            ],
        ];
    }

    protected function registerActions(&$actions)
    {
        $this->registerDeleteAction($actions);
    }
}

