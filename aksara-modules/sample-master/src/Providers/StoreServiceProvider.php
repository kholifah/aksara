<?php

namespace Plugins\SampleMaster\Providers;

use Aksara\Providers\AbstractModuleProvider;

class StoreServiceProvider extends AbstractModuleProvider
{
    public function safeBoot()
    {
        \Eventy::addAction('aksara.init-completed', function () {
            $args = [
                'page_title' => __('sample-master::store.title'),
                'menu_title' => __('sample-master::store.title'),
                'capability' => '',
                'route' => [
                    'slug' => '/sample-store',
                    'args' => [
                        'as' => 'sample-store',
                        'uses' => '\Plugins\SampleMaster\Http\Controllers\StoreController@index',
                    ],
                ]
            ];
            add_admin_sub_menu_route('sample-master', $args);

            $storeCreate = [
                'slug' => '/sample-store/create',
                'method' => 'GET',
                'args' => [
                    'as' => 'sample-store-create',
                    'uses' => '\Plugins\SampleMaster\Http\Controllers\StoreController@create',
                ],
            ];

            \AksaraRoute::addRoute($storeCreate);

            $storeStore = [
                'slug' => '/sample-store/store',
                'method' => 'POST',
                'args' => [
                    'as' => 'sample-store-store',
                    'uses' => '\Plugins\SampleMaster\Http\Controllers\StoreController@store',
                ],
            ];

            \AksaraRoute::addRoute($storeStore);

            $storeEdit = [
                'slug' => '/sample-store/{id}/edit',
                'method' => 'GET',
                'args' => [
                    'as' => 'sample-store-edit',
                    'uses' => '\Plugins\SampleMaster\Http\Controllers\StoreController@edit',
                ],
            ];

            \AksaraRoute::addRoute($storeEdit);

            $storeUpdate = [
                'slug' => '/sample-store/{id}/update',
                'method' => 'PUT',
                'args' => [
                    'as' => 'sample-store-update',
                    'uses' => '\Plugins\SampleMaster\Http\Controllers\StoreController@update',
                ],
            ];

            \AksaraRoute::addRoute($storeUpdate);

            $storeDestroy = [
                'slug' => '/sample-store/{id}/destroy',
                'method' => 'GET',
                'args' => [
                    'as' => 'sample-store-destroy',
                    'uses' => '\Plugins\SampleMaster\Http\Controllers\StoreController@destroy',
                ],
            ];

            \AksaraRoute::addRoute($storeDestroy);

        });
    }
}

