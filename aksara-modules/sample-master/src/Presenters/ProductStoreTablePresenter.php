<?php

namespace Plugins\SampleMaster\Presenters;

use Aksara\TableView\Presenter\BasicTablePresenter;
use Aksara\TableView\Presenter\Components\DefaultSearch;
use Aksara\TableView\Presenter\Components\DestroyBulkAction;

class ProductStoreTablePresenter extends BasicTablePresenter
{
    use DefaultSearch;
    use DestroyBulkAction;

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

    protected function renderFilters($table)
    {
        $this->renderDefaultSearch($table);
    }

    protected function registerActions(&$actions)
    {
        $this->registerDeleteAction($actions);
    }
}

