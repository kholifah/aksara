<?php

function add_admin_menu_route($args)
{
    $menu = \App::make('menu');
    $menu->addMenuPageController($args);
}

function remove_admin_menu($adminMenuRoute)
{
    $menu = \App::make('menu');
    $menu->removeAdminMenu($adminMenuRoute);
}

function remove_admin_sub_menu($adminSubMenuRoute)
{
    $menu = \App::make('menu');
    $menu->removeAdminSubMenu($adminSubMenuRoute);
}

function add_admin_sub_menu_route($parrentRouteName, $args)
{
    $menu = \App::make('menu');
    $menu->addSubMenuPageController($parrentRouteName, $args);
}


function add_admin_menu_toolbar($args)
{
    $menu = \App::make('menuToolbar');

    $menu->registerAdminToolbarMenu($args);
}
function add_admin_menu_toolbar_dropdown($args)
{
    $menu = \App::make('menuToolbar');
    $menu->registerAdminToolbarDropDownMenu($args);
}
function render_admin_menu_toolbar()
{
    $menu = \App::make('menuToolbar');
    $menu->renderAdminToolbarMenu();
}
function render_admin_menu_toolbar_dropdown()
{
    $menu = \App::make('menuToolbar');
    $menu->renderAdminToolbarDropDownMenu();
}
