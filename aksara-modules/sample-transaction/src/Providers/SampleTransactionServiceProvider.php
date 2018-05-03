<?php

namespace Plugins\SampleTransaction\Providers;

use Aksara\Providers\AbstractModuleProvider;

class SampleTransactionServiceProvider extends AbstractModuleProvider
{
    public function safeRegister()
    {
        $this->app->singleton('price_calc', \Plugins\SampleTransaction\ProductPriceCalculator::class);
    }

    public function safeBoot()
    {
        \Eventy::addAction('aksara.init', function () {
            \AssetQueue::enqueueInlineScript(
                'admin',
                'var BASE_URL="'.url('/').'";',
                'sample-po-pre-script',
                10
            );
            aksara_admin_enqueue_script(url('assets/modules-v2/sample-transaction/js/jquery.min.js'),'jquery',10, true);
            aksara_admin_enqueue_script(url('assets/modules-v2/sample-transaction/js/script.js'),'sample-po-script',11, true);
        });

        \Eventy::addAction('aksara.init-completed', function () {

            $args = [
                'page_title' => 'Sample Transaction',
                'menu_title' => 'Sample Transaction',
                'icon'       => 'ti-layout-menu-v',
                'capability' => [],
                'routeName'  => 'sample-transaction',
                'render'     => false,
                'position'   => 90
            ];

            add_admin_menu_route($args);
        });
    }
}



