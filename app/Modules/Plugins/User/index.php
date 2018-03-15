<?php

\Eventy::addAction('aksara.init-completed', function () {
    // $userIndex = [
    //     'page_title' => 'User',
    //     'menu_title' => 'User',
    //     'icon' => 'ti-user',
    //     'capability' => '',
    //     'route' => [
    //         'slug' => '/aksara-user',
    //         'args' => [
    //             'as' => 'aksara-user',
    //             'uses' => '\App\Modules\Plugins\User\Http\UserController@index',
    //         ],
    //     ]
    // ];
    // add_admin_sub_menu_route('aksara-menu-user', $userIndex);

    $args = [
        'page_title' => trans('menu.user'),
        'menu_title' => trans('menu.user'),
        'icon' => 'ti-user',
        'capability' => '',
        'route' => [
            'slug' => '/aksara-user',
            'args' => [
                'as' => 'aksara-user',
                'uses' => '\App\Modules\Plugins\User\Http\UserController@index',
            ],
        ]
    ];
    add_admin_sub_menu_route('aksara-menu-user', $args);


    $args = [
        'page_title' => trans('menu.edit-profile'),
        'menu_title' => trans('menu.edit-profile'),
        'icon' => 'ti-user',
        'capability' => '',
        'route' => [
            'slug' => '/aksara/user/edit-profile',
            'args' => [
                'as' => 'aksara.user.edit-profile',
                'uses' => '\App\Modules\Plugins\User\Http\UserController@editProfile',
            ],
        ]
    ];
    add_admin_sub_menu_route('aksara-menu-user', $args);

    $route = \App::make('route');
    $userCreate = [
        'slug' => '/aksara-user/create',
        'method' => 'GET',
        'args' => [
            'as' => 'aksara-user-create',
            'uses' => '\App\Modules\Plugins\User\Http\UserController@create',
        ],
    ];
    $route->addRoute($userCreate);
    $userStore = [
        'slug' => '/aksara-user/store',
        'method' => 'POST',
        'args' => [
            'as' => 'aksara-user-store',
            'uses' => '\App\Modules\Plugins\User\Http\UserController@store',
        ],
    ];
    $route->addRoute($userStore);
    $userEdit = [
        'slug' => '/aksara-user/{id}/edit',
        'method' => 'GET',
        'args' => [
            'as' => 'aksara-user-edit',
            'uses' => '\App\Modules\Plugins\User\Http\UserController@edit',
        ],
    ];
    $route->addRoute($userEdit);
    $userUpdate = [
        'slug' => '/aksara-user/{id}/update',
        'method' => 'PUT',
        'args' => [
            'as' => 'aksara-user-update',
            'uses' => '\App\Modules\Plugins\User\Http\UserController@update',
        ],
    ];
    $route->addRoute($userUpdate);

    $userUpdate = [
        'slug' => '/aksara/user/update-profile',
        'method' => 'PUT',
        'args' => [
            'as' => 'aksara.user.update-profile',
            'uses' => '\App\Modules\Plugins\User\Http\UserController@update',
        ],
    ];
    $route->addRoute($userUpdate);

    $userDestroy = [
        'slug' => '/aksara-user/{id}/destroy',
        'method' => 'GET',
        'args' => [
            'as' => 'aksara-user-destroy',
            'uses' => '\App\Modules\Plugins\User\Http\UserController@destroy',
        ],
    ];
    $route->addRoute($userDestroy);

    $args = [
        'page_title' => trans('menu.role'),
        'menu_title' => trans('menu.role'),
        'icon' => 'ti-user',
        'capability' => '',
        'route' => [
            'slug' => '/aksara-role',
            'args' => [
                'as' => 'aksara-role',
                'uses' => '\App\Modules\Plugins\User\Http\RoleController@index',
            ],
        ]
    ];
    add_admin_sub_menu_route('aksara-menu-user', $args);

    $route = \App::make('route');
    $userCreate = [
        'slug' => '/aksara-role/create',
        'method' => 'GET',
        'args' => [
            'as' => 'aksara-role-create',
            'uses' => '\App\Modules\Plugins\User\Http\RoleController@create',
        ],
    ];
    $route->addRoute($userCreate);
    $userStore = [
        'slug' => '/aksara-role/store',
        'method' => 'POST',
        'args' => [
            'as' => 'aksara-role-store',
            'uses' => '\App\Modules\Plugins\User\Http\RoleController@store',
        ],
    ];
    $route->addRoute($userStore);
    $userEdit = [
        'slug' => '/aksara-role/{id}/edit',
        'method' => 'GET',
        'args' => [
            'as' => 'aksara-role-edit',
            'uses' => '\App\Modules\Plugins\User\Http\RoleController@edit',
        ],
    ];
    $route->addRoute($userEdit);
    $userUpdate = [
        'slug' => '/aksara-role/{id}/update',
        'method' => 'PUT',
        'args' => [
            'as' => 'aksara-role-update',
            'uses' => '\App\Modules\Plugins\User\Http\RoleController@update',
        ],
    ];
    $route->addRoute($userUpdate);
    $userDestroy = [
        'slug' => '/aksara-role/{id}/destroy',
        'method' => 'GET',
        'args' => [
            'as' => 'aksara-role-destroy',
            'uses' => '\App\Modules\Plugins\User\Http\RoleController@destroy',
        ],
    ];
    $route->addRoute($userDestroy);

    add_capability('User');
    add_capability('Add User', 'add-user', 'user');
    add_capability('Edit User', 'edit-user', 'user');
    add_capability('Delete User', 'delete-user', 'user');
});



