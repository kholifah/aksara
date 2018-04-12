<?php

namespace Plugins\SampleMaster\Repositories;

use Illuminate\Http\Request;

interface RepositoryInterface
{
    public function find($id);
    public function store(Request $request);
    public function update($id, Request $request);
    public function delete($id);
    public function sort($column, $order = 'ASC');
    public function new($attributes = []);
}
