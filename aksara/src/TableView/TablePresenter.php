<?php

namespace Aksara\TableView;

interface TablePresenter
{
    /**
     * Eloquent paginated collection
     */
    public function setData($data);

    /**
     * plain string
     */
    public function setSearch($search);
    public function getColumnLabels();
    public function getColumnKeys();
    public function getRows();

    public function empty();
    public function paginationLinks();
    public function getSearch();
    public function getTotal();
    public function render($viewName, $presenterName = 'table');
}
