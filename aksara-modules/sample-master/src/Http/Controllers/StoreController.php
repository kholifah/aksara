<?php

namespace Plugins\SampleMaster\Http\Controllers;

use Aksara\TableView\BasicTablePresenter;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Plugins\SampleMaster\Models\Store;
use Plugins\SampleMaster\Repositories\StoreRepository;
use Plugins\SampleMaster\Http\Requests\CreateStoreRequest;

class StoreController extends Controller
{
    private $tableController;
    private $repo;

    public function __construct(
        StoreRepository $repo,
        StoreTable $tableController
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
        $response = $this->tableController->handle($request);
        if ($response instanceof BasicTablePresenter) {
            return view('sample-master::store.index', [ 'table' => $response ]);
        }
        return $response;
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $store = $this->repo->new();
        $viewName = 'sample-master::store.create';
        return view($viewName, compact('store'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $store = $this->repo->find($id);
        $viewName = 'sample-master::store.edit';
        return view($viewName, compact('store'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(CreateStoreRequest $request)
    {
        $success = $this->repo->store($request);
        if (!$success) {
            admin_notice('danger', __('sample-master::store.messages.create_failed'));
        } else {
            admin_notice('success', __('sample-master::store.messages.created'));
        }
        return redirect()->route('sample-store');
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
    public function update(CreateStoreRequest $request, $id)
    {
        $success = $this->repo->update($id, $request);
        if (!$success) {
            admin_notice('danger', __('sample-master::store.messages.update_failed'));
        } else {
            admin_notice('success', __('sample-master::store.messages.updated'));
        }
        return redirect()->route('sample-store');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $success = $this->repo->delete($id);
        if (!$success) {
            admin_notice('danger', __('sample-master::store.messages.delete_failed'));
        } else {
            admin_notice('success', __('sample-master::store.messages.deleted'));
        }
        return redirect()->route('sample-store');
    }

}

