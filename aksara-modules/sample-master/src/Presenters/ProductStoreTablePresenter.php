<?php

namespace Plugins\SampleMaster\Presenters;

use Aksara\TableView\BasicTablePresenter;

class ProductStoreTablePresenter extends BasicTablePresenter
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

    protected $inputPrefix = 'product';

    protected function getColumns()
    {
        return [
            'name' => __('sample-master::product.labels.name'),
            'code' => __('sample-master::product.labels.code'),
        ];
    }

    protected function getEditUrl($identifier)
    {
        return route('sample-product-edit', $identifier);
    }
}


