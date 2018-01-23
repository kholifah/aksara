<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use App\Aksara\Core\ModuleManager\Console\Commands\MigrationStatusCommand;
use App\Aksara\Core\ModuleManager\Console\Commands\MigrationCheckCommand;

class AksaraServiceProvider extends ServiceProvider
{
    protected $commands = [
        'AksaraMigrateStatus' => 'command.aksara.migrate.status',
        'AksaraMigrateCheck' => 'command.aksara.migrate.check',
    ];

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

        $routeParamsFrontEnd = \Eventy::filter('aksara.middleware.admin', ['prefix' => 'admin', 'middleware' => ['web','csrf', 'auth']]);

        \Route::group($routeParamsFrontEnd, function () {
            \Eventy::action('aksara.routes.admin');
        });

        $routeParamsFrontEnd = \Eventy::filter('aksara.middleware.front_end', ['middleware' => ['web','csrf']]);
        \Route::group($routeParamsFrontEnd, function () {
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

        $this->registerCommands($this->commands);
    }

    /**
     * Register the given commands.
     *
     * @param  array  $commands
     * @return void
     */
    protected function registerCommands(array $commands)
    {
        foreach (array_keys($commands) as $command) {
            $function = "register{$command}Command";
            call_user_func_array([$this, $function], []);
        }

        $this->commands(array_values($commands));
    }

    /**
     * Define the routes for the application.
     *
     * @return void
     */
    public function map()
    {

    }

    protected function registerAksaraMigrateStatusCommand()
    {
        $this->app->singleton('command.aksara.migrate.status', function ($app) {
            return new MigrationStatusCommand($app['migrator']);
        });
    }

    protected function registerAksaraMigrateCheckCommand()
    {
        $this->app->singleton('command.aksara.migrate.check', function ($app) {
            return new MigrationCheckCommand($app['migrator']);
        });
    }
}
