<?php

namespace Plugins\SampleMaster\Presenters;

use Plugins\SampleMaster\Repositories\StoreRepository;
use Plugins\SampleMaster\Repositories\ProductRepository;
use Plugins\SampleMaster\Http\Controllers\ProductStoreTable;
use Illuminate\Http\Request;
use Illuminate\Http\RedirectResponse;

class StoreFormPresenter
{
    private $storeRepo;
    private $productRepo;
    private $tableController;

    public function __construct(
        StoreRepository $storeRepo,
        ProductRepository $productRepo,
        ProductStoreTable $tableController
    ){
        $this->storeRepo = $storeRepo;
        $this->productRepo = $productRepo;
        $this->tableController = $tableController;
    }

    public function create()
    {
        $store = $this->storeRepo->new();
        $manager = $store->manager;

        return [
            'store' => $store,
            'manager' => $manager,
        ];
    }

    public function edit($id, Request $request)
    {
        $store = $this->storeRepo->find($id);
        if (!$store) {
            return false;
        }

        $selectProduct = [];
        foreach ($this->productRepo->allDetached(
            'stores', $store->id) as $product) {
            $selectProduct[$product->id] = $product->name;
        }

        $this->tableController->setParentModel($store);
        $table = $this->tableController->handle($request);

        if ($table instanceof RedirectResponse) {
            return $table;
        }

        return [
            'store' => $store,
            'manager' => $store->manager,
            'select_product' => $selectProduct,
            'table' => $table,
        ];
    }
}
