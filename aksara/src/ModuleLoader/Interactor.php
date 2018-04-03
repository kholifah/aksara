<?php

namespace Aksara\ModuleLoader;

use Aksara\ModuleRegistry\ModuleManifest;
use Illuminate\Foundation\AliasLoader;

class Interactor implements ModuleLoaderInterface
{
    public function load(ModuleManifest $module)
    {
        $providers = $module->getProviders();
        foreach ($providers as $provider) {
            app()->register($provider);
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

