<?php

namespace Aksara\TableView\Presenter\Components;

trait DefaultFilter
{
    private function renderDefaultFilter($table, $filters, $position = 0)
    {
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

    private function renderFilterButton($table)
    {
        echo '<div class="alignleft action filter-box"><input name="'.$table['inputs']['bfilter'].
            '" type="submit" class="btn btn-secondary" value="'.__('tableview.labels.filter').'"></div>';
    }
}
