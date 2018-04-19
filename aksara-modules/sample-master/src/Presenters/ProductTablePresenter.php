<?php

namespace Plugins\SampleMaster\Presenters;

use Aksara\TableView\Presenter\BasicTablePresenter;
use Aksara\TableView\Presenter\Concerns\DefaultSearch;
use Aksara\TableView\Presenter\Concerns\DefaultFilter;

class ProductTablePresenter extends BasicTablePresenter
{
    use DefaultSearch;
    use DefaultFilter;

    protected $searchable = [
        'name',
        'code',
    ];

    protected $sortable = [
        'name',
        'code',
        'stock',
        'price',
        'date_expired',
    ];

    protected $defaultSortColumn = 'id';

    protected function getColumns()
    {
        return [
            'name' => __('sample-master::product.labels.name'),
            'code' => __('sample-master::product.labels.code'),
            'stock' => __('sample-master::product.labels.stock'),
            'price' => __('sample-master::product.labels.price'),
            'date_expired' => [
                'label' => __('sample-master::product.labels.date_expired'),
                'formatter' => function ($value) {
                    return $value->formatLocalized('%d %B %Y');
                },
            ],
        ];
    }

    protected function getEditUrl($identifier)
    {
        return route('sample-product-edit', $identifier);
    }

    protected function getDeleteUrl($identifier)
    {
        return route('sample-product-destroy', $identifier);
    }

    protected function registerFilters()
    {
        $expiredFilter = [
            'past_expired' => __('sample-master::product.labels.past_expired'),
            'not_expired' => __('sample-master::product.labels.not_expired'),
        ];

        $stockFilter = [
            'critical_stock' => __('sample-master::product.labels.critical_stock'),
            'exceeding_stock' => __('sample-master::product.labels.exceeding_stock'),
        ];

        \Eventy::addAction('tableview.form_filter', function ($table) use (
            $expiredFilter, $stockFilter) {
            $this->renderDefaultFilter($table, $expiredFilter);
            $this->renderDefaultFilter($table, $stockFilter, 1);
            $this->renderDefaultSearch($table);
        });
    }
}

