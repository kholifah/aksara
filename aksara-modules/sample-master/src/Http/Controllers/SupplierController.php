<?php

namespace Plugins\SampleMaster\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Plugins\SampleMaster\Models\Supplier;
use Plugins\SampleMaster\Http\Requests\CreateSupplierRequest;

class SupplierController extends Controller
{

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $suppliers = Supplier::orderBy('id');
        if ($request->get('bapply')) {
            if ($request->input('apply')) {
                $apply = $request->input('apply');
                if ($apply == 'destroy') {
                    if ($request->input('id')) {
                        $id = $request->input('id');
                        $this->deleteMultipleSupplier($id);
                    }
                }
            }
            //prevent delete repeating with refresh button
            //remove bapply, apply, then redirect
            //include other parameters
            return redirect()->back()->withInput(
                $request->except([ 'bapply', 'apply' ])
            );
        }
        if ($request->input('search')) {
            $search = $request->input('search');
            $suppliers = $suppliers->where('supplier_name', 'like', '%' . $search . '%');
        } else {
            $search = '';
        }

        $total = $suppliers->count();
        $suppliers = $suppliers->paginate(10);
        return view('sample-master::supplier.index', compact('suppliers', 'search', 'total'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $supplier = new Supplier;
        return view('sample-master::supplier.create', compact('supplier'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(CreateSupplierRequest $request)
    {
        $supplier = Supplier::create($request->input());
        if (!$supplier) {
            admin_notice('danger', 'Failed to create supplier');
        }
        admin_notice('success', __('sample-master::supplier.messages.created'));
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
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $supplier = $this->findSupplier($id);
        return view('sample-master::supplier.edit', compact('supplier'));
    }

    private function findSupplier($id)
    {
        $supplier = Supplier::find($id);
        if (!$id) {
            abort(404, 'Page Not Found');
        }
        return $supplier;
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(CreateSupplierRequest $request, $id)
    {
        $supplier = $this->findSupplier($id);
        $supplier->fill($request->input());
        $supplier->save();
        admin_notice('success', __('sample-master::supplier.messages.updated'));
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
        $success = $this->deleteSupplier($id);
        if ($success) {
            admin_notice('success', __('sample-master::supplier.messages.deleted'));
        }
        return redirect()->route('sample-supplier');
    }

    private function deleteMultipleSupplier(array $idList)
    {
        foreach ($idList as $id) {
            $success = $this->deleteSupplier($id);
        }
        $count = count($idList);
        admin_notice('success', trans_choice('sample-master::supplier.messages.multiple_deleted',
            $count, [ 'count' => $count ]));
    }

    private function deleteSupplier($id)
    {
        $supplier = $this->findSupplier($id);
        if (!$supplier->delete()) {
            admin_notice('danger', __('sample-master::supplier.messages.failed_delete'));
            return false;
        }
        return true;
    }
}
