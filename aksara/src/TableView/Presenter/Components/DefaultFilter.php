<?php

namespace Aksara\TableView\Presenter\Components;

trait DefaultFilter
{
    private $position = 0;

    private function renderDropDownFilter($table, $filters)
    {
        $position = $this->position;
        echo view('table.components.dropdown_filter', compact('table', 'filters', 'position'))->render();
        $this->position++;
    }

    private function renderFilterButton($table)
    {
        echo view('table.components.filter_button', compact('table'))->render();
    }
}
