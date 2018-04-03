<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Foundation\AliasLoader;

class ModuleServiceProvider extends ServiceProvider
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

        $modules = \ModuleRegistry::getActiveModules();

        foreach ($modules as $module) {

            //register providers
            $providers = $module->getProviders();
            foreach ($providers as $provider) {
                $this->app->register($provider);
            }

            //register aliases
            $aliases = $module->getAliases();
            AliasLoader::getInstance($aliases)->register();

            //register views
            if (is_dir($module->getModulePath()->view())) {
                view()->addNamespace($module->getName(),
                    $module->getModulePath()->view());
            }

            //register language namespace
            if (is_dir($module->getModulePath()->lang())) {
                app()->afterResolving('translator', function ($translator) use (
                    $module) {
                    $translator->addNamespace($module->getName(),
                        $module->getModulePath()->lang()
                    );
                });
            }

            //register migrations
            if (is_dir($module->getModulePath()->migration())) {
                app()->afterResolving('migrator', function ($migrator) use (
                    $module) {
                    $migrator->path($module->getModulePath()->migration());
                });
            }
        }
    }
}
