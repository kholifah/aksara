<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;

class AksaraServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap the application services.
     *
     * @return void
     */
    public function boot()
    {
        //@TODO Check installed or not
        if (!\Schema::hasTable('options')) {
            return;
        }

        // $post = \App::make('post');
        $module = \App::make('module');
        $module->moduleStatusChangeListener();

        // Load Core Plugin
        $module->loadModules('core', app_path('Aksara/Core'));

        // Load Plugin
        $module->loadModules('plugin', app_path('Modules/Plugins'));

        // Load Front End Themes
        $module->loadModules('front-end', app_path('Modules/Themes/FrontEnd'));

        // Load CMD Themes
        $module->loadModules('admin', app_path('Modules/Themes/Admin'));
        \Eventy::action('aksara.init');
        \Eventy::action('aksara.init-completed');

        if(is_admin()) {
            \Eventy::action('aksara.admin.init-completed');
        }

        \Eventy::action('aksara.routes.before');

        $argsGroupAdmin = \Eventy::filter('aksara.middleware.admin', ['prefix' => 'admin', 'middleware' => ['web','csrf', 'auth']]);

        \Route::group($argsGroupAdmin, function () {
            \Eventy::action('aksara.routes.admin');
        });

        $argsGroupFrontEnd = \Eventy::filter('aksara.middleware.front_end', ['middleware' => ['web','csrf']]);
        \Route::group($argsGroupFrontEnd, function () {
            \Eventy::action('aksara.routes.front_end');
        });

        \Eventy::action('aksara.routes.after');

        \Eventy::action('aksara.init-after-routes');
    }

    /**
     * Register the application services.
     *
     * @return void
     */
    public function register()
    {


        \App::singleton('route', function () {
            return new \App\Aksara\Core\Route();
        });

        \App::singleton('module', function () {
            return new \App\Aksara\Core\Module();
        });
    }

    /**
     * Define the routes for the application.
     *
     * @return void
     */
    // public function map()
    // {
    //   echo "--|--";
    // }
}
