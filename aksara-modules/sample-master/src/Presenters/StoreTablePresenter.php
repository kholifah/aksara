<?php

namespace Plugins\SampleMaster\Presenters;

use Aksara\TableView\BasicTablePresenter;

class StoreTablePresenter extends BasicTablePresenter
{
    protected $searchable = [
        'store_name',
    ];

    protected $defaultSortColumn = 'id';

    protected function getColumns()
    {
        return [
            'store_name' => __('sample-master::store.labels.name'),
            'store_phone' => __('sample-master::store.labels.phone'),
        ];
    }

    protected $baseRoute = 'sample-store';

    protected function getEditUrl($identifier)
    {
        return route('sample-store-edit', $identifier);
    }

    protected function getDeleteUrl($identifier)
    {
        return route('sample-store-destroy', $identifier);
    }
}

