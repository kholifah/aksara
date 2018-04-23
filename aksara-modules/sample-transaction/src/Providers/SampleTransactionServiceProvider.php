<?php

namespace Plugins\SampleTransaction\Providers;

use Aksara\Providers\AbstractModuleProvider;

class SampleTransactionServiceProvider extends AbstractModuleProvider
{
    public function safeBoot()
    {
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



