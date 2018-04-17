<?php

namespace Plugins\SampleMaster\Http\Controllers;

use Aksara\TableView\AbstractTableController;
use Plugins\SampleMaster\Repositories\ProductRepository;
use Plugins\SampleMaster\Presenters\ProductTablePresenter;

class ProductTable extends AbstractTableController
{
    protected $searchable = [
        'name',
        'code',
    ];

    protected $defaultSortColumn = 'id';

    public function __construct(
        ProductRepository $repo,
        ProductTablePresenter $table
    ){
        parent::__construct($repo, $table);
    }
}

