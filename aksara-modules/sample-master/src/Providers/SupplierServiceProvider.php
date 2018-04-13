<?php

namespace Plugins\SampleMaster\Providers;

use Aksara\Providers\AbstractModuleProvider;

class SupplierServiceProvider extends AbstractModuleProvider
{
    public function safeBoot()
    {
        \Eventy::addAction('aksara.init-completed', function () {
            $args = [
                'page_title' => 'Supplier',
                'menu_title' => 'Supplier',
                'icon' => 'ti-user',
                'capability' => '',
                'route' => [
                    'slug' => '/sample-supplier',
                    'args' => [
                        'as' => 'sample-supplier',
                        'uses' => '\Plugins\SampleMaster\Http\Controllers\SupplierController@index',
                    ],
                ]
            ];
            add_admin_sub_menu_route('sample-master', $args);

            $supplierCreate = [
                'slug' => '/sample-supplier/create',
                'method' => 'GET',
                'args' => [
                    'as' => 'sample-supplier-create',
                    'uses' => '\Plugins\SampleMaster\Http\Controllers\SupplierController@create',
                ],
            ];

            \AksaraRoute::addRoute($supplierCreate);

            $supplierStore = [
                'slug' => '/sample-supplier/store',
                'method' => 'POST',
                'args' => [
                    'as' => 'sample-supplier-store',
                    'uses' => '\Plugins\SampleMaster\Http\Controllers\SupplierController@store',
                ],
            ];

            \AksaraRoute::addRoute($supplierStore);

            $supplierEdit = [
                'slug' => '/sample-supplier/{id}/edit',
                'method' => 'GET',
                'args' => [
                    'as' => 'sample-supplier-edit',
                    'uses' => '\Plugins\SampleMaster\Http\Controllers\SupplierController@edit',
                ],
            ];

            \AksaraRoute::addRoute($supplierEdit);

            $supplierUpdate = [
                'slug' => '/sample-supplier/{id}/update',
                'method' => 'PUT',
                'args' => [
                    'as' => 'sample-supplier-update',
                    'uses' => '\Plugins\SampleMaster\Http\Controllers\SupplierController@update',
                ],
            ];

            \AksaraRoute::addRoute($supplierUpdate);

            $supplierDestroy = [
                'slug' => '/sample-supplier/{id}/destroy',
                'method' => 'GET',
                'args' => [
                    'as' => 'sample-supplier-destroy',
                    'uses' => '\Plugins\SampleMaster\Http\Controllers\SupplierController@destroy',
                ],
            ];

            \AksaraRoute::addRoute($supplierDestroy);
        });
    }
}

