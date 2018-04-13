<?php

namespace Plugins\SampleMaster\Http\Controllers;

use Aksara\TableView\BasicTableController;
use Plugins\SampleMaster\Repositories\SupplierRepository;
use Plugins\SampleMaster\Presenters\SupplierTablePresenter;

class SupplierTable extends BasicTableController
{
    protected $searchable = [
        'supplier_name',
    ];

    protected $defaultSortColumn = 'id';

    public function __construct(SupplierRepository $repo, SupplierTablePresenter $table)
    {
        parent::__construct($repo, $table);
    }
}
