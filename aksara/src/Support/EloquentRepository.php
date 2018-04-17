<?php

namespace Aksara\Support;

use Illuminate\Http\Request;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

abstract class EloquentRepository
{
    protected $model;

    public function find($id)
    {
        $data = $this->model->find($id);
        if (!$data) {
            return false;
        }
        return $data;
    }

    public function storeRelation($id, $relationName, Request $request)
    {
        $data = $this->find($id);
        if (!$data) {
            return false;
        }

        if ($data->$relationName() instanceof HasOne) {
            $data->$relationName->fill($request->input());
            return $data->$relationName->save();
        }
        throw new \Exception('Relation type not supported yet');
    }

    public function attach($id, $relationName, $attachId, $once = false)
    {
        $data = $this->find($id);
        if (!$data) {
            return false;
        }
        if ($data->$relationName() instanceof BelongsToMany) {
            if (!$once || !$data->$relationName->contains($attachId)) {
                $data->$relationName()->attach($attachId);
            }
            return true;
        }
        throw new \Exception('Relation type not supported yet');
    }

    public function attachOnce($id, $relationName, $attachId)
    {
        return $this->attach($id, $relationName, $attachId, true);
    }

    public function detach($id, $relationName, $detachId)
    {
        $data = $this->find($id);
        if (!$data) {
            return false;
        }
        if ($data->$relationName() instanceof BelongsToMany) {
            if ($data->$relationName->contains($detachId)) {
                $data->$relationName()->detach($detachId);
            }
            return true;
        }
        throw new \Exception('Relation type not supported yet');
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

    public function all()
    {
        return $this->model->all();
    }

    public function search($columns, $value)
    {
        $data = $this->model;
        foreach ($columns as $field) {
            $data = $data->orWhere($field, 'like', '%' . $value . '%');
        }
        return $data;
    }
}
