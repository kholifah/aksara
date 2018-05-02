<?php

namespace Plugins\User\Http\Controllers;

use Aksara\TableView\Controller\AbstractTableController;
use Plugins\User\Repository\RoleUserRepository;
use Plugins\User\Presenters\RoleUserTablePresenter;
use App\User;

class RoleUserTable extends AbstractTableController
{
    public function __construct(
        RoleUserRepository $repo,
        RoleUserTablePresenter $table
    ){
        parent::__construct($repo, $table);
    }

    public function setParentModel(User $user)
    {
        $this->repo->setParentModel($user);
    }

}

