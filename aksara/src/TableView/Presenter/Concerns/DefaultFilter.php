<?php

namespace Aksara\TableView\Presenter\Concerns;

trait DefaultFilter
{
    private function renderDefaultFilter($table, $filters = null, $position = 0)
    {
        $filters = $filters ?? $this->getFilters();
        $options = [];
        $filtered = @$table['filtered'][$position];

        foreach ($filters as $name => $label) {
            $options[] = '<option value="'.$name.'" '.(($filtered == $name) ? 'selected' : '') .'>'.$label.'</option>';
        }

        $div = '
            <div class="alignleft action filter-box">
                <select name="filter[]" class="form-control">
                    <option value="" selected>'.__('tableview.labels.no_filter').'</option>';

        foreach ($options as $option) {
            $div .= $option;
        }

        $div .= '
                </select>
            </div>';

        echo $div;
    }
}
