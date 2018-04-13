<?php

namespace Plugins\SampleMaster\Http\Controllers;

use Aksara\TableView\BasicTableController;
use Plugins\SampleMaster\Repositories\StoreRepository;
use Plugins\SampleMaster\Presenters\StoreTablePresenter;

class StoreTable extends BasicTableController
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

