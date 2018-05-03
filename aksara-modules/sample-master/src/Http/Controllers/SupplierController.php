<?php

namespace Plugins\SampleMaster\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\RedirectResponse;
use Illuminate\Routing\Controller;
use Plugins\SampleMaster\Models\Supplier;
use Plugins\SampleMaster\Repositories\SupplierRepository;
use Plugins\SampleMaster\Http\Requests\CreateSupplierRequest;
use Plugins\SampleMaster\Http\Requests\UpdateSupplierRequest;
use Plugins\User\Annotations;

class SupplierController extends Controller
{
    private $tableController;
    private $repo;

    public function __construct(
        SupplierRepository $repo,
        SupplierTable $tableController
    ){
        $this->repo = $repo;
        $this->tableController = $tableController;
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        authorize('all-master-supplier');

        $response = $this->tableController->handle($request);
        if ($response instanceof RedirectResponse) {
            return $response;
        }
        return view('sample-master::supplier.index', [ 'table' => $response ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        authorize('add-master-supplier');

        $supplier = $this->repo->new();
        $viewName = 'sample-master::supplier.create';
        return view($viewName, compact('supplier'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        authorize('edit-master-supplier');

        $supplier = $this->repo->find($id);
        $viewName = 'sample-master::supplier.edit';
        return view($viewName, compact('supplier'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(CreateSupplierRequest $request)
    {
        authorize('add-master-supplier');

        $success = $this->repo->store($request);
        if (!$success) {
            admin_notice('danger', __('sample-master::supplier.messages.create_failed'));
        } else {
            admin_notice('success', __('sample-master::supplier.messages.created'));
        }
        return redirect()->route('sample-supplier');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateSupplierRequest $request, $id)
    {
        authorize('edit-master-supplier');

        $success = $this->repo->update($id, $request);
        if (!$success) {
            admin_notice('danger', __('sample-master::supplier.messages.update_failed'));
        } else {
            admin_notice('success', __('sample-master::supplier.messages.updated'));
        }
        return redirect()->route('sample-supplier');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        authorize('delete-master-supplier');

        $success = $this->repo->delete($id);
        if (!$success) {
            admin_notice('danger', __('sample-master::supplier.messages.delete_failed'));
        } else {
            admin_notice('success', __('sample-master::supplier.messages.deleted'));
        }
        return redirect()->route('sample-supplier');
    }

}
