<?php

namespace Plugins\SampleMaster\Presenters;

use Aksara\TableView\Presenter\BasicTablePresenter;
use Aksara\TableView\Presenter\Components\DefaultSearch;
use Aksara\TableView\Presenter\Components\DefaultFilter;
use Aksara\TableView\Presenter\Components\DefaultViewFilter;

class StoreTablePresenter extends BasicTablePresenter
{
    use DefaultSearch;
    use DefaultFilter;
    use DefaultViewFilter;

    protected $searchable = [
        'store_name',
        'store_phone',
    ];

    protected $defaultSortColumn = 'id';

    protected function getColumns()
    {
        return [
            'store_name' => __('sample-master::store.labels.name'),
            'store_phone' => __('sample-master::store.labels.phone'),
            'is_active' => [
                'label' => __('sample-master::store.labels.active'),
                'formatter' => function ($value) {
                    return $value ? 'Yes' : 'No';
                },
            ]
        ];
    }

    protected function renderViewFilters($table)
    {
        $filterView = [
            'all' => __('sample-master::store.labels.all'),
            'active' => __('sample-master::store.labels.active'),
        ];
        $this->renderDefaultViewFilter($table, $filterView);
    }

    protected function renderFilters($table)
    {
        $statusFilter = [
            'all' => __('sample-master::store.labels.all'),
            'active' => __('sample-master::store.labels.active'),
            'inactive' => __('sample-master::store.labels.inactive'),
        ];

        $this->renderDropDownFilter($table, $statusFilter,
            __('sample-master::store.labels.all_status'));

        $this->renderFilterButton($table);
        $this->renderDefaultSearch($table);
    }

    protected function getEditUrl($identifier)
    {
        return route('sample-store-edit', $identifier);
    }

    protected function getDeleteUrl($identifier)
    {
        return route('sample-store-destroy', $identifier);
    }
}

