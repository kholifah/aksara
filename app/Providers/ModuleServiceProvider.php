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
        \Blade::directive('extends_backend', function ($view) {
            $view = str_replace("'", "", $view);
            $activeView = get_active_backend_view($view);
            if (!$activeView) {
                \Blade::compileString("@extends('$view')");
                return;
            }
            $extended = "@extends('$activeView')";

            \Blade::compileString($extended);
        });
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
        $activeBackend = 0;

        foreach ($modules as $module) {
            \ModuleLoader::load($module);
            if ($module->getType() == 'backend') {
                $activeBackend++;
            }
        }

        if ($activeBackend <= 0) {
            $defaultBackendConfig = config('aksara.default_backend');
            \ModuleRegistry::activateModule($defaultBackendConfig);
            $defaultBackend = \ModuleRegistry::getManifest(
                $defaultBackendConfig);
            \ModuleLoader::load($defaultBackend);
            admin_notice('warning',
                'No backend activated, default backend will be activated', true);
        }

        if ($activeBackend > 1) {
            $deactivates = get_deactivate_backends();
            foreach ($deactivates as $deactivate) {
                \ModuleRegistry::deactivateModule($deactivate->getName());
            }
        }
    }
}
