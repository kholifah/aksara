<?php

namespace Aksara\TableView;

interface TableRepository
{
    public function find($id);
    public function delete($id);
    public function sort($column, $order = 'ASC', $referenceModel = null);
    public function sortCallback($callback, $order = 'ASC', $referenceModel = null);
    public function search($columns, $value, $referenceModel = null);

    /**
     * function (Model $model)
     */
    public function filter($callback, $referenceModel = null);
    public function filterColumn($columnName, $value, $referenceModel = null);

    public function between($columnName, $from, $to, $referenceModel = null);
}

