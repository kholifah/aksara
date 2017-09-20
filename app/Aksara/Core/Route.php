<?php

namespace App\Aksara\Core;

class Route
{
  function __construct()
  {
    \Eventy::addAction('aksara.routes.admin','App\Aksara\Core\Route@registerRoutes');
  }

  function addRoute( $route , $location = 'admin' )
  {
    if( !isset($route['method'] ) )
      $route['method'] = 'GET';

    $menuRoutes = \Config::get( 'aksara.routes.'.$location, [] );

    array_push( $menuRoutes,$route );

    \Config::set( 'aksara.routes.'.$location, $menuRoutes );
  }


  function registerRoutes()
  {
    $menuRoutes = \Config::get('aksara.routes.admin',[]);

    foreach ( $menuRoutes as $menuRoute )
    {
      if( $menuRoute['method'] == 'DELETE' )
        \Route::delete( $menuRoute['slug'], $menuRoute['args'] );

      if( $menuRoute['method'] == 'POST' )
        \Route::post( $menuRoute['slug'], $menuRoute['args'] );

      if( $menuRoute['method'] == 'PUT' )
        \Route::put( $menuRoute['slug'], $menuRoute['args'] );

      if( $menuRoute['method'] == 'GET' )
        \Route::get( $menuRoute['slug'], $menuRoute['args'] );
    }

  }
}
