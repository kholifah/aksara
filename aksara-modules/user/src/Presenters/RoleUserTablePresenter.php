<?php

namespace Plugins\User\Presenters;

use Aksara\TableView\Presenter\BasicTablePresenter;
use Aksara\TableView\Presenter\Components\DefaultSearch;
use Aksara\TableView\Presenter\Components\DestroyBulkAction;

class RoleUserTablePresenter extends BasicTablePresenter
{
    use DefaultSearch;
    use DestroyBulkAction;

    protected $searchable = [
        'name',
    ];

    protected $sortable = [
        'name',
    ];

    protected $inputPrefix = 'role';

    protected function getColumns()
    {
        return [
            'name' => __('user::labels.role_name'),
        ];
    }

    protected function canDelete()
    {
        return has_capability('remove-user-role');
    }

    protected function registerFilters()
    {
        \Eventy::addAction('tableview.form_filter', function ($table) {
            $this->renderDefaultSearch($table);
        });
    }

    protected function registerActions(&$actions)
    {
        $this->registerDeleteAction($actions);
    }
}

