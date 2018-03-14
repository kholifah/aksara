<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Foundation\AliasLoader;
use Illuminate\Filesystem\Filesystem;
use Aksara\Plugin;
use Aksara\PluginRegistry\PluginRegistryHandler;

class PluginServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap the application services.
     *
     * @return void
     */
    public function boot()
    {
    }

    /**
     * Register the application services.
     *
     * @return void
     */
    public function register()
    {
        /**
         * plugin activation V2
         */

        $pluginRegistry = app(PluginRegistryHandler::class);
        $activePlugins = $pluginRegistry->getActivePlugins();

        foreach ($activePlugins as $plugin) {

            //register providers
            $providers = $plugin->getProviders();
            foreach ($providers as $provider) {
                $this->app->register($provider);
            }

            //register aliases
            $aliases = $plugin->getAliases();
            AliasLoader::getInstance($aliases)->register();

            //register paths
            $path = $pluginRegistry->getPluginPath($plugin->getName());

            //migration path
            if (is_dir($path->migration())) {
                app()->afterResolving('migrator', function ($migrator) use ($path) {
                    $migrator->path($path->migration());
                });
            }

            if (is_dir($path->view())) {
                //TODO plugin type (plugin/frontend) support
                //hardcoded for now for plugin
                view()->addNamespace('plugin:'.$plugin->getName(), $path->view());
            }
        }
    }
}
