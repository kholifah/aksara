<?php
namespace Plugins\User\Providers;

use Illuminate\Support\ServiceProvider;

class RouteServiceProvider extends ServiceProvider
{
    /**
     * Boot application services
     *
     * e.g, route, anything needs to be preload
     */
    public function boot()
    {
        \Eventy::addAction('aksara.init-completed', function () {

            $args = [
                'page_title' => 'User',
                'menu_title' => 'User',
                'icon' => 'ti-user',
                'capability' => '',
                'route' => [
                    'slug' => '/aksara-user',
                    'args' => [
                        'as' => 'aksara-user',
                        'uses' => '\Plugins\User\Http\UserController@index',
                    ],
                ]
            ];
            add_admin_sub_menu_route('aksara-menu-user', $args);


            $args = [
                'page_title' => 'Edit Profile',
                'menu_title' => 'Edit Profile',
                'icon' => 'ti-user',
                'capability' => '',
                'route' => [
                    'slug' => '/aksara/user/edit-profile',
                    'args' => [
                        'as' => 'aksara.user.edit-profile',
                        'uses' => '\Plugins\User\Http\UserController@editProfile',
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
                    'uses' => '\Plugins\User\Http\UserController@create',
                ],
            ];
            $route->addRoute($userCreate);
            $userStore = [
                'slug' => '/aksara-user/store',
                'method' => 'POST',
                'args' => [
                    'as' => 'aksara-user-store',
                    'uses' => '\Plugins\User\Http\UserController@store',
                ],
            ];
            $route->addRoute($userStore);
            $userEdit = [
                'slug' => '/aksara-user/{id}/edit',
                'method' => 'GET',
                'args' => [
                    'as' => 'aksara-user-edit',
                    'uses' => '\Plugins\User\Http\UserController@edit',
                ],
            ];
            $route->addRoute($userEdit);
            $userUpdate = [
                'slug' => '/aksara-user/{id}/update',
                'method' => 'PUT',
                'args' => [
                    'as' => 'aksara-user-update',
                    'uses' => '\Plugins\User\Http\UserController@update',
                ],
            ];
            $route->addRoute($userUpdate);

            $userUpdate = [
                'slug' => '/aksara/user/update-profile',
                'method' => 'PUT',
                'args' => [
                    'as' => 'aksara.user.update-profile',
                    'uses' => '\Plugins\User\Http\UserController@update',
                ],
            ];
            $route->addRoute($userUpdate);

            $userDestroy = [
                'slug' => '/aksara-user/{id}/destroy',
                'method' => 'GET',
                'args' => [
                    'as' => 'aksara-user-destroy',
                    'uses' => '\Plugins\User\Http\UserController@destroy',
                ],
            ];
            $route->addRoute($userDestroy);

            $args = [
                'page_title' => 'Role',
                'menu_title' => 'Role',
                'icon' => 'ti-user',
                'capability' => '',
                'route' => [
                    'slug' => '/aksara-role',
                    'args' => [
                        'as' => 'aksara-role',
                        'uses' => '\Plugins\User\Http\RoleController@index',
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
                    'uses' => '\Plugins\User\Http\RoleController@create',
                ],
            ];
            $route->addRoute($userCreate);
            $userStore = [
                'slug' => '/aksara-role/store',
                'method' => 'POST',
                'args' => [
                    'as' => 'aksara-role-store',
                    'uses' => '\Plugins\User\Http\RoleController@store',
                ],
            ];
            $route->addRoute($userStore);
            $userEdit = [
                'slug' => '/aksara-role/{id}/edit',
                'method' => 'GET',
                'args' => [
                    'as' => 'aksara-role-edit',
                    'uses' => '\Plugins\User\Http\RoleController@edit',
                ],
            ];
            $route->addRoute($userEdit);
            $userUpdate = [
                'slug' => '/aksara-role/{id}/update',
                'method' => 'PUT',
                'args' => [
                    'as' => 'aksara-role-update',
                    'uses' => '\Plugins\User\Http\RoleController@update',
                ],
            ];
            $route->addRoute($userUpdate);
            $userDestroy = [
                'slug' => '/aksara-role/{id}/destroy',
                'method' => 'GET',
                'args' => [
                    'as' => 'aksara-role-destroy',
                    'uses' => '\Plugins\User\Http\RoleController@destroy',
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
    }
}
