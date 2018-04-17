<?php

namespace Plugins\SampleMaster\Presenters;

use Plugins\SampleMaster\Repositories\StoreRepository;
use Plugins\SampleMaster\Repositories\StoreManagerRepository;
use Plugins\SampleMaster\Repositories\ProductRepository;
use Illuminate\Http\Request;

class StoreFormPresenter
{
    private $storeRepo;
    private $managerRepo;
    private $productRepo;

    public function __construct(
        StoreRepository $storeRepo,
        StoreManagerRepository $managerRepo,
        ProductRepository $productRepo
    ){
        $this->storeRepo = $storeRepo;
        $this->managerRepo = $managerRepo;
        $this->productRepo = $productRepo;
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

    public function edit($id)
    {
        $store = $this->storeRepo->find($id);
        if (!$store) {
            return false;
        }

        $manager = $store->manager;

        $allProducts = [];
        foreach ($this->productRepo->all() as $product) {
            $allProducts[$product->id] = $product->name;
        }

        return [
            'store' => $store,
            'manager' => $manager,
            'all_products' => $allProducts,
        ];
    }
}
