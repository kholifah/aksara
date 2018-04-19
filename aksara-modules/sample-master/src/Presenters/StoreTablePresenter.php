<?php

namespace Plugins\SampleMaster\Presenters;

use Aksara\TableView\Presenter\BasicTablePresenter;
use Aksara\TableView\Presenter\Concerns\DefaultSearch;
use Aksara\TableView\Presenter\Concerns\DefaultFilter;

class StoreTablePresenter extends BasicTablePresenter
{
    use DefaultSearch;
    use DefaultFilter;

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
        $this->addFilter('all', __('sample-master::supplier.labels.all'));
        $this->addFilter('active', __('sample-master::supplier.labels.active'));
        $this->addFilter('inactive', __('sample-master::supplier.labels.inactive'));

        \Eventy::addAction('tableview.form_filter', function ($table) {
            $this->renderDefaultFilter($table);
            $this->renderDefaultSearch($table);
        });
    }

    protected function getFilterViews()
    {
        return ['all', 'active'];
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
