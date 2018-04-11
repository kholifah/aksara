<?php

\Eventy::addAction('aksara.init', function () {

    $moduleManagerDeactivate = [
             'slug' => '/aksara-module-manager/deactivate/{type}/{slug}',
             'method' => 'POST',
             'args' => [
                          'as' => 'module-manager.deactivate',
                          'uses' => '\App\Aksara\Core\ModuleManager\Http\ModuleManagerController@deactivate',
                        ],
             ];

    \AksaraRoute::addRoute($moduleManagerDeactivate);

    $moduleManagerCheck = [
             'slug' => '/aksara-module-manager/check/{type}/{slug}',
             'method' => 'GET',
             'args' => [
                          'as' => 'module-manager.activation-check',
                          'uses' => '\App\Aksara\Core\ModuleManager\Http\ModuleManagerController@activationCheck',
                        ],
             ];

    \AksaraRoute::addRoute($moduleManagerCheck);

    $recursiveActivate = [
             'slug' => '/aksara-module-manager/activate-recursive/{type}/{slug}',
             'method' => 'POST',
             'args' => [
                          'as' => 'module-manager.activate-recursive',
                          'uses' => '\App\Aksara\Core\ModuleManager\Http\ModuleManagerController@recursiveActivate',
                        ],
             ];

    \AksaraRoute::addRoute($recursiveActivate);
});
