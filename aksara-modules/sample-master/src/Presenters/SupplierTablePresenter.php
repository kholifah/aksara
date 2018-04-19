<?php

namespace Plugins\SampleMaster\Presenters;

use Aksara\TableView\Presenter\BasicTablePresenter;

class SupplierTablePresenter extends BasicTablePresenter
{
    protected $searchable = [
        'supplier_name',
    ];

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
    protected function registerFilters()
    {
        /**
         * function addFilter
         *
         * @param $key
         * @param $label
         */
        $this->addFilter('all', __('sample-master::supplier.labels.all'));
        $this->addFilter('active', __('sample-master::supplier.labels.active'));
        $this->addFilter('inactive', __('sample-master::supplier.labels.inactive'));
    }

    protected function getFilterViews()
    {
        /**
         * apabila method ini di-override,
         * maka dari filter yang diregistrasikan di atas
         * hanya akan ditampilkan yang didaftarkan di sini
         */
        return ['all', 'active'];
    }

    /**
     * contoh cara extend bulk action
     *
     * key dari action harus dibuat methodnya di table controller
     * misal untuk action `sesuatu_aksi` maka harus ada method `actionSesuatuAksi`
     * perhatikan snake case akan diubah ke camel case
     */
    protected function registerActions()
    {
        /**
         * function addAction
         *
         * @param $key
         * @param $label
         */
        $this->addAction('sesuatu_aksi', 'Aksi Tambahan');
    }

}
