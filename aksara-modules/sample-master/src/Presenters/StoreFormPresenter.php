<?php

namespace Plugins\SampleMaster\Presenters;

use Plugins\SampleMaster\Repositories\StoreRepository;
use Plugins\SampleMaster\Repositories\StoreManagerRepository;

class StoreFormPresenter
{
    private $storeRepo;
    private $managerRepo;

    public function __construct(
        StoreRepository $storeRepo,
        StoreManagerRepository $managerRepo
    ){
        $this->storeRepo = $storeRepo;
        $this->managerRepo = $managerRepo;
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

        return [
            'store' => $store,
            'manager' => $manager,
        ];
    }
}
