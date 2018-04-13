<?php

namespace Aksara\TableView;

interface TableRepository
{
    public function find($id);
    public function delete($id);
    public function sort($column, $order = 'ASC');
}

