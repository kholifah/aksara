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
    public function setSort($sort, $order);
    public function setParentUrl($url);
    public function setRouteName($routeName);
    public function getInputField($fieldName);
    public function getIdentifier();
    public function getListIdentifier();
    public function getSearchable();
    public function getDefaultSortColumn();
    public function render($viewName, $presenterName = 'table');

    public function getColumnFilters();
    public function getDateRangeFilters();

    public function authorizeDelete($identifier = null);
    public function authorizeEdit($identifier = null);
}
