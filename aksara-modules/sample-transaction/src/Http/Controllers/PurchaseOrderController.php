<?php

namespace Plugins\SampleTransaction\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\RedirectResponse;
use Illuminate\Routing\Controller;
use Plugins\SampleTransaction\Repositories\PurchaseOrderRepository;
use Plugins\SampleTransaction\Presenters\PurchaseOrderForm;
use Plugins\SampleTransaction\Http\Requests\CreatePurchaseOrderRequest;
use Plugins\SampleTransaction\Http\Requests\AddPurchaseOrderItemRequest;

class PurchaseOrderController extends Controller
{
    private $repo;
    private $form;
    private $poTable;

    public function __construct(
        PurchaseOrderRepository $repo,
        PurchaseOrderForm $form,
        PurchaseOrderTable $poTable
    ){
        $this->repo = $repo;
        $this->form = $form;
        $this->poTable = $poTable;
    }

    public function index(Request $request)
    {
        authorize('all-transaction-po');

        $response = $this->poTable->handle($request);
        if ($response instanceof RedirectResponse) {
            return $response;
        }
        return view('sample-transaction::po.index', [ 'table' => $response ]);
    }

    public function create()
    {
        authorize('add-transaction-po');

        $viewData = $this->form->create();
        return view('sample-transaction::po.create', $viewData);
    }

    public function store(CreatePurchaseOrderRequest $request)
    {
        authorize('add-transaction-po');

        $data = $this->repo->store($request);
        if (!$data) {
            admin_notice('danger', __('sample-transaction::po.messages.create_failed'));
        } else {
            admin_notice('success', __('sample-transaction::po.messages.created'));
        }
        if (has_capability('edit-transaction-po')) {
            return redirect()->route('sample-po-edit', $data->id);
        }
        return redirect()->route('sample-po');
    }

    public function edit($id, Request $request)
    {
        authorize('edit-transaction-po');

        $viewData = $this->form->edit($id, $request);
        if ($viewData instanceof RedirectResponse) {
            return $viewData;
        }
        return view('sample-transaction::po.edit', $viewData);
    }

    public function update(CreatePurchaseOrderRequest $request, $id)
    {
        authorize('edit-transaction-po');

        $success = $this->repo->update($id, $request);
        if (!$success) {
            admin_notice('danger', __('sample-transaction::po.messages.update_failed'));
        } else {
            admin_notice('success', __('sample-transaction::po.messages.updated'));
        }
        return redirect()->back();
    }

    public function storeItem($id, AddPurchaseOrderItemRequest $request)
    {
        authorize('edit-transaction-po');

        $po = $this->repo->find($id);
        $success = $po->items()->create($request->input());
        if (!$success) {
            admin_notice('danger', __('sample-transaction::po.messages.add_item_failed'));
        } else {
            admin_notice('success', __('sample-transaction::po.messages.item_added'));
        }
        return redirect()->route('sample-po-edit', $id);
    }
}
