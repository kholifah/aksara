<?php

namespace Aksara\TableView\Presenter\Components;

trait DestroyBulkAction
{
    private function registerDeleteAction(&$actions)
    {
        if ($this->canDelete()) {
            $actions['destroy'] = __('tableview.labels.delete');
        }
    }
}
