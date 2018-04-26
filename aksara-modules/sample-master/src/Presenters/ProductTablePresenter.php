<?php

namespace Plugins\SampleMaster\Presenters;

use Aksara\TableView\Presenter\BasicTablePresenter;
use Aksara\TableView\Presenter\Components\DefaultSearch;
use Aksara\TableView\Presenter\Components\DefaultFilter;
use Plugins\SampleMaster\Repositories\SupplierRepository;

class ProductTablePresenter extends BasicTablePresenter
{
    use DefaultSearch;
    use DefaultFilter;

    public function __construct(SupplierRepository $supplierRepo)
    {
        $this->supplierRepo = $supplierRepo;
        parent::__construct();
    }

    protected $searchable = [
        'name',
        'code',
    ];

    public function getSortable()
    {
        return  [
            'name',
            'supplier' => function ($model, $order) {
                return $model->join(
                    'suppliers', 'suppliers.id', 'products.supplier_id')
                    ->orderBy('suppliers.supplier_name', $order);
            },
            'code',
            'stock',
            'price',
            'date_expired',
        ];
    }

    protected $defaultSortColumn = 'id';

    protected function getColumns()
    {
        return [
            'name' => __('sample-master::product.labels.name'),
            'supplier' => [
                'label' => __('sample-master::product.labels.supplier'),
                'formatter' => function ($supplier) {
                    return $supplier->supplier_name;
                },
            ],
            'code' => __('sample-master::product.labels.code'),
            'stock' => __('sample-master::product.labels.stock'),
            'price' => __('sample-master::product.labels.price'),
            'date_expired' => [
                'label' => __('sample-master::product.labels.date_expired'),
                'formatter' => function ($date_expired) {
                    return $date_expired->formatLocalized('%d %B %Y');
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

    //use as callback
    protected function renderFilters($table)
    {
        $expiredFilter = [
            'past_expired' => __('sample-master::product.labels.past_expired'),
            'not_expired' => __('sample-master::product.labels.not_expired'),
        ];

        $stockFilter = [
            'critical_stock' => __('sample-master::product.labels.critical_stock'),
            'exceeding_stock' => __('sample-master::product.labels.exceeding_stock'),
        ];

        $this->renderDropDownFilter($table, $expiredFilter,
            __('sample-master::product.labels.all_expiry_status'));
        $this->renderDropDownFilter($table, $stockFilter,
            __('sample-master::product.labels.all_stock_status'));

        $this->renderDropDownColumnFilter($table, 'supplier_id',
            __('sample-master::product.labels.all_supplier'));

        $this->renderFilterButton($table);
        $this->renderDefaultSearch($table);
    }

    protected function registerActions()
    {
        $this->addAction('destroy', __('tableview.labels.delete'));
    }
}

