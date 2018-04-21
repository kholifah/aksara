<?php

namespace Aksara\TableView\Presenter\Components;

trait DefaultSearch
{
    protected function renderDefaultSearch($table)
    {
        echo view('table.components.searchbox', compact('table'))->render();
    }

}
