<?php
\Eventy::addAction('aksara.init', function () {
    $optionIndex = [
                    'page_title' => 'Site Option',
                    'menu_title' => 'Site Option',
                    'icon'       => 'ti-brush-alt',
                    'capability' => '',
                    'route'      => [
                                       'slug' => '/aksara-option',
                                       'args' => [
                                                    'as' => 'aksara-option',
                                                    'uses' => '\App\Modules\Plugins\Option\Http\OptionController@index',
                                                  ],
                                       ]
                    ];

    add_admin_sub_menu_route('aksara-menu-options',$optionIndex);

    $route = \App::make('route');

    $optionSave = [
             'slug' => '/aksara-option-save',
             'method' => 'POST',
             'args' => [
                          'as' => 'aksara-option-save',
                          'uses' => '\App\Modules\Plugins\Option\Http\OptionController@save',
                        ],
             ];

    $route->addRoute($optionSave);


    \Eventy::addFilter('aksara.application_name', function ($name) {
        $site_options = get_options('site_options', []);

        if (isset($site_options['application_name']) && $site_options['application_name'] !== "") {
            return $site_options['application_name'];
        }

        return $name;
    });

    \Eventy::addFilter('aksara.site_title', function ($name) {
        $site_options = get_options('site_options', []);

        if (isset($site_options['site_title']) && $site_options['site_title'] !== "") {
            return $site_options['site_title'];
        }

        return $name;
    });

    \Eventy::addFilter('aksara.admin_site_title', function ($name) {
        $site_options = get_options('site_options', []);

        if (isset($site_options['admin_site_title']) && $site_options['admin_site_title'] !== "") {
            return $site_options['admin_site_title'];
        }

        return $name;
    });

    \Eventy::addFilter('aksara.tagline', function ($name) {
        $site_options = get_options('site_options', []);

        if (isset($site_options['tagline']) && $site_options['tagline'] !== "") {
            return $site_options['tagline'];
        }

        return $name;
    });
});
