<?php

namespace Plugins\SampleMaster\Presenters;

use Aksara\TableView\BasicTablePresenter;

class SupplierTablePresenter extends BasicTablePresenter
{
    protected function getColumns()
    {
        return [
            'supplier_name' => __('sample-master::supplier.labels.name'),
            'supplier_phone' => __('sample-master::supplier.labels.phone'),
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
}
