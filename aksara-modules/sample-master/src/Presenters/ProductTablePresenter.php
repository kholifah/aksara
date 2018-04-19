<?php

namespace Plugins\SampleMaster\Presenters;

use Aksara\TableView\BasicTablePresenter;

class ProductTablePresenter extends BasicTablePresenter
{
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
}

