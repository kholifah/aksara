<?php

namespace Aksara\TableView\Presenter\Components;

trait DefaultViewFilter
{
    private function renderDefaultViewFilter($filters)
    {
        $route_name = $this->routeName;
        echo view('table.components.filterlinks', compact('route_name', 'filters'));
    }
}

