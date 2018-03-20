<?php
namespace App\Aksara\Core\ModuleManager\Console\Commands;

trait PluginGetter
{
    private function getPluginV2($name)
    {
        if (!$this->pluginRegistry->isRegistered($name)) {
            return false;
        }
        $plugin = $this->pluginRegistry->getManifest($name);
        return $plugin;
    }

    private function getPluginV1($type, $moduleName)
    {
        $modules = $this->config->get('aksara.modules');

        if (!isset($modules[$type])) {
            $this->error('Jenis module '
                . $type
                .' tidak ada, gunakan [core,plugin,admin,front-end]');
        }

        if (!isset($modules[$type][$moduleName])) {
            $this->error('Module dengan nama '.$moduleName.' tidak ada');
        }

        $module = $modules[$type][$moduleName];

        if (!isset($module['migrationPath'])) {
            $this->info("Module [$type] $moduleName tidak memiliki direktori 'migrations'.");
            return false;
        }
        return $module;
    }
}
