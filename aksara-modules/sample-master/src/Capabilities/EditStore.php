<?php

namespace Plugins\SampleMaster\Capabilities;

use Plugins\SampleMaster\Repositories\StoreRepository;

class EditStore
{
    private $storeRepo;

    public function __construct(StoreRepository $storeRepo)
    {
        $this->storeRepo = $storeRepo;
    }

    public function can($storeId)
    {
        $store = $this->storeRepo->find($storeId);

        if ($store->created_by == \Auth::user()->id) {
            return true;
        }
        return false;
    }

}


