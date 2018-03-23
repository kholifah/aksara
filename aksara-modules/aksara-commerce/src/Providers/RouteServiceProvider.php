<?php
namespace Plugins\AksaraCommerce\Providers;

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

            $argsPost = [
                'label' => [
                    'name' =>  __('aksara-commerce::global.product'),
                ],
                'route' => 'product',
                'icon' => 'ti-shopping-cart'
            ];

            register_post_type('product', $argsPost);

            $argsCategory = [
                'label' => [
                    'name' => __('aksara-commerce::global.product-category'),
                ],
            ];

            register_taxonomy('product-category', ['product'], $argsCategory);

            add_post_type_to_taxonomy('category', 'product');
        });

        \Eventy::addAction('aksara.init', function () {

          // $metabox = \App::make('metabox');
            // bisa juga pake kelas kalau mau
            add_meta_box(
                'e-commerce-metabox',
                'product',
                'Plugins\AksaraCommerce\MetaBox@render',
                'Plugins\AksaraCommerce\MetaBox@save'
            );
        });
    }
}