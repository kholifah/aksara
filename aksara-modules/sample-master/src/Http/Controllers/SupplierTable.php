<?php

namespace Plugins\SampleMaster\Http\Controllers;

use Aksara\TableView\TableController;
use Illuminate\Http\Request;
use Plugins\SampleMaster\Models\Supplier;
use Plugins\SampleMaster\Repositories\SupplierRepository;

class SupplierTable extends TableController
{
    protected $searchable = [
        'supplier_name',
    ];

    protected $defaultSortColumn = 'id';

    public function __construct(SupplierRepository $repo)
    {
        parent::__construct($repo);
    }
}
