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
        $pluginRoot = $pluginRegistry->getPluginRoot();

        //register providers
        foreach ($activePlugins as $plugin) {
            $providers = $plugin->getProviders();
            foreach ($providers as $provider) {
                $this->app->register($provider);
            }
        }

        //register aliases
        foreach ($activePlugins as $plugin) {
            $aliases = $plugin->getAliases();
            AliasLoader::getInstance($aliases)->register();
        }

        //load helpers
        foreach ($activePlugins as $plugin) {
            $name = $plugin->getName();
            $helpers = $plugin->getHelpers();
            foreach ($helpers as $helper) {
                $pluginPath = $pluginRoot."/$name/$helper";
                if (file_exists($pluginPath)) {
                    require_once($pluginPath);
                }
            }
        }
    }
}
