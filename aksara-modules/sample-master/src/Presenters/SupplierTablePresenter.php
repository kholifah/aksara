<?php

namespace Plugins\SampleMaster\Presenters;

use Aksara\TableView\Presenter\BasicTablePresenter;
use Aksara\TableView\Presenter\Components\DefaultSearch;
use Aksara\TableView\Presenter\Components\DefaultFilter;
use Aksara\TableView\Presenter\Components\DefaultViewFilter;
use Aksara\TableView\Presenter\Components\DestroyBulkAction;

class SupplierTablePresenter extends BasicTablePresenter
{
    use DefaultSearch;
    use DefaultFilter;
    use DefaultViewFilter;
    use DestroyBulkAction;

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

    protected function canDelete()
    {
        return has_capability('delete-master-supplier');
    }

    protected function canEdit()
    {
        return has_capability('edit-master-supplier');
    }

    protected function renderViewFilters($table)
    {
        $filterView = [
            'all' => __('sample-master::supplier.labels.all'),
            'active' => __('sample-master::supplier.labels.active'),
        ];
        $this->renderDefaultViewFilter($table, $filterView);
    }

    protected function renderFilters($table)
    {
        $statusFilter = [
            'active' => __('sample-master::supplier.labels.active'),
            'inactive' => __('sample-master::supplier.labels.inactive'),
        ];

        $this->renderDropDownFilter($table, $statusFilter,
            __('sample-master::supplier.labels.all_status'));

        $this->renderFilterButton($table);
        $this->renderDefaultSearch($table);
    }

    /**
     * contoh cara extend bulk action
     *
     * key dari action harus dibuat methodnya di table controller
     * misal untuk action `sesuatu_aksi` maka harus ada method `actionSesuatuAksi`
     * perhatikan snake case akan diubah ke camel case
     */
    protected function registerActions(&$actions)
    {
        $this->registerDeleteAction($actions);
        $actions['sesuatu_aksi'] = 'Aksi Tambahan';
    }

}
