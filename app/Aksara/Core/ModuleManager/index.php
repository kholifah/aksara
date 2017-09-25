<?php
// Only load module manager if load_all  == false

\Eventy::addAction('aksara.init', function () {
    if (!\Config::get('aksara.module_manager.load_all', false)) {
        $moduleManagerIndex = [
                      'page_title' => 'Module Manager',
                      'menu_title' => 'Module Manager',
                      'icon'       => 'ti-layout-menu-v',
                      'position'   => 70,
                      'capability' => '',
                      'route'      => [
                                         'slug' => '/aksara-module-manager',
                                         'args' => [
                                                      'as' => 'module-manager.index',
                                                      'uses' => '\App\Aksara\Core\ModuleManager\Http\ModuleManagerController@index',
                                                    ],
                                         ]
                      ];

        add_admin_menu_route($moduleManagerIndex);

        $route = \App::make('route');

        $moduleManagerSave = [
               'slug' => '/aksara-module-manager/activate/{slug}',
               'method' => 'POST',
               'args' => [
                            'as' => 'module-manager.activate',
                            'uses' => '\App\Aksara\Core\ModuleManager\Http\ModuleManagerController@activate',
                          ],
               ];

        $route->addRoute($moduleManagerSave);

        $moduleManagerSave = [
               'slug' => '/aksara-module-manager/deactivate/{slug}',
               'method' => 'POST',
               'args' => [
                            'as' => 'module-manager.deactivate',
                            'uses' => '\App\Aksara\Core\ModuleManager\Http\ModuleManagerController@deactivate',
                          ],
               ];

        $route->addRoute($moduleManagerSave);

        $moduleManagerInfo = [
               'slug' => '/aksara-module-manager/activate/{slug}',
               'method' => 'GET',
               'args' => [
                            'as' => 'module-manager.activation-info',
                            'uses' => '\App\Aksara\Core\ModuleManager\Http\ModuleManagerController@activationInfo',
                          ],
               ];

        $route->addRoute($moduleManagerInfo);
    }
});
