<?php

namespace Plugins\SampleMaster\Providers;

use Aksara\Providers\AbstractModuleProvider;

class StoreServiceProvider extends AbstractModuleProvider
{
    public function safeBoot()
    {
        /**
         * add-capabilities
         */
        \Eventy::addAction('aksara.init', function () {

            add_capability(
                __('sample-master::store.title'),
                'master-store'
            );

            add_capability(
                __('sample-master::store.labels.add_store'),
                'add-master-store',
                'master-store'
            );

            add_capability(
                __('sample-master::store.labels.edit_store'),
                'edit-master-store',
                'master-store'
            );

            add_capability(
                __('sample-master::store.labels.delete_store'),
                'delete-master-store',
                'master-store'
            );
        });

        \Eventy::addAction('aksara.init-completed', function () {
            $args = [
                'page_title' => __('sample-master::store.title'),
                'menu_title' => __('sample-master::store.title'),
                'capability' => [ 'master-store' ],
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

            $managerStore = [
                'slug' => '/sample-store/{store_id}/manager/store',
                'method' => 'POST',
                'args' => [
                    'as' => 'sample-store-manager-store',
                    'uses' => '\Plugins\SampleMaster\Http\Controllers\StoreController@storeManager',
                ],
            ];

            \AksaraRoute::addRoute($managerStore);

            $managerUpdate = [
                'slug' => '/sample-store/{store_id}/manager/{id}/update',
                'method' => 'POST',
                'args' => [
                    'as' => 'sample-store-manager-update',
                    'uses' => '\Plugins\SampleMaster\Http\Controllers\StoreController@updateManager',
                ],
            ];

            \AksaraRoute::addRoute($managerUpdate);

            $productAdd = [
                'slug' => '/sample-store/{store_id}/products',
                'method' => 'POST',
                'args' => [
                    'as' => 'sample-store-product-store',
                    'uses' => '\Plugins\SampleMaster\Http\Controllers\StoreController@addProduct',
                ],
            ];

            //TODO wth????kok tiba2 nggak kedaftar
            \AksaraRoute::addRoute($productAdd);

            $productRemove = [
                'slug' => '/sample-store/{store_id}/products/{product_id}/remove',
                'method' => 'GET',
                'args' => [
                    'as' => 'sample-store-product-remove',
                    'uses' => '\Plugins\SampleMaster\Http\Controllers\StoreController@removeProduct',
                ],
            ];

            \AksaraRoute::addRoute($productRemove);

        });
    }
}

