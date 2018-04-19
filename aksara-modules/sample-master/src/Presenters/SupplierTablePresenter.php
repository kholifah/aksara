<?php

namespace Plugins\SampleMaster\Presenters;

use Aksara\TableView\BasicTablePresenter;

class SupplierTablePresenter extends BasicTablePresenter
{
    protected $searchable = [
        'supplier_name',
    ];

    protected $defaultSortColumn = 'id';

    protected function getColumns()
    {
        return [
            'supplier_name' => __('sample-master::supplier.labels.name'),
            'supplier_phone' => __('sample-master::supplier.labels.phone'),
            'is_active' => [
                'label' => __('sample-master::supplier.labels.active'),
                'formatter' => function ($value) {
                    return $value ? 'Yes' : 'No';
                },
            ]
        ];
    }

    protected function getEditUrl($identifier)
    {
        return route('sample-supplier-edit', $identifier);
    }

    protected function getDeleteUrl($identifier)
    {
        return route('sample-supplier-destroy', $identifier);
    }

    /**
     * tambahkan filters di sini
     *
     * masing-masing key harus ada korespondensi dengan function filter di
     * table controller
     * misal untuk filter `all` maka harus ada method `filterAll`
     * perhatikan snake case akan diubah ke camel case
     */
    protected function getFilters()
    {
        return [
            'all' => __('sample-master::supplier.labels.all'),
            'active' => __('sample-master::supplier.labels.active'),
            'inactive' => __('sample-master::supplier.labels.inactive'),
        ];
    }

    /**
     * contoh cara extend bulk action
     *
     * key dari action harus dibuat methodnya di table controller
     * misal untuk action `sesuatu_aksi` maka harus ada method `actionSesuatuAksi`
     * perhatikan snake case akan diubah ke camel case
     */
    protected function getBulkActionOptions()
    {
        $options = parent::getBulkActionOptions();

        $merged = array_merge($options, [
            'sesuatu_aksi' => 'Aksi tambahan',
        ]);

        return $merged;
    }

}
