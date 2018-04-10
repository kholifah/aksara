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
        $activeFrontend = 0;

        foreach ($modules as $module) {
            \ModuleLoader::load($module);
            if ($module->getType() == 'backend') {
                $activeBackend++;
            }
            if ($module->getType() == 'frontend') {
                $activeFrontend++;
            }
        }

        if ($activeBackend <= 0) {
            $this->activateDefaultTheme('backend');
        }

        if ($activeBackend > 1) {
            $this->deactivateOtherThemes('backend');
        }

        if ($activeFrontend > 1) {
            $this->deactivateOtherThemes('frontend');
        }
    }

    private function deactivateOtherThemes($type)
    {
        $deactivates = get_deactivate_themes($type);
        foreach ($deactivates as $deactivate) {
            \ModuleRegistry::deactivateModule($deactivate->getName());
        }
    }

    private function activateDefaultTheme($type)
    {
        $defaultThemeConfig = config("aksara.default.$type");

        \ModuleRegistry::activateModule($defaultThemeConfig);
        $defaultTheme = \ModuleRegistry::getManifest(
            $defaultThemeConfig);
        \ModuleLoader::load($defaultTheme);
        admin_notice('warning',
            "No $type activated, default $type will be activated", true);
    }
}
