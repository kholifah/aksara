<?php

namespace Plugins\SampleTransaction\Providers;

use Aksara\Providers\AbstractModuleProvider;

class PurchaseOrderServiceProvider extends AbstractModuleProvider
{
    public function safeBoot()
    {
        \Eventy::addAction('aksara.init', function () {

            $script = '$(document).ready(function() {
                $("#order-date-picker").datepicker({
                    dateFormat: "dd M yy",
                    altField: "#order-date-field",
                    altFormat: "yy-mm-dd"
                });
                $("#estimated-delivery-date-picker").datepicker({
                    dateFormat: "dd M yy",
                    altField: "#estimated-delivery-date-field",
                    altFormat: "yy-mm-dd"
                });
            });';
            \AssetQueue::enqueueInlineScript(
                'admin',
                $script,
                'sample-po-pre-script',
                10
            );

        });
        \Eventy::addAction('aksara.init-completed', function () {
            $args = [
                'page_title' => __('sample-transaction::po.title'),
                'menu_title' => __('sample-transaction::po.title'),
                'capability' => '',
                'route' => [
                    'slug' => '/sample-po',
                    'args' => [
                        'as' => 'sample-po',
                        'uses' => '\Plugins\SampleTransaction\Http\Controllers\PurchaseOrderController@index',
                    ],
                ]
            ];
            add_admin_sub_menu_route('sample-transaction', $args);

            $poCreate = [
                'slug' => '/sample-po/create',
                'method' => 'GET',
                'args' => [
                    'as' => 'sample-po-create',
                    'uses' => '\Plugins\SampleTransaction\Http\Controllers\PurchaseOrderController@create',
                ],
            ];

            \AksaraRoute::addRoute($poCreate);

            $poStore = [
                'slug' => '/sample-po/store',
                'method' => 'POST',
                'args' => [
                    'as' => 'sample-po-store',
                    'uses' => '\Plugins\SampleTransaction\Http\Controllers\PurchaseOrderController@store',
                ],
            ];

            \AksaraRoute::addRoute($poStore);

            $poEdit = [
                'slug' => '/sample-po/{id}/edit',
                'method' => 'GET',
                'args' => [
                    'as' => 'sample-po-edit',
                    'uses' => '\Plugins\SampleTransaction\Http\Controllers\PurchaseOrderController@edit',
                ],
            ];

            \AksaraRoute::addRoute($poEdit);

            $poUpdate = [
                'slug' => '/sample-po/{id}/update',
                'method' => 'PUT',
                'args' => [
                    'as' => 'sample-po-update',
                    'uses' => '\Plugins\SampleTransaction\Http\Controllers\PurchaseOrderController@update',
                ],
            ];

            \AksaraRoute::addRoute($poUpdate);

            $poDestroy = [
                'slug' => '/sample-po/{id}/destroy',
                'method' => 'GET',
                'args' => [
                    'as' => 'sample-po-destroy',
                    'uses' => '\Plugins\SampleTransaction\Http\Controllers\PurchaseOrderController@destroy',
                ],
            ];

            \AksaraRoute::addRoute($poDestroy);

            $itemAdd = [
                'slug' => '/sample-po/{id}/items',
                'method' => 'POST',
                'args' => [
                    'as' => 'sample-po-store-item',
                    'uses' => '\Plugins\SampleTransaction\Http\Controllers\PurchaseOrderController@storeItem',
                ],
            ];

            \AksaraRoute::addRoute($itemAdd);

            $getPrice = [
                'slug' => '/po-product-price',
                'method' => 'GET',
                'args' => [
                    'as' => 'po-get-product-price',
                    'uses' => '\Plugins\SampleTransaction\Http\Controllers\PurchaseOrderRestController@getPriceInfo',
                ],
            ];

            \AksaraRoute::addRoute($getPrice);
        });
    }
}
