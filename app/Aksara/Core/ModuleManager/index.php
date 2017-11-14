<?php
// Only load module manager if load_all  == false

\Eventy::addAction('aksara.init', function () {
    if (!\Config::get('aksara.module_manager.load_all', false)) {
        $moduleManagerIndex = [
                      'page_title' => 'Module Manager',
                      'menu_title' => 'Module Manager',
                      'icon'       => 'ti-layout-menu-v',
                      'position'   => 30,
                      'capability' => [],
                      'route'      => [
                                         'slug' => '/aksara-module-manager',
                                         'args' => [
                                                      'as' => 'module-manager.index',
                                                      'uses' => '\App\Aksara\Core\ModuleManager\Http\ModuleManagerController@index',
                                                    ],
                                         ]
                      ];

        add_admin_menu_route($moduleManagerIndex);
    }
});
