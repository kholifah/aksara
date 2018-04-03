<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Foundation\AliasLoader;

class ModuleServiceProvider extends ServiceProvider
{
    private $hasBackend;
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
        $this->hasBackend = false;

        foreach ($modules as $module) {
            \ModuleLoader::load($module);
            if ($module->getType() == 'backend') {
                $this->hasBackend = true;
            }
        }

        if (!$this->hasBackend) {
            $defaultBackendConfig = config('aksara.default_backend');
            \ModuleRegistry::activateModule($defaultBackendConfig, true);
            $defaultBackend = \ModuleRegistry::getManifest(
                $defaultBackendConfig);
            \ModuleLoader::load($defaultBackend);
            admin_notice('warning', 'No backend activated, default backend will be activated', true);
        }
    }
}
