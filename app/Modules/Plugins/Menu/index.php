<?php

\Eventy::addAction('aksara.init',function()
{
  $menuIndex = [
    'page_title' => 'Site Menu',
    'menu_title' => 'Site Menu',
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

  add_admin_menu_route($menuIndex);

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

\Eventy::addAction('aksara.admin.footer',function()
{
    // only inject JS in menu management
    if( \Request::route()->getName() != 'aksara-menu' )
      return;
    // File JS / CSS masuk sini
    // @nanti dipindah ke resource
    ?>
    <script src="https://unpkg.com/vue"></script>

    <?php
    echo view('plugin:menu::script')->render();

});
