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
        $hasBackend = false;

        foreach ($modules as $module) {
            \ModuleLoader::load($module);
            if ($module->getType() == 'backend') {
                $hasBackend = true;
            }
        }

        if (!$hasBackend) {
            $defaultBackendConfig = config('aksara.default_backend');
            \ModuleRegistry::activateModule($defaultBackendConfig);
            $defaultBackend = \ModuleRegistry::getManifest(
                $defaultBackendConfig);
            \ModuleLoader::load($defaultBackend);
            admin_notice('warning',
                'No backend activated, default backend will be activated', true);
        }
    }
}
