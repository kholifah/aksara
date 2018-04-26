<?php

namespace Plugins\SampleTransaction\Presenters;

use Aksara\TableView\Presenter\BasicTablePresenter;
use Aksara\TableView\Presenter\Components\DefaultSearch;
use Aksara\TableView\Presenter\Components\DefaultFilter;
use Aksara\TableView\Presenter\Components\DefaultViewFilter;
use Plugins\SampleMaster\Repositories\SupplierRepository;

class PurchaseOrderTablePresenter extends BasicTablePresenter
{
    use DefaultSearch;
    use DefaultFilter;
    use DefaultViewFilter;

    protected $searchable = [
        'document_number',
    ];

    protected $defaultSortColumn = 'id';

    public function __construct(SupplierRepository $supplierRepo)
    {
        $this->supplierRepo = $supplierRepo;
        parent::__construct();
    }

    public function getSortable()
    {
        return [
            'document_number',
            'supplier' => function ($model, $order) {
                return $model->join(
                    'suppliers', 'suppliers.id', 'purchase_orders.supplier_id')
                    ->orderBy('suppliers.supplier_name', $order);
            },
            'total_amount',
            'order_date',
            'estimated_delivery_date',
        ];
    }

    protected function getColumns()
    {
        return [
            'document_number' => __('sample-transaction::po.labels.document_number'),
            'supplier' => [
                'label' => __('sample-transaction::po.labels.supplier'),
                'formatter' => function ($value) {
                    return $value->supplier_name;
                },
            ],
            'supplier_phone' => __('sample-transaction::po.labels.supplier_phone'),
            'order_date' => [
                'label' => __('sample-transaction::po.labels.order_date'),
                'formatter' => function ($value) {
                    return $value->formatLocalized('%d %B %Y');
                },
            ],
            'estimated_delivery_date' => [
                'label' => __('sample-transaction::po.labels.estimated_delivery_date'),
                'formatter' => function ($value) {
                    return $value->formatLocalized('%d %B %Y');
                },
            ],
            'total_amount' => __('sample-transaction::po.labels.total_amount'),
        ];
    }

    protected function getEditUrl($identifier)
    {
        return route('sample-po-edit', $identifier);
    }

    public function getDateRangeFilters()
    {
        return [
            'order_date',
        ];
    }

    protected function renderViewFilters($table)
    {
        $statusFilter = [
            'all' => __('sample-transaction::po.labels.all'),
            'draft' => __('sample-transaction::po.labels.draft'),
            'applied' => __('sample-transaction::po.labels.applied'),
            'void' => __('sample-transaction::po.labels.void'),
        ];
        $this->renderDefaultViewFilter($table, $statusFilter);
    }

    protected function renderFilters($table)
    {
        $this->renderDateRangeFilter($table, 'order_date',
            __('sample-transaction::po.labels.order_date')
        );

        $this->renderDefaultSearch($table);
    }
}


