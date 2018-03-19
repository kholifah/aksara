<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Foundation\AliasLoader;

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

        $plugins = \PluginRegistry::getRegisteredPlugins();

        foreach ($plugins as $plugin) {

            /**
             * only load these when active
             * * service provider
             * * alias
             * * view
             */
            if ($plugin->getActive()) {
                //register providers
                $providers = $plugin->getProviders();
                foreach ($providers as $provider) {
                    $this->app->register($provider);
                }

                //register aliases
                $aliases = $plugin->getAliases();
                AliasLoader::getInstance($aliases)->register();

                //register views
                if (is_dir($plugin->getPluginPath()->view())) {
                    //TODO plugin type (plugin/frontend) support
                    //hardcoded for now for plugin
                    view()->addNamespace('plugin:'.$plugin->getName(),
                        $plugin->getPluginPath()->view());
                }
            }

            //migration is loaded regardless of active or not
            //enables system to migrate database without activating module
            if (is_dir($plugin->getPluginPath()->migration())) {
                app()->afterResolving('migrator', function ($migrator) use (
                    $plugin) {
                    $migrator->path($plugin->getPluginPath()->migration());
                });
            }
        }
    }
}
