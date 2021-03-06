<?php

namespace Aksara\TableView\Presenter\Components;

trait DefaultFilter
{
    private $filter_position = 0;

    protected function renderDropDownFilter($table, $filters, $caption = null)
    {
        $filter_position = $this->filter_position;
        echo view('table.components.dropdown_filter',
            compact('table', 'filters', 'filter_position', 'caption')
        )->render();
        $this->filter_position++;
    }

    protected function renderFilterButton($table)
    {
        echo view('table.components.filter_button', compact('table'))->render();
    }

    protected function renderDropDownColumnFilter($table, $column_name, $caption = null)
    {
        echo view('table.components.dropdown_column_filter', compact('table', 'column_name', 'caption'))->render();
    }

    protected function renderDateRangeFilter($table, $column_name, $caption = null)
    {
        echo view('table.components.date_range_filter', compact('table', 'column_name', 'caption'))->render();
    }
}
