<?php

namespace Aksara\TableView\Presenter\Concerns;

trait DefaultViewFilter
{
    private function renderDefaultViewFilter($filters)
    {
        $count = count($filters);
        $current = 0;

        $ul = '<ul class="trash-sistem">';
        foreach ($filters as $filter => $label) {
            $url = route($this->routeName, [ 'view' => $filter ]);
            $ul .= '<a href="'.$url.'">'.$label.'</a>'.(($current < $count-1) ? '|' : '');
            $current++;
        }
        echo $ul;
    }
}