\Eventy::addAction('aksara.init-after-routes',function(){

    $args = [
        'position' => 5,
        'menuTitle' =>'Edit Profile',
        'capability' =>[],
        'url' => route('aksara.user.edit-profile')
    ];

    add_admin_menu_toolbar_dropdown($args);
},20);


\Eventy::addAction('aksara.admin_head', function () {
    echo '<link href='.url("assets/admin/assets/plugins/datatables/jquery.dataTables.min.css").' rel="stylesheet" type="text/css"/>';
    echo '<link href='.url("assets/admin/assets/plugins/datatables/responsive.bootstrap.min.css").' rel="stylesheet" type="text/css"/>';
});


    \Eventy::addAction('aksara.admin_footer', function () {
        // File JS / CSS masuk sini
        // @nanti dipindah ke resource
        echo '<script src='.url("assets/admin/assets/plugins/datatables/jquery.dataTables.min.js").'></script>';
        echo '<script src='.url("assets/admin/assets/plugins/datatables/dataTables.responsive.min.js").'></script>';
        echo '<script src='.url("assets/admin/assets/pages/datatables.init.js").'></script>';
        echo "<script type='text/javascript'>
                $(document).ready(function () {
                    var oTable = $('.datatable-responsive').DataTable({
                        paging: false,
                        ordering: true,
                        info: false,
                        searching: false,
                        order: [],
                        columnDefs: [
                            {targets: 'no-sort', orderable: false}
                        ],
                        responsive: true
                    });
                    oTable.on('responsive-display', function (e, datatable, row, showHide, update) {
                        $('.sa-success').click(function () {
                            swal(
                                    {
                                        title: 'Sukses!',
                                        text: 'Data telah tersimpan.',
                                        type: 'success',
                                        confirmButtonColor: '#4fa7f3'
                                    }
                            )
                        });
                        $('.sa-warning').click(function () {
                            swal({
                                title: 'Are you sure?',
                                text: 'You will not be able to recover this selected file!',
                                type: 'warning',
                                showCancelButton: true,
                                confirmButtonColor: '#d57171',
                                cancelButtonColor: '#b7b7b7',
                                confirmButtonText: 'Delete'
                            }).then(function () {
                                swal(
                                        'Deleted!',
                                        'Your file has been deleted.',
                                        'success'
                                        )
                            })
                        });
                    });
                });
            </script>";
    });
