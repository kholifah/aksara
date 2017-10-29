<?php

\Eventy::addAction('aksara.init', function () {
    $optionIndex = [
                    'page_title' => 'Multi Bahasa',
                    'menu_title' => 'Multi Bahasa',
                    'icon'       => 'ti-brush-alt',
                    'capability' => '',
                    'route'      => [
                                       'slug' => '/aksara-multibas-option',
                                       'args' => [
                                                    'as' => 'aksara-multibas-option',
                                                    'uses' => '\App\Modules\Plugins\AksaraMultiBas\Http\OptionController@index',
                                                  ],
                                       ]
                    ];

    add_admin_sub_menu_route('aksara-menu-options',$optionIndex);

    $route = \App::make('route');

    $optionSave = [
     'slug' => '//aksara-multibas-option',
     'method' => 'POST',
     'args' => [
                  'as' => 'aksara-multibas-option-save',
                  'uses' => '\App\Modules\Plugins\AksaraMultiBas\Http\OptionController@save',
                ],
     ];

    $route->addRoute($optionSave);
},200);


// \Eventy::addAction('aksara.admin.footer', function () {
//     // only inject JS in menu management
//     if (\Request::route()->getName() != 'aksara-multibas-option') {
//         return;
//     }
//
//
// });
