<?php
namespace App\Aksara\Core\ModuleManager\Console\Commands;

trait PluginGetter
{
    private function allV2()
    {
        return \ModuleRegistry::getRegisteredModules();
    }

    private function getPluginV2($name)
    {
        if (!\ModuleRegistry::isRegistered($name)) {
            return false;
        }
        $plugin = \ModuleRegistry::getManifest($name);
        return $plugin;
    }

    private function allV1()
    {
        $modules = $this->config->get('aksara.modules');
        return $modules;
    }

    private function getPluginV1($type, $moduleName)
    {
        $modules = $this->allV1();

        if (!isset($modules[$type])) {
            $this->error('Jenis module '
                . $type
                .' tidak ada, gunakan [core,plugin,admin,front-end]');
        }

        if (!isset($modules[$type][$moduleName])) {
            $this->error('Module dengan nama '.$moduleName.' tidak ada');
        }

        $module = $modules[$type][$moduleName];

        return $module;
    }
}
