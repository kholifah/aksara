<?php
namespace Plugins\Option\Providers;

use Illuminate\Support\ServiceProvider;

class RouteServiceProvider extends ServiceProvider
{
    /**
     * Boot application services
     *
     * e.g, route, anything needs to be preload
     */
    public function boot()
    {
        \Eventy::addAction('aksara.init-completed', function () {
            $optionIndex = [
                'page_title' => __('option::page.general_option'),
                'menu_title' => __('option::menu.general_option'),
                'icon'       => 'ti-brush-alt',
                'capability' => '',
                'route'      => [
                                   'slug' => '/aksara-option',
                                   'args' => [
                                                'as' => 'aksara-option',
                                                'uses' => '\Plugins\Option\Http\Controllers\OptionController@index',
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
                                  'uses' => '\Plugins\Option\Http\Controllers\OptionController@save',
                                ],
                     ];

            $route->addRoute($optionSave);
        });

        /*
         * Apply language
         */
        \Eventy::addAction('aksara.init', function () {
            $site_options = get_options('site_options', []);

            if(isset($site_options['language'])) {
                \App::setLocale($site_options['language']);
            }
        },1);


        /*
         *  Apply filter for application name
         */
        \Eventy::addFilter('aksara.application_name', function ($name) {
            $site_options = get_options('site_options', []);

            if (isset($site_options['application_name']) && $site_options['application_name'] !== "") {
                return $site_options['application_name'];
            }

            return $name;
        });

        /*
         *  Apply filter for application title
         */
        \Eventy::addFilter('aksara.site-title', function ($name) {
            $site_options = get_options('site_options', []);

            if (isset($site_options['site_title']) && $site_options['site_title'] !== "") {
                return $site_options['site_title'];
            }

            return $name;
        });


        /*
         *  Apply filter for admin site title
         */
        \Eventy::addFilter('aksara.admin_site_title', function ($name) {
            $site_options = get_options('site_options', []);

            if (isset($site_options['admin_site_title']) && $site_options['admin_site_title'] !== "") {
                return $site_options['admin_site_title'];
            }

            return $name;
        });

        /*
         *  Apply filter for site tagline
         */
        \Eventy::addFilter('aksara.tagline', function ($name) {
            $site_options = get_options('site_options', []);

            if (isset($site_options['tagline']) && $site_options['tagline'] !== "") {
                return $site_options['tagline'];
            }

            return $name;
        });

    }
}

