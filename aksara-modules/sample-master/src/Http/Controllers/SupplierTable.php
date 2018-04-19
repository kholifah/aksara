<?php

namespace Plugins\SampleMaster\Http\Controllers;

use Aksara\TableView\Controller\AbstractTableController;
use Plugins\SampleMaster\Repositories\SupplierRepository;
use Plugins\SampleMaster\Presenters\SupplierTablePresenter;

class SupplierTable extends AbstractTableController
{
    public function __construct(
        SupplierRepository $repo,
        SupplierTablePresenter $table
    ){
        parent::__construct($repo, $table);
    }

    /**
     * filter all
     */
    public function filterAll($model)
    {
        return $model;
    }

    /**
     * filter active
     */
    public function filterActive($model)
    {
        return $model->where('is_active', true);
    }

    /**
     * filter inactive
     */
    public function filterInactive($model)
    {
        return $model->where('is_active', false);
    }

    /**
     * action sesuatu_aksi
     */
    public function actionSesuatuAksi($request)
    {
        echo "anda melakukan aksi: " . $request->get('apply') . " ";
        $params = $request->get($this->table->getListIdentifier());
        if (!empty($params)) {
            echo "dengan parameter: " . implode('|', $params);
        }
        die();
    }
}
