<?php

namespace Plugins\SampleMaster\Presenters;

use Aksara\TableView\Presenter\BasicTablePresenter;
use Aksara\TableView\Presenter\Components\DefaultSearch;

class ProductStoreTablePresenter extends BasicTablePresenter
{
    use DefaultSearch;

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


