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

        $plugins = \PluginRegistry::getActivePlugins();

        foreach ($plugins as $plugin) {

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
                //view()->addNamespace($plugin->getType().':'.$plugin->getName(),
                    //$plugin->getPluginPath()->view());
                view()->addNamespace($plugin->getName(),
                    $plugin->getPluginPath()->view());
            }

            if (is_dir($plugin->getPluginPath()->lang())) {
                app()->afterResolving('translator', function ($translator) use (
                    $plugin) {
                    $translator->addNamespace($plugin->getName(),
                        $plugin->getPluginPath()->lang()
                    );
                });
            }

            //register migrations
            if (is_dir($plugin->getPluginPath()->migration())) {
                app()->afterResolving('migrator', function ($migrator) use (
                    $plugin) {
                    $migrator->path($plugin->getPluginPath()->migration());
                });
            }
        }
    }
}
