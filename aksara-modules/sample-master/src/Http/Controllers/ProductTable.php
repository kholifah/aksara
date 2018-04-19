<?php

namespace Plugins\SampleMaster\Http\Controllers;

use Aksara\TableView\Controller\AbstractTableController;
use Plugins\SampleMaster\Repositories\ProductRepository;
use Plugins\SampleMaster\Presenters\ProductTablePresenter;

class ProductTable extends AbstractTableController
{
    public function __construct(
        ProductRepository $repo,
        ProductTablePresenter $table
    ){
        parent::__construct($repo, $table);
    }
}
