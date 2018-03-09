<?php

namespace Aksara\PluginRegistry;

use Illuminate\Filesystem\Filesystem;
use Aksara\Plugin;
use Aksara\ModuleIdentifier;
use Aksara\AdminNotif\AdminNotifRequest;
use Aksara\AdminNotif\AdminNotifHandler;

class Interactor implements PluginRegistryHandler
{
    private $filesystem;
    private $pluginRoot;
    private $manifestPath;

    public function __construct(
        FileSystem $filesystem,
        AdminNotifHandler $notifHandler
    ){
        $this->filesystem = $filesystem;
        $this->pluginRoot = base_path() . '/aksara-plugins';
        $this->manifestPath = $this->pluginRoot . '/manifest.php';
        $this->notifHandler = $notifHandler;
    }

    public function getRegisteredPlugins()
    {
        $registeredPluginNames = $this->getRegisteredPluginNames();
        $registeredPlugins = $this->loadPluginManifests($registeredPluginNames);
        return $registeredPlugins;
    }

    private function getRegisteredPluginNames()
    {
        $pluginDirs = $this->filesystem->directories($this->pluginRoot);
        //take last part only
        $registeredPluginNames = array_map(function ($fullDir) {
            $segments = explode('/', $fullDir);
            return $segments[count($segments)-1];
        }, $pluginDirs);
        return $registeredPluginNames;
    }

    public function getActivePlugins()
    {
        $activeManifest = $this->getActiveManifest();
        $activePlugins = $this->loadPluginManifests($activeManifest, true);
        return $activePlugins;
    }

    private function getActiveManifest()
    {
        if (!file_exists($this->manifestPath)) {
            return [];
        }
        $activeManifest = $this->filesystem->getRequire($this->manifestPath);
        return $activeManifest;
    }

    private function loadPluginManifests($manifest, $active = null)
    {
        $plugins = array();

        foreach ($manifest as $activePlugin) {
            $pluginConfig = $this->pluginRoot . "/$activePlugin/plugin.php";
            $plugin = $this->loadPluginConfig($pluginConfig, $active);
            $plugins[] = $plugin;
        }
        return $plugins;
    }

    private function loadPluginConfig($pluginManifest, $active)
    {
        if (!file_exists($pluginManifest)) {
            throw new \Exception('Plugin manifest not defined');
        }
        $plugin = Plugin::fromPluginConfig(
            $this->filesystem->getRequire($pluginManifest)
        );
        if (is_null($active)) {
            $active = $this->isActive($plugin->getName());
        }
        $plugin->setActive($active);
        return $plugin;
    }

    public function isActive($name)
    {
        $activeManifest = $this->getActiveManifest();
        return in_array($name, $activeManifest);
    }

    public function isRegistered($name)
    {
        $registeredPluginNames = $this->getRegisteredPluginNames();
        return in_array($name, $registeredPluginNames);
    }

    public function activatePlugin($name)
    {
        $activeManifest = $this->getActiveManifest();
        if (!in_array($name, $activeManifest)) {
            $activeManifest[] = $name;
        }
        $this->write($activeManifest);
        $this->successNotify($name);
    }

    public function deactivatePlugin($name)
    {
        $activeManifest = $this->filesystem->getRequire($this->manifestPath);
        $newManifest = array_diff($activeManifest, [ $name ]);
        $this->write($newManifest);
        $this->successNotify($name, false);
    }

    private function successNotify($name, $active = true)
    {
        $notifRequest = new AdminNotifRequest(
            'success',
            'plugin - ' . $name .  ' berhasil ' .
            ($active ? 'diaktifkan' : 'di non-aktifkan')
        );

        $this->notifHandler->handle($notifRequest);
    }

    private function write(array $manifest)
    {
        if (!is_writable(dirname($this->manifestPath))) {
            throw new \Exception(
                'The '.dirname($this->manifestPath).
                ' directory must be present and writable.');
        }

        $this->filesystem->put(
            $this->manifestPath, '<?php return '.var_export($manifest, true).';'
        );
    }

    public function getPluginRoot()
    {
        return $this->pluginRoot;
    }

}

