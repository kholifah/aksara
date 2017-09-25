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
                return;
            }

            if (!isset($args['route']['slug'])) {
                return;
            }

            if (!isset($args['route']['args'])) {
                return;
            }

            if (!isset($args['route']['args']['as'])) {
                return;
            }

            if (!isset($args['route']['args']['uses'])) {
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
            $args['capability'] = '';
        }

        $this->addMenuPage($args['page_title'], $args['menu_title'], $args['routeName'], $args['position'], $args['icon'], $args['capability']);
    }


    public function addSubMenuPageController(string $parrentRouteName, $args = [])
    {
        if (!isset($args['routeName'])) {
            if (!isset($args['route'])) {
                return;
            }

            if (!isset($args['route']['slug'])) {
                return;
            }

            if (!isset($args['route']['args'])) {
                return;
            }

            if (!isset($args['route']['args']['as'])) {
                return;
            }

            if (!isset($args['route']['args']['uses'])) {
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
            $args['capability'] = '';
        }

        $this->addSubMenuPage($parrentRouteName, $args['page_title'], $args['menu_title'], $args['routeName'], $args['position'], $args['icon'], $args['capability']);
    }

    public function addMenuPage(string $pageTitle, string $menuTitle, string  $routeName, $position = 20, string $icon = 'ti-pin-alt', string $capability ='')
    {
        $adminMenu = \Config::get('aksara.admin_menu');

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
              ];

        array_push($adminMenu[$position], $menu);

        \Config::Set('aksara.admin_menu', $adminMenu);
    }

    public function addSubMenuPage(string $parrentRouteName, string $pageTitle, string $menuTitle, string $routeName, string $icon = 'ti-pin-alt', string $capability = '')
    {
        $adminSubMenu = \Config::get('aksara.admin_sub_menu');

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

        \Config::Set('aksara.admin_sub_menu', $adminSubMenu);
    }


    /*
     *   0 -> Dashboard
     *  10 -> Post Type
     *  20 -> Banner / Sidebar
     *  30 -> THeme Options
     *
     */
    public function render()
    {
        $adminMenu = \Config::get('aksara.admin_menu');
        $adminSubMenu = \Config::get('aksara.admin_sub_menu');

        // sort array
        ksort($adminMenu);

        echo view('admin:aksara::partials.admin-menu', compact('adminMenu', 'adminSubMenu'))->render();
    }

    public function removeAdminMenu($adminMenuRoute)
    {
    }

    public function removeAdminSubMenu($adminSubMenuRoute)
    {
        $adminSubMenu = \Config::get('aksara.admin_sub_menu');

        foreach ($adminSubMenu as $menu => $subMenus) {
            foreach ($subMenus as $key => $subMenu) {
                if ($subMenu['routeName'] == $adminSubMenuRoute) {
                    unset($adminSubMenu[$menu][$key]);
                    \Config::set('aksara.admin_sub_menu', $adminSubMenu);
                    return;
                }
            }
        }
    }
}
