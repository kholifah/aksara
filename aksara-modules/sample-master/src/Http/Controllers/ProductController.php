<?php

namespace Plugins\SampleMaster\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\RedirectResponse;
use Illuminate\Routing\Controller;
use Plugins\SampleMaster\Models\Product;
use Plugins\SampleMaster\Repositories\ProductRepository;
use Plugins\SampleMaster\Presenters\ProductFormPresenter;
use Plugins\SampleMaster\Http\Requests\CreateProductRequest;

class ProductController extends Controller
{
    private $tableController;
    private $productRepo;
    private $form;

    public function __construct(
        ProductRepository $productRepo,
        ProductTable $tableController,
        ProductFormPresenter $form
    ){
        $this->productRepo = $productRepo;
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
        authorize('all-master-product');

        $response = $this->tableController->handle($request);
        if ($response instanceof RedirectResponse) {
            return $response;
        }
        return view('sample-master::product.index', [ 'table' => $response ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        authorize('add-master-product');

        $product = $this->productRepo->new();
        $viewData = $this->form->create($product);
        return view('sample-master::product.create', $viewData);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        authorize('edit-master-product');

        $product = $this->productRepo->find($id);
        $viewData = $this->form->create($product);
        return view('sample-master::product.edit', $viewData);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(CreateProductRequest $request)
    {
        authorize('add-master-product');

        $success = $this->productRepo->store($request);
        if (!$success) {
            admin_notice('danger', __('sample-master::product.messages.create_failed'));
        } else {
            admin_notice('success', __('sample-master::product.messages.created'));
        }
        return redirect()->route('sample-product');
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
    public function update(CreateProductRequest $request, $id)
    {
        authorize('edit-master-product');

        $success = $this->productRepo->update($id, $request);
        if (!$success) {
            admin_notice('danger', __('sample-master::product.messages.update_failed'));
        } else {
            admin_notice('success', __('sample-master::product.messages.updated'));
        }
        return redirect()->route('sample-product');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        authorize('delete-master-product');

        $success = $this->productRepo->delete($id);
        if (!$success) {
            admin_notice('danger', __('sample-master::product.messages.delete_failed'));
        } else {
            admin_notice('success', __('sample-master::product.messages.deleted'));
        }
        return redirect()->route('sample-product');
    }

}

