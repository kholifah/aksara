<?php

namespace App\Aksara\Core\AdminMenu;

class AdminMenuToolbar
{
    function registerAdminToolbarMenu($args) {
        $adminMenus = \Config::get('aksara.admin-menu.toolbar-menu',[]);

        if (!$adminMenus) {
            $adminMenu = [];
        }

        if( !isset($args['position']) ) {
            $args['position'] = 10;
        }

        if( !isset($args['class']) ) {
            $args['class'] = '';
        }

        if (!isset($adminMenus[$args['position']])) {
            $adminMenus[$args['position']] = [];
        }

        $menu = [
              'title' => $args['menuTitle'],
              'capability' => $args['capability'],
              'url' => $args['url'],
              'class' => $args['class'],
              ];


        array_push($adminMenu[$args['position']], $menu);

        \Config::Set('aksara.admin-menu.toolbar-menu', $adminMenus);
    }

    public function renderAdminToolbarMenu()
    {
        $adminMenus = \Config::get('aksara.admin-menu.toolbar-dropdown-menu',[]);

        ksort($adminMenus);

        echo view(get_active_backend_view('partials.admin-menu'), compact('adminMenus'))->render();
    }

    function registerAdminToolbarDropDownMenu($args) {
        $adminMenus = \Config::get('aksara.admin-menu.toolbar-dropdown-menu',[]);

        if (!$adminMenus) {
            $adminMenu = [];
        }

        if( !isset($args['position']) ) {
            $args['position'] = 10;
        }

        if( !isset($args['class']) ) {
            $args['class'] = '';
        }

        if (!isset($adminMenus[$args['position']])) {
            $adminMenus[$args['position']] = [];
        }

        $menu = [
              'title' => $args['menuTitle'],
              'capability' => $args['capability'],
              'url' => $args['url'],
              'class' => $args['class'],
              ];


        array_push($adminMenus[$args['position']], $menu);

        \Config::Set('aksara.admin-menu.toolbar-dropdown-menu', $adminMenus);
    }

    public function renderAdminToolbarDropDownMenu()
    {
        $adminMenus = \Config::get('aksara.admin-menu.toolbar-dropdown-menu',[]);
        ksort($adminMenus);

        echo view(get_active_backend_view('partials.toolbar-dropdown-menu'), compact('adminMenus'))->render();
    }
}
