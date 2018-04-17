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
    public function getInputField($fieldName);
    public function getIdentifier();
    public function render($viewName, $presenterName = 'table');
}
