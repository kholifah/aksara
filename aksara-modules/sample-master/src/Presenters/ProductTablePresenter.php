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
                'formatter' => function ($value) {
                    return $value->supplier_name;
                },
            ],
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
        \Eventy::addFilter($this->getActionFilterName('column_filter'), function () {

            $suppliers = $this->supplierRepo->all();
            $supplierFilter = [];

            foreach ($suppliers as $supplier) {
                $supplierFilter[$supplier->id] = $supplier->supplier_name;
            }

            $columnFilters = [
                'supplier_id' => $supplierFilter,
            ];

            return $columnFilters;
        });

        \Eventy::addAction($this->getActionFilterName('form_filter'), function ($table) {
            $expiredFilter = [
                'past_expired' => __('sample-master::product.labels.past_expired'),
                'not_expired' => __('sample-master::product.labels.not_expired'),
            ];

            $stockFilter = [
                'critical_stock' => __('sample-master::product.labels.critical_stock'),
                'exceeding_stock' => __('sample-master::product.labels.exceeding_stock'),
            ];
            $this->renderDropDownFilter($table, $expiredFilter);
            $this->renderDropDownFilter($table, $stockFilter);
        });
    }
}

