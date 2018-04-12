<?php

namespace Plugins\SampleMaster\Repositories;

use Plugins\SampleMaster\Models\Supplier;
use Illuminate\Http\Request;

class SupplierRepository implements RepositoryInterface
{
    private $model;

    public function __construct(Supplier $model)
    {
        $this->model = $model;
    }

    public function find($id)
    {
        $data = $this->model->find($id);
        if (!$data) {
            return false;
        }
        return $data;
    }

    public function store(Request $request)
    {
        $data = $this->model->create($request->input());
        if (!$data) {
            return false;
        }
        return $data;
    }

    public function update($id, Request $request)
    {
        $data = $this->find($id);
        if (!$data) {
            return false;
        }
        $data->fill($request->input());
        $data->save();
        return $data;
    }

    public function delete($id)
    {
        $data = $this->find($id);
        if (!$data) {
            return false;
        }
        if (!$data->delete()) {
            return false;
        }
        return true;
    }

    public function sort($column, $order = 'ASC')
    {
        return $this->model->orderBy($column, $order);
    }

    public function new($attributes = [])
    {
        $data = new $this->model;
        if (!empty($attributes)) {
            $data->fill($attributes);
        }
        return $data;
    }
}
