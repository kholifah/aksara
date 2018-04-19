<?php

namespace Plugins\SampleMaster\Presenters;

use Aksara\TableView\Presenter\BasicTablePresenter;
use Aksara\TableView\Presenter\Concerns\DefaultSearch;

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

    protected function registerFilters()
    {
        \Eventy::addAction('tableview.form_filter', function ($table) {
            $this->renderDefaultSearch($table);
        });
    }
}


