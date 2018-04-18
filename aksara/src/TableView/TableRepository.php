<?php

namespace Aksara\TableView;

interface TableRepository
{
    public function find($id);
    public function delete($id);
    public function sort($column, $order = 'ASC');
    public function search($columns, $value, $referenceModel = null);

    /**
     * function (Model $model)
     */
    public function filter($callback, $referenceModel = null);
}

