<?php

namespace Plugins\SampleTransaction\Presenters;

use Aksara\TableView\Presenter\BasicTablePresenter;
use Aksara\TableView\Presenter\Components\DefaultSearch;
use Aksara\TableView\Presenter\Components\DefaultFilter;
use Plugins\SampleMaster\Repositories\SupplierRepository;

class PurchaseOrderTablePresenter extends BasicTablePresenter
{
    use DefaultSearch;
    use DefaultFilter;

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
            'total_amount' => __('sample-transaction::po.labels.total_amount'),
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
            'status' => __('sample-transaction::po.labels.status'),
        ];
    }

    protected function getEditUrl($identifier)
    {
        return route('sample-po-edit', $identifier);
    }

    protected function getDeleteUrl($identifier)
    {
        return route('sample-po-destroy', $identifier);
    }

    private function getCallbackFilters()
    {
        $statusFilter = [
            'draft' => __('sample-transaction::po.labels.draft'),
            'applied' => __('sample-transaction::po.labels.applied'),
            'void' => __('sample-transaction::po.labels.void'),
        ];
        return [
            'status_filter' => $statusFilter,
        ];
    }

    /**
     * @returns array [ $id => $label ]
     */
    public function getColumnFilters()
    {
        $suppliers = $this->supplierRepo->all();
        $supplierFilter = [];

        foreach ($suppliers as $supplier) {
            $supplierFilter[$supplier->id] = $supplier->supplier_name;
        }

        //format: column_name => filter key value pair
        $columnFilters = [
            'supplier_id' => $supplierFilter,
        ];

        return $columnFilters;
    }

    protected function renderFilters($table)
    {
        $callbackFilters = $this->getCallbackFilters();

        foreach ($callbackFilters as $callbackFilter) {
            $this->renderDropDownFilter($table, $callbackFilter);
        }

        $columnFilters = $this->getColumnFilters();

        foreach (array_keys($columnFilters) as $columnName) {
            $this->renderDropDownColumnFilter($table, $columnName);
        }

        $this->renderFilterButton($table);
        $this->renderDefaultSearch($table);
    }
}


