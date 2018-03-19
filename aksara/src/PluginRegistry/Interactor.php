<?php

namespace Aksara\PluginRegistry;

use Illuminate\Filesystem\Filesystem;
use Aksara\ModuleIdentifier;
use Aksara\AdminNotif\AdminNotifRequest;
use Aksara\AdminNotif\AdminNotifHandler;
use Aksara\Application\ApplicationInterface;

class Interactor implements PluginRegistryHandler
{
    const PLUGIN_FOLDER = 'aksara-plugins';
    const ACTIVE_MANIFEST = 'active_manifest.php';
    const PLUGIN_MANIFEST = 'plugin.php';

    private $filesystem;
    private $pluginRoot;
    private $activeManifestPath;
    private $app;

    public function __construct(
        ApplicationInterface $app,
        FileSystem $filesystem,
        AdminNotifHandler $notifHandler
    ){
        $this->app = $app;
        $this->filesystem = $filesystem;
        $this->pluginRoot = $this->app->basePath(self::PLUGIN_FOLDER);
        $this->activeManifestPath = $this->pluginRoot.
            DIRECTORY_SEPARATOR.self::ACTIVE_MANIFEST;
        $this->notifHandler = $notifHandler;
    }

    public function getPluginPath($name) : PluginPath
    {
        return new PluginPath($this->pluginRoot, $name);
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
        $activePluginNames = $this->getActiveManifest();
        $activePlugins = $this->loadPluginManifests($activePluginNames, true);
        return $activePlugins;
    }

    private function getActiveManifest()
    {
        if (!$this->filesystem->exists($this->activeManifestPath)) {
            return [];
        }
        $activeManifest = $this->filesystem->getRequire($this->activeManifestPath);
        return $activeManifest;
    }

    private function loadPluginManifests($pluginNames, $active = null)
    {
        $plugins = array();

        foreach ($pluginNames as $pluginName) {
            $plugin = $this->loadPluginManifest($pluginName, $active);
            $plugins[] = $plugin;
        }
        return $plugins;
    }

    private function loadPluginManifest($pluginName, $active = null)
    {
        $pluginManifestFile = $this->pluginRoot.
            DIRECTORY_SEPARATOR.$pluginName.DIRECTORY_SEPARATOR.
            self::PLUGIN_MANIFEST;

        if (!$this->filesystem->exists($pluginManifestFile)) {
            throw new \Exception('Plugin manifest file not found');
        }

        $configArray = $this->filesystem->getRequire($pluginManifestFile);

        $plugin = PluginManifest::fromPluginConfig(
            $configArray,
            $this->pluginRoot
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
        $this->writeActiveManifest($activeManifest);
        $this->successNotify($name);
    }

    public function deactivatePlugin($name)
    {
        $activeManifest = $this->filesystem->getRequire($this->activeManifestPath);
        $newManifest = array_diff($activeManifest, [ $name ]);
        $this->writeActiveManifest($newManifest);
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

    private function writeActiveManifest(array $manifest)
    {
        if (!$this->filesystem->isWritable(dirname($this->activeManifestPath))) {
            throw new \Exception(
                'The '.dirname($this->activeManifestPath).
                ' directory must be present and writable.');
        }

        $this->filesystem->put(
            $this->activeManifestPath, '<?php return '.var_export($manifest, true).';'
        );
    }

    public function getManifest($name)
    {
        return $this->loadPluginManifest($name);
    }
}

