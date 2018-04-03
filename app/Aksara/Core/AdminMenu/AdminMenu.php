<?php

namespace App\Aksara\Core\AdminMenu;

class AdminMenu
{
    // $args = [
    //           'page_title' => $pageTitle,
    //           'menu_title' => $menuTitle,
    //           'capability' => $capability,
    //           'route'      => [
    //                              'slug' => '/route'
    //                              'args' => [
    //                                          'as' => 'menu-custom-route',
    //                                          'uses' => 'Akasara\Core\Options\Http\Controller@index',
    //                                          ]
    //                              ]
    //           'routeName'  => $routeName,
    //           'icon' => $icon,
    //           ];
    public function addMenuPageController($args = [])
    {
        if (!isset($args['routeName'])) {
            if (!isset($args['route'])) {
                throw new Exception(__('core:admin-menu::message.required-route'));
            }

            if (!isset($args['route']['slug'])) {
                throw new Exception(__('core:admin-menu::message.required-route-slug'));
                return;
            }

            if (!isset($args['route']['args'])) {
                throw new Exception(__('core:admin-menu::message.required-route-args'));
                return;
            }

            if (!isset($args['route']['args']['as'])) {
                throw new Exception(__('core:admin-menu::message.required-route-name'));
                return;
            }

            if (!isset($args['route']['args']['uses'])) {
                throw new Exception(__('core:admin-menu::message.required-route-controller'));
                return;
            }

            \App::make('route')->addRoute($args['route']);

            // register named route
            $args['routeName'] = $args['route']['args']['as'];
        }

        //register route
        if (!isset($args['position'])) {
            $args['position'] = 40;
        }

        if (!isset($args['icon'])) {
            $args['icon'] = 'ti-pin-alt';
        }

        if (!isset($args['capability'])) {
            $args['capability'] = [];
        }

        if (!isset($args['render'])) {
            $args['render'] = true;
        }

        $this->addMenuPage($args['page_title'], $args['menu_title'], $args['routeName'], $args['position'], $args['icon'], $args['capability'], $args['render']);
    }


    public function addSubMenuPageController(string $parrentRouteName, $args = [])
    {
        if (!isset($args['routeName'])) {
            if (!isset($args['route'])) {
                throw new Exception(__('core:admin-menu::message.required-route'));
            }

            if (!isset($args['route']['slug'])) {
                throw new Exception(__('core:admin-menu::message.required-route-slug'));
                return;
            }

            if (!isset($args['route']['args'])) {
                throw new Exception(__('core:admin-menu::message.required-route-args'));
                return;
            }

            if (!isset($args['route']['args']['as'])) {
                throw new Exception(__('core:admin-menu::message.required-route-name'));
                return;
            }

            if (!isset($args['route']['args']['uses'])) {
                throw new Exception(__('core:admin-menu::message.required-route-controller'));
                return;
            }

            \App::make('route')->addRoute($args['route']);

            // register named route
            $args['routeName'] = $args['route']['args']['as'];
        }

        //register route
        if (!isset($args['position'])) {
            $args['position'] = 90;
        }

        if (!isset($args['icon'])) {
            $args['icon'] = 'ti-pin-alt';
        }

        if (!isset($args['capability'])) {
            $args['capability'] = [];
        }

        $this->addSubMenuPage($parrentRouteName, $args['page_title'], $args['menu_title'], $args['routeName'], $args['position'], $args['icon'], $args['capability']);
    }

    public function addMenuPage(string $pageTitle, string $menuTitle, string  $routeName, $position = 20, string $icon = 'ti-pin-alt', $capability=[], $render = true)
    {
        $adminMenu = \Config::get('aksara.admin-menu.admin-menu');

        if (!$adminMenu) {
            $adminMenu = [];
        }

        if (!isset($adminMenu[$position])) {
            $adminMenu[$position] = [];
        }

        $menu = [
              'page_title' => $pageTitle,
              'menu_title' => $menuTitle,
              'capability' => $capability,
              'routeName' => $routeName,
              'icon' => $icon,
              'render'=>$render
              ];

        array_push($adminMenu[$position], $menu);

        \Config::Set('aksara.admin-menu.admin-menu', $adminMenu);
    }

    public function addSubMenuPage(string $parrentRouteName, string $pageTitle, string $menuTitle, string $routeName, string $icon = 'ti-pin-alt', $capability=[])
    {
        $adminSubMenu = \Config::get('aksara.admin-menu.admin-sub-menu');

        if (!$adminSubMenu) {
            $adminSubMenu = [];
        }

        if (!isset($adminSubMenu[$parrentRouteName])) {
            $adminSubMenu[$parrentRouteName] = [];
        }

        $subMenu = [
              'page_title' => $pageTitle,
              'menu_title' => $menuTitle,
              'capability' => $capability,
              'routeName' => $routeName,
              'icon' => $icon,
              ];

        array_push($adminSubMenu[$parrentRouteName], $subMenu);

        \Config::Set('aksara.admin-menu.admin-sub-menu', $adminSubMenu);
    }

    public function render()
    {
        $adminMenu = \Config::get('aksara.admin-menu.admin-menu');
        $adminSubMenu = \Config::get('aksara.admin-menu.admin-sub-menu');

        // sort array
        ksort($adminMenu);

        foreach ($adminMenu as $position => $menus) {
            foreach ($menus as $priority => $menu) {
                if( $menu['render'] == false && !isset($adminSubMenu[$menu['routeName']]) )
                    unset($adminMenu[$position][$priority]);
            }
        }

        echo view('aksara-backend::partials.admin-menu', compact('adminMenu', 'adminSubMenu'))->render();
    }

    public function removeAdminMenu($adminMenuRoute)
    {
    }

    public function removeAdminSubMenu($adminSubMenuRoute)
    {
        $adminSubMenu = \Config::get('aksara.admin-menu.admin-sub-menu');

        foreach ($adminSubMenu as $menu => $subMenus) {
            foreach ($subMenus as $key => $subMenu) {
                if ($subMenu['routeName'] == $adminSubMenuRoute) {
                    unset($adminSubMenu[$menu][$key]);
                    \Config::set('aksara.admin-menu.admin-sub-menu', $adminSubMenu);
                    return;
                }
            }
        }
    }
}
