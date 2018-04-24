<?php

namespace Plugins\SampleTransaction\Presenters;

use Plugins\SampleMaster\Repositories\SupplierRepository;
use Plugins\SampleMaster\Repositories\ProductRepository;
use Plugins\SampleTransaction\Http\Controllers\PurchaseOrderItemTable;
use Plugins\SampleTransaction\Repositories\PurchaseOrderRepository;
use Illuminate\Http\Request;
use Illuminate\Http\RedirectResponse;

class PurchaseOrderForm
{
    private $supplierRepo;
    private $productRepo;
    private $poRepo;
    private $itemTable;

    public function __construct(
        SupplierRepository $supplierRepo,
        ProductRepository $productRepo,
        PurchaseOrderRepository $poRepo,
        PurchaseOrderItemTable $itemTable
    ){
        $this->supplierRepo = $supplierRepo;
        $this->productRepo = $productRepo;
        $this->poRepo = $poRepo;
        $this->itemTable = $itemTable;
    }

    public function create()
    {
        $po = $this->poRepo->new();
        return $this->getCommonParams($po);
    }

    private function getCommonParams($po)
    {
        $suppliers = $this->supplierRepo->all();
        $supplierArray = [];

        foreach ($suppliers as $supplier) {
            $supplierArray[$supplier->id] = $supplier->supplier_name;
        }

        return [
            'po' => $po,
            'suppliers' => $supplierArray,
        ];
    }

    public function edit($id, Request $request)
    {
        $po = $this->poRepo->find($id);
        if (!$po) {
            abort(404, 'Not Found');
        }

        $viewData = $this->getCommonParams($po);

        $products = $this->productRepo->filterColumn(
            'supplier_id',
            $po->supplier_id
        )->get();

        $productArray = [];

        foreach ($products as $product) {
            $productArray[$product->id] = $product->name;
        }

        $this->itemTable->setParentModel($po);
        $table = $this->itemTable->handle($request);

        if ($table instanceof RedirectResponse) {
            return $table;
        }

        $editViewData = [
            'products' => $productArray,
            'table' => $table,
        ];

        return array_merge($viewData, $editViewData);
    }
}
