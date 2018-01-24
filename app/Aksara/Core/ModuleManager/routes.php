<?php

\Eventy::addAction('aksara.init', function () {
    $route = \App::make('route');

    $moduleManagerSave = [
             'slug' => '/aksara-module-manager/activate/{type}/{slug}',
             'method' => 'POST',
             'args' => [
                          'as' => 'module-manager.activate',
                          'uses' => '\App\Aksara\Core\ModuleManager\Http\ModuleManagerController@activate',
                        ],
             ];

    $route->addRoute($moduleManagerSave);

    $moduleManagerSave = [
             'slug' => '/aksara-module-manager/deactivate/{type}/{slug}',
             'method' => 'POST',
             'args' => [
                          'as' => 'module-manager.deactivate',
                          'uses' => '\App\Aksara\Core\ModuleManager\Http\ModuleManagerController@deactivate',
                        ],
             ];

    $route->addRoute($moduleManagerSave);

    $moduleManagerInfo = [
             'slug' => '/aksara-module-manager/activate/{type}/{slug}',
             'method' => 'GET',
             'args' => [
                          'as' => 'module-manager.activation-info',
                          'uses' => '\App\Aksara\Core\ModuleManager\Http\ModuleManagerController@activationInfo',
                        ],
             ];

    $route->addRoute($moduleManagerInfo);

    $moduleManagerCheck = [
             'slug' => '/aksara-module-manager/check/{type}/{slug}',
             'method' => 'GET',
             'args' => [
                          'as' => 'module-manager.activation-check',
                          'uses' => '\App\Aksara\Core\ModuleManager\Http\ModuleManagerController@activationCheck',
                        ],
             ];

    $route->addRoute($moduleManagerCheck);
});
