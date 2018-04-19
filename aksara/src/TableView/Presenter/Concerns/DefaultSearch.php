<?php

namespace Aksara\TableView\Presenter\Concerns;

trait DefaultSearch
{
    protected function renderDefaultSearch($table)
    {
        echo '
            <div class="alignleft search-box">
                <input name="'.$table['inputs']['search'].'" value="'.$table['search'].'" type="text" class="form-control">
                <input name="'.$table['inputs']['bsearch'].'" type="submit" class="btn btn-secondary" value="'.__('tableview.labels.search').'">
            </div>';
    }

}
