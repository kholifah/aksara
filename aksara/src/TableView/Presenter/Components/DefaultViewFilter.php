<?php

namespace Aksara\TableView\Presenter\Components;

trait DefaultViewFilter
{
    private function renderDefaultViewFilter($table, $filters)
    {
        if (empty($filters)) return;
        $route_name = $this->routeName;
        echo view('table.components.filterlinks', compact('table', 'route_name', 'filters'));
    }
}

