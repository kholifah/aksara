<?php

// register_menu( ['footer' => [
//                   'label' => 'Footer'
//                 ]]
//               );
function register_menu($menu)
{
    $menus = \Config::get('aksara.menu.menus', []);

    $key = aksara_slugify(key($menu));

    $menus[$key] = $menu[$key];

    \Config::set('aksara.menu.menus', $menus);
}

function get_registered_menu()
{
    return \Config::get('aksara.menu.menus', []);
}

function get_menus($json = false)
{
    $menus =  get_options('aksara.menu.menus', []);
    if (!$json) {
        foreach ($menus as $menuId => $menuValue) {
            $menus[$menuId] = json_decode($menuValue,true);
        }
    }

    return $menus;
}

function get_menu($menuId, $json = false)
{
    $menus =  get_options('aksara.menu.menus', []);

    if( !isset($menus[$menuId]) )
        return [];

    if (!$json) {
        return $menus[$menuId] = json_decode($menus[$menuId],true);
    }

    return $menus[$menuId];
}
