<?php

namespace Plugins\SampleMaster\Providers;

use Aksara\Providers\AbstractModuleProvider;

class SampleMasterServiceProvider extends AbstractModuleProvider
{
    public function safeBoot()
    {
        \Eventy::addAction('aksara.init-completed', function () {

            $args = [
                'page_title' => 'Sample Master',
                'menu_title' => 'Sample Master',
                'icon'       => 'ti-layout-menu-v',
                'capability' => [],
                'routeName'  => 'sample-master',
                'render'     => false,
                'position'   => 90
            ];

            add_admin_menu_route($args);
        });
    }
}


