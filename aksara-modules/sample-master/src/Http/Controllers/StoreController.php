<?php

namespace Plugins\SampleMaster\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\RedirectResponse;
use Illuminate\Routing\Controller;
use Plugins\SampleMaster\Models\Store;
use Plugins\SampleMaster\Repositories\StoreRepository;
use Plugins\SampleMaster\Http\Requests\CreateStoreRequest;
use Plugins\SampleMaster\Http\Requests\UpdateStoreRequest;
use Plugins\SampleMaster\Http\Requests\CreateManagerRequest;
use Plugins\SampleMaster\Http\Requests\UpdateManagerRequest;
use Plugins\SampleMaster\Http\Requests\AddProductStoreRequest;
use Plugins\SampleMaster\Presenters\StoreFormPresenter;

class StoreController extends Controller
{
    private $tableController;
    private $repo;
    private $form;

    public function __construct(
        StoreRepository $repo,
        StoreTable $tableController,
        StoreFormPresenter $form
    ){
        $this->repo = $repo;
        $this->tableController = $tableController;
        $this->form = $form;
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        //TODO move to annotation if possible
        if (!\UserCapability::hasCapability('master-store')) {
            abort(403, 'Does not have right to access store');
        }

        $response = $this->tableController->handle($request);
        if ($response instanceof RedirectResponse) {
            return $response;
        }
        return view('sample-master::store.index', [ 'table' => $response ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $viewData = $this->form->create();
        return view('sample-master::store.create', $viewData);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id, Request $request)
    {
        $viewData = $this->form->edit($id, $request);
        if (!$viewData) {
            abort(404, 'Not found');
        }
        if ($viewData instanceof RedirectResponse) {
            return $viewData;
        }
        return view('sample-master::store.edit', $viewData);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(CreateStoreRequest $request)
    {
        $data = $this->repo->store($request);
        if (!$data) {
            admin_notice('danger', __('sample-master::store.messages.create_failed'));
        } else {
            admin_notice('success', __('sample-master::store.messages.created'));
        }
        return redirect()->route('sample-store-edit', $data->id);
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
    public function update(UpdateStoreRequest $request, $id)
    {
        $success = $this->repo->update($id, $request);
        if (!$success) {
            admin_notice('danger', __('sample-master::store.messages.update_failed'));
        } else {
            admin_notice('success', __('sample-master::store.messages.updated'));
        }
        return redirect()->route('sample-store-edit', $id);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //TODO move to annotation if possible
        if (!\UserCapability::hasCapability('delete-master-store')) {
            abort(403, 'Does not have right to delete store');
        }

        $success = $this->repo->delete($id);
        if (!$success) {
            admin_notice('danger', __('sample-master::store.messages.delete_failed'));
        } else {
            admin_notice('success', __('sample-master::store.messages.deleted'));
        }
        return redirect()->route('sample-store');
    }

    public function storeManager($store_id, CreateManagerRequest $request)
    {
        $success = $this->repo->storeRelation($store_id, 'manager', $request);
        if (!$success) {
            admin_notice('danger', __('sample-master::store.manager.messages.create_failed'));
        } else {
            admin_notice('success', __('sample-master::store.manager.messages.created'));
        }
        return redirect()->route('sample-store-edit', $store_id);
    }

    public function updateManager($store_id, $id, UpdateManagerRequest $request)
    {
        $success = $this->repo->storeRelation($store_id, 'manager', $request);
        if (!$success) {
            admin_notice('danger', __('sample-master::store.manager.messages.update_failed'));
        } else {
            admin_notice('success', __('sample-master::store.manager.messages.updated'));
        }
        return redirect()->route('sample-store-edit', $store_id);
    }

    public function addProduct($store_id, AddProductStoreRequest $request)
    {
        $productId = $request->input('product_id');
        $success = $this->repo->attachOnce($store_id, 'products', $productId);
        if (!$success) {
            admin_notice('danger', __('sample-master::store.product.messages.add_failed'));
        } else {
            admin_notice('success', __('sample-master::store.product.messages.add_success'));
        }
        return redirect()->route('sample-store-edit', $store_id);
    }

    public function removeProduct($store_id, $product_id)
    {
        //TODO move to annotation if possible
        if (!\UserCapability::hasCapability('edit-master-store')) {
            abort(403, 'Does not have right to edit store');
        }

        $success = $this->repo->detach($store_id, 'products', $product_id);
        if (!$success) {
            admin_notice('danger', __('sample-master::store.product.messages.add_failed'));
        } else {
            admin_notice('success', __('sample-master::store.product.messages.add_success'));
        }
        return redirect()->route('sample-store-edit', $store_id);
    }
}

