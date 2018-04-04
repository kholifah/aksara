<?php
namespace Aksara\Providers;

use Illuminate\Support\ServiceProvider;

class ModuleDependencyServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        $this->app->bind(
            \Aksara\ModuleDependency\PluginRequiredBy::class,
            \Aksara\ModuleDependency\PluginRequiredByInteractor::class
        );

        $this->app->bind(
            'plugin_required_by',
            \Aksara\ModuleDependency\PluginRequiredBy::class
        );
    }
}

