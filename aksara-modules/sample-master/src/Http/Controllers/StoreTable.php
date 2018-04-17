<?php

namespace Plugins\SampleMaster\Http\Controllers;

use Aksara\TableView\AbstractTableController;
use Plugins\SampleMaster\Repositories\StoreRepository;
use Plugins\SampleMaster\Presenters\StoreTablePresenter;

class StoreTable extends AbstractTableController
{
    protected $searchable = [
        'store_name',
    ];

    protected $defaultSortColumn = 'id';

    public function __construct(
        StoreRepository $repo,
        StoreTablePresenter $table
    ){
        parent::__construct($repo, $table);
    }
}

