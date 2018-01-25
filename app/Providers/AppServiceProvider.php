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
            \Aksara\Repository\ConfigRepository::class,
            \App\Store\LaravelConfig::class
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
    }
}
