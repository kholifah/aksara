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
        /**
         * Nothing to boot
         * Plugins should boot their services by themselves
         */
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
        }
    }
}
