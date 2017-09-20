<?php

\Eventy::addAction( 'aksara.init_completed', function(){
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
});
