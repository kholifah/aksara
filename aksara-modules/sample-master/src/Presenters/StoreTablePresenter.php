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

    protected function registerFilters()
    {
        $statusFilter = [
            'all' => __('sample-master::store.labels.all'),
            'active' => __('sample-master::store.labels.active'),
            'inactive' => __('sample-master::store.labels.inactive'),
        ];

        \Eventy::addAction('tableview.form_filter', function ($table) use (
            $statusFilter) {
            $this->renderDropDownFilter($table, $statusFilter);
            $this->renderFilterButton($table);
            $this->renderDefaultSearch($table);
        });

        $filterView = [
            'all' => __('sample-master::store.labels.all'),
            'active' => __('sample-master::store.labels.active'),
        ];

        \Eventy::addAction('tableview.view_filter', function () use (
            $filterView) {
            $this->renderDefaultViewFilter($filterView);
        });
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

