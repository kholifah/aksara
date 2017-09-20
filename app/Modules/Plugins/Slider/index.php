<?php
\Eventy::addAction('aksara.init_completed',function(){

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

  $route = \App::make('route');

  $sliderSave = [
             'slug' => '/aksara-slider-save',
             'method' => 'POST',
             'args' => [
                          'as' => 'aksara-slider-save',
                          'uses' => '\App\Modules\Plugins\Slider\Http\SliderControlle@save',
                        ],
             ];

  $route->addRoute($sliderSave);

});
