<?php

namespace Plugins\SampleTransaction\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\RedirectResponse;
use Illuminate\Routing\Controller;
use Plugins\SampleTransaction\Repositories\PurchaseOrderRepository;
use Plugins\SampleTransaction\Presenters\PurchaseOrderForm;

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
        $response = $this->poTable->handle($request);
        if ($response instanceof RedirectResponse) {
            return $response;
        }
        return view('sample-transaction::po.index', [ 'table' => $response ]);
    }

    public function create()
    {
        $po = $this->repo->new();
        $viewData = $this->form->create($po);
        return view('sample-transaction::po.create', $viewData);
    }

    //TODO request injection
    public function store(Request $request)
    {
        $success = $this->repo->store($request);
        if (!$success) {
            admin_notice('danger', __('sample-transaction::po.messages.create_failed'));
        } else {
            admin_notice('success', __('sample-transaction::po.messages.created'));
        }
        return redirect()->route('sample-po');
    }

    public function edit($id)
    {
        $po = $this->repo->find($id);
        $viewData = $this->form->create($po);
        return view('sample-transaction::po.edit', $viewData);
    }

    //TODO request injection
    public function update(Request $request, $id)
    {
        $success = $this->repo->update($id, $request);
        if (!$success) {
            admin_notice('danger', __('sample-transaction::po.messages.update_failed'));
        } else {
            admin_notice('success', __('sample-transaction::po.messages.updated'));
        }
        return redirect()->route('sample-po');
    }

    public function destroy($id)
    {
        $success = $this->repo->delete($id);
        if (!$success) {
            admin_notice('danger', __('sample-transaction::po.messages.delete_failed'));
        } else {
            admin_notice('success', __('sample-transaction::po.messages.deleted'));
        }
        return redirect()->route('sample-po');
    }
}
