<?php

namespace Plugins\SampleMaster\Http\Controllers;

use Aksara\TableView\Controller\AbstractTableController;
use Plugins\SampleMaster\Repositories\StoreRepository;
use Plugins\SampleMaster\Presenters\StoreTablePresenter;

class StoreTable extends AbstractTableController
{
    public function __construct(
        StoreRepository $repo,
        StoreTablePresenter $table
    ){
        parent::__construct($repo, $table);
    }
}

