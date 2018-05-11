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

    protected function getEditUrl($identifier)
    {
        return route('sample-product-edit', $identifier);
    }

    protected function canDelete($identifier = null)
    {
        //removing product from store requires edit store access
        return has_capability('edit-master-store');
    }

    protected function canEdit($identifier = null)
    {
        //direct link to product master, should have edit product access
        return has_capability('edit-master-product');
    }

    protected function registerActions(&$actions)
    {
        $this->registerDeleteAction($actions);
    }
}

