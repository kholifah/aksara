<?php

namespace Aksara\ModuleLoader;

use Aksara\ModuleRegistry\ModuleManifest;
use Illuminate\Foundation\AliasLoader;
use Illuminate\Filesystem\Filesystem;

class Interactor implements ModuleLoaderInterface
{
    private $filesystem;

    public function __construct(Filesystem $filesystem)
    {
        $this->filesystem = $filesystem;
    }

    public function load(ModuleManifest $module)
    {
        $providers = $module->getProviders();
        foreach ($providers as $provider) {
            $providerInstance = new $provider(
                app(),
                $module->getName(),
                $module->getType()
            );
            app()->register($providerInstance);
        }

        //register aliases
        $aliases = $module->getAliases();
        AliasLoader::getInstance($aliases)->register();

        $modulePath = $module->getModulePath();

        //register views
        if (is_dir($modulePath->view())) {
            view()->addNamespace($module->getName(),
                $module->getModulePath()->view());
        }

        //register language namespace
        if (is_dir($modulePath->lang())) {
            app()->afterResolving('translator', function ($translator) use (
                $module) {
                $translator->addNamespace($module->getName(),
                    $module->getModulePath()->lang()
                );
            });
        }

        //register migrations
        if (is_dir($modulePath->migration())) {
            app()->afterResolving('migrator', function ($migrator) use (
                $module) {
                $migrator->path($module->getModulePath()->migration());
            });
        }

        //register configuration files
        if (is_dir($modulePath->config())) {
            app()->afterResolving('config', function ($config) use (
                $modulePath) {
                foreach ($this->filesystem->files($modulePath) as $path) {
                    $key = basename($path, '.php');
                    $configValues = $config->get($key, []);
                    $config->set($key, array_merge(require $path, $configValues));
                }
            });
        }
    }
}

