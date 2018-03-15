<?php
namespace App\Aksara\Core\AdminMenu;

\Eventy::addAction('aksara.init',function(){

    \App::singleton('menu', function () {
        return new \App\Aksara\Core\AdminMenu\AdminMenu();
    });

    \App::singleton('menuToolbar', function () {
        return new \App\Aksara\Core\AdminMenu\AdminMenuToolbar();
    });

    // 60 Tools
    $args = [
        'page_title' => __('core:admin-menu::default.tools'),
        'menu_title' => __('core:admin-menu::default.tools'),
        'icon'       => 'ti-panel',
        'capability' => [],
        'routeName'  => 'ti-package',
        'render'     => false,
        'position'   => 60
      ];
    add_admin_menu_route($args);

    // 70 aksara-menu-options
    $args = [
        'page_title' => __('core:admin-menu::default.options'),
        'menu_title' => __('core:admin-menu::default.options'),
        'icon'       => 'ti-settings',
        'capability' => [],
        'routeName'  => 'aksara-menu-options',
        'render'     => false,
        'position'   => 70
      ];

    add_admin_menu_route($args);

    // 80 aksara-menu-options appeareance
    $args = [
        'page_title' => __('core:admin-menu::default.appearance'),
        'menu_title' => __('core:admin-menu::default.appearance'),
        'icon'       => 'ti-ruler-pencil',
        'capability' => [],
        'routeName'  => 'aksara-menu-options-appereance',
        'render'     => false,
        'position'   => 80
      ];

    add_admin_menu_route($args);

    // 90 aksara-menu-user
    $args = [
        'page_title' => __('core:admin-menu::default.user'),
        'menu_title' => __('core:admin-menu::default.user'),
        'icon'       => 'ti-user',
        'capability' => [],
        'routeName'  => 'aksara-menu-user',
        'render'     => false,
        'position'   => 90
      ];

    add_admin_menu_route($args);
},1,10);
