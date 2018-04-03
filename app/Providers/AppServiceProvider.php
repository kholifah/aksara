<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Schema;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        Schema::defaultStringLength(191);
    }

    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        $this->app->bind(
            \Aksara\Application\ApplicationInterface::class,
            \Aksara\Application\Laravel\LaravelApplication::class
        );

        $this->app->bind(
            \Aksara\Repository\ConfigRepository::class,
            \App\Store\LaravelConfig::class
        );

        $this->app->bind(
            \Aksara\Repository\SessionRepository::class,
            \App\Store\LaravelSessionStore::class
        );

        $this->app->bind(
            \Aksara\Repository\OptionRepository::class,
            \App\Store\Eloquent\EloquentOptionRepository::class
        );

        $this->app->bind(
            \Aksara\ModuleStatus\ModuleStatus::class,
            \Aksara\ModuleStatus\Interactor::class
        );

        $this->app->bind(
            \Aksara\ModuleDependency\PluginRequiredBy::class,
            \Aksara\ModuleDependency\PluginRequiredByInteractor::class
        );

        $this->app->bind(
            \Aksara\ErrorLoadModule\ErrorLoadModuleHandler::class,
            \Aksara\ErrorLoadModule\Interactor::class
        );

        $this->app->bind(
            \Aksara\UpdateModuleStatus\UpdateModuleStatusHandler::class,
            \Aksara\UpdateModuleStatus\Interactor::class
        );

        $this->app->bind(
            \Aksara\AdminNotif\AdminNotifHandler::class,
            \Aksara\AdminNotif\Interactor::class
        );

        $this->app->bind(
            \Aksara\ModuleRegistry\ModuleRegistryHandler::class,
            \Aksara\ModuleRegistry\Interactor::class
        );

        $this->app->bind(
            'module_registry',
            \Aksara\ModuleRegistry\ModuleRegistryHandler::class
        );

        $this->app->bind(
            'support_strings',
            \Aksara\Support\Strings::class
        );

        $this->app->bind(
            'support_arrays',
            \Aksara\Support\Arrays::class
        );

        $this->app->bind(
            \Aksara\ModuleLoader\ModuleLoaderInterface::class,
            \Aksara\ModuleLoader\Interactor::class
        );

        $this->app->bind(
            'module_loader',
            \Aksara\ModuleLoader\ModuleLoaderInterface::class
        );
    }
}
