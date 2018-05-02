<?php

namespace Plugins\User\Presenters;

use Aksara\TableView\Presenter\BasicTablePresenter;
use Aksara\TableView\Presenter\Components\DefaultSearch;

class RoleUserTablePresenter extends BasicTablePresenter
{
    use DefaultSearch;

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

    protected function registerFilters()
    {
        \Eventy::addAction('tableview.form_filter', function ($table) {
            $this->renderDefaultSearch($table);
        });
    }
}

