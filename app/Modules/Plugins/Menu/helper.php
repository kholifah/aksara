<?php

// register_menu( ['footer' => [
//                   'label' => 'Footer'
//                 ]]
//               );
function register_menu( $menu )
{
    $menus = \Config::get('aksara.menu.menus',[]);

    $key = aksara_slugify( key($menu) );

    $menus[$key] = $menu[$key];

    \Config::set('aksara.menu.menus',$menus);
}

function get_registered_menu()
{
  return \Config::get('aksara.menu.menus',[]);
}

function get_menus( $json = false )
{
  $menus =  get_options('aksara.menu.menus',[]);

  if( !$json )
    $menus = json_decode($menus);

  return $menus;
}
