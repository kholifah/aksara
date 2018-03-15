<?php

\Eventy::addAction('aksara.init', function () {
    $menuIndex = [
    'page_title' => __('plugin:menu::default.site-menu'),
    'menu_title' => __('plugin:menu::default.site-menu'),
    'icon'       => 'ti-layout-menu-v',
    'position'   => 80,
    'capability' => '',
    'route'      => [
                       'slug' => '/aksara-menu',
                       'args' => [
                                    'as' => 'aksara-menu',
                                    'uses' => '\App\Modules\Plugins\Menu\Http\MenuController@index',
                                  ],
                       ]
    ];

    add_admin_sub_menu_route('aksara-menu-options-appereance',$menuIndex);

    $route = \App::make('route');

    $menuSave = [
     'slug' => '/aksara-menu',
     'method' => 'POST',
     'args' => [
                  'as' => 'aksara-menu-save',
                  'uses' => '\App\Modules\Plugins\Menu\Http\MenuController@save',
                ],
     ];

    $route->addRoute($menuSave);
});

\Eventy::addAction('aksara.admin.footer', function () {
    // only inject JS in menu management
    if (\Request::route()->getName() != 'aksara-menu') {
        return;
    }
    // File JS / CSS masuk sini
    // @nanti dipindah ke resource ?>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/vue/2.4.4/vue.min.js"></script>

    <?php
    echo view('plugin:menu::script')->render();
});
