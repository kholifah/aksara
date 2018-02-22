<?php

\Eventy::addAction('aksara.init', function () {
    $route = \App::make('route');

    $moduleManagerDeactivate = [
             'slug' => '/aksara-module-manager/deactivate/{type}/{slug}',
             'method' => 'POST',
             'args' => [
                          'as' => 'module-manager.deactivate',
                          'uses' => '\App\Aksara\Core\ModuleManager\Http\ModuleManagerController@deactivate',
                        ],
             ];

    $route->addRoute($moduleManagerDeactivate);

    $moduleManagerCheck = [
             'slug' => '/aksara-module-manager/check/{type}/{slug}',
             'method' => 'GET',
             'args' => [
                          'as' => 'module-manager.activation-check',
                          'uses' => '\App\Aksara\Core\ModuleManager\Http\ModuleManagerController@activationCheck',
                        ],
             ];

    $route->addRoute($moduleManagerCheck);

    $recursiveActivate = [
             'slug' => '/aksara-module-manager/activate-recursive/{type}/{slug}',
             'method' => 'POST',
             'args' => [
                          'as' => 'module-manager.activate-recursive',
                          'uses' => '\App\Aksara\Core\ModuleManager\Http\ModuleManagerController@recursiveActivate',
                        ],
             ];

    $route->addRoute($recursiveActivate);
});
