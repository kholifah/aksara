<?php

namespace Aksara\Support\Contracts;

use Illuminate\Http\Request;

interface HttpCrudRepository
{
    public function find($id);
    public function store(Request $request);
    public function update($id, Request $request);
    public function delete($id);
    public function sort($column, $order = 'ASC');
    public function new($attributes = []);
    public function all();
}
