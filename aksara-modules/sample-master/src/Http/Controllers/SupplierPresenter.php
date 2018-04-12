<?php

namespace Plugins\SampleMaster\Http\Controllers;

use Illuminate\Http\Request;
use Plugins\SampleMaster\Models\Supplier;
use Plugins\SampleMaster\Repositories\SupplierRepository;

class SupplierPresenter extends BasePresenter
{
    protected $searchable = [
        'supplier_name',
    ];

    protected $defaultSortColumn = 'id';

    public function __construct(SupplierRepository $repo, Request $request)
    {
        parent::__construct($repo, $request);
    }

    public function create($viewName)
    {
        $supplier = $this->repo->new();
        return view($viewName, compact('supplier'));
    }

    public function edit($id, $viewName)
    {
        $supplier = $this->find($id);
        return view($viewName, compact('supplier'));
    }

    protected function getMultipleDeletedMessage($count)
    {
        return trans_choice(
            'sample-master::supplier.messages.multiple_deleted',
            $count, [ 'count' => $count ]
        );
    }

    protected function getFailedDeleteMessage()
    {
        return __('sample-master::supplier.messages.failed_delete');
    }
}
