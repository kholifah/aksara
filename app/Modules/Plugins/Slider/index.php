<?php
\Eventy::addAction('aksara.init', function () {
    $sliderIndex = [
                    'page_title' => 'Site Slider',
                    'menu_title' => 'Site Slider',
                    'icon'       => 'ti-layout-slider',
                    'capability' => '',
                    'route'      => [
                                       'slug' => '/aksara-slider',
                                       'args' => [
                                                    'as' => 'aksara-slider',
                                                    'uses' => '\App\Modules\Plugins\Slider\Http\SliderController@index',
                                                  ],
                                       ]
                    ];

    add_admin_menu_route($sliderIndex);

    $sliderSave = [
             'slug' => '/aksara-slider-save',
             'method' => 'POST',
             'args' => [
                          'as' => 'aksara-slider-save',
                          'uses' => '\App\Modules\Plugins\Slider\Http\SliderController@save',
                        ],
             ];

    \AksaraRoute::addRoute($sliderSave);
});
