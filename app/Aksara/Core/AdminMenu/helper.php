<?php

function add_admin_menu_route( $args )
{
  $menu = \App::make('menu');
  $menu->addMenuPageController($args);

}

function add_admin_sub_menu_route( $parrentRouteName, $args )
{
  $menu = \App::make('menu');
  $menu->addSubMenuPageController($parrentRouteName, $args);

}
