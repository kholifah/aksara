<?php

namespace Plugins\SampleMaster\Providers;

use Aksara\Providers\AbstractModuleProvider;

class ProductServiceProvider extends AbstractModuleProvider
{
    public function safeBoot()
    {
        /**
         * add-capabilities
         */
        \Eventy::addAction('aksara.init', function () {

            add_capability(
                __('sample-master::product.title'),
                'master-product'
            );

            add_capability(
                __('sample-master::product.labels.product_list'),
                'all-master-product',
                'master-product'
            );

            add_capability(
                __('sample-master::product.labels.add_product'),
                'add-master-product',
                'master-product'
            );

            add_capability(
                __('sample-master::product.labels.edit_product'),
                'edit-master-product',
                'master-product'
            );

            add_capability(
                __('sample-master::product.labels.delete_product'),
                'delete-master-product',
                'master-product'
            );
        });

        \Eventy::addAction('aksara.init-completed', function () {
            $args = [
                'page_title' => __('sample-master::product.title'),
                'menu_title' => __('sample-master::product.title'),
                'capability' => [ 'all-master-product' ],
                'route' => [
                    'slug' => '/sample-product',
                    'args' => [
                        'as' => 'sample-product',
                        'uses' => '\Plugins\SampleMaster\Http\Controllers\ProductController@index',
                    ],
                ]
            ];
            add_admin_sub_menu_route('sample-master', $args);

            $productCreate = [
                'slug' => '/sample-product/create',
                'method' => 'GET',
                'args' => [
                    'as' => 'sample-product-create',
                    'uses' => '\Plugins\SampleMaster\Http\Controllers\ProductController@create',
                ],
            ];

            \AksaraRoute::addRoute($productCreate);

            $productStore = [
                'slug' => '/sample-product/store',
                'method' => 'POST',
                'args' => [
                    'as' => 'sample-product-store',
                    'uses' => '\Plugins\SampleMaster\Http\Controllers\ProductController@store',
                ],
            ];

            \AksaraRoute::addRoute($productStore);

            $productEdit = [
                'slug' => '/sample-product/{id}/edit',
                'method' => 'GET',
                'args' => [
                    'as' => 'sample-product-edit',
                    'uses' => '\Plugins\SampleMaster\Http\Controllers\ProductController@edit',
                ],
            ];

            \AksaraRoute::addRoute($productEdit);

            $productUpdate = [
                'slug' => '/sample-product/{id}/update',
                'method' => 'PUT',
                'args' => [
                    'as' => 'sample-product-update',
                    'uses' => '\Plugins\SampleMaster\Http\Controllers\ProductController@update',
                ],
            ];

            \AksaraRoute::addRoute($productUpdate);

            $productDestroy = [
                'slug' => '/sample-product/{id}/destroy',
                'method' => 'GET',
                'args' => [
                    'as' => 'sample-product-destroy',
                    'uses' => '\Plugins\SampleMaster\Http\Controllers\ProductController@destroy',
                ],
            ];

            \AksaraRoute::addRoute($productDestroy);
        });
    }
}

