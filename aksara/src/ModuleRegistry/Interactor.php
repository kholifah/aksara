<?php

namespace Aksara\ModuleRegistry;

use Illuminate\Filesystem\Filesystem;
use Aksara\ModuleIdentifier;
use Aksara\AdminNotif\AdminNotifRequest;
use Aksara\AdminNotif\AdminNotifHandler;
use Aksara\Application\ApplicationInterface;

class Interactor implements ModuleRegistryHandler
{
    const MODULE_FOLDER = 'aksara-modules';
    const ACTIVE_MANIFEST = 'active_manifest.php';
    const MODULE_MANIFEST = 'module.php';

    private $filesystem;
    private $moduleRoot;
    private $activeManifestPath;
    private $app;

    public function __construct(
        ApplicationInterface $app,
        FileSystem $filesystem,
        AdminNotifHandler $notifHandler
    ){
        $this->app = $app;
        $this->filesystem = $filesystem;
        $this->moduleRoot = $this->app->basePath(self::MODULE_FOLDER);
        $this->activeManifestPath = $this->moduleRoot.
            DIRECTORY_SEPARATOR.self::ACTIVE_MANIFEST;
        $this->notifHandler = $notifHandler;
    }

    public function getModulePath($name) : ModulePath
    {
        return new ModulePath($this->moduleRoot, $name);
    }

    public function getRegisteredModules()
    {
        $registeredPluginNames = $this->getRegisteredPluginNames();
        $registeredPlugins = $this->loadModuleManifests($registeredPluginNames);
        return $registeredPlugins;
    }

    private function getRegisteredPluginNames()
    {
        $pluginDirs = $this->filesystem->directories($this->moduleRoot);
        //take last part only
        $registeredPluginNames = array_map(function ($fullDir) {
            $segments = explode('/', $fullDir);
            return $segments[count($segments)-1];
        }, $pluginDirs);
        return $registeredPluginNames;
    }

    public function getActiveModules()
    {
        $activePluginNames = $this->getActiveManifest();
        $activePlugins = $this->loadModuleManifests($activePluginNames, true);
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

    private function loadModuleManifests($pluginNames, $active = null)
    {
        $plugins = array();

        foreach ($pluginNames as $pluginName) {
            $plugin = $this->loadModuleManifest($pluginName, $active);
            $plugins[] = $plugin;
        }
        return $plugins;
    }

    private function loadModuleManifest($pluginName, $active = null)
    {
        $pluginManifestFile = $this->moduleRoot.
            DIRECTORY_SEPARATOR.$pluginName.DIRECTORY_SEPARATOR.
            self::MODULE_MANIFEST;

        if (!$this->filesystem->exists($pluginManifestFile)) {
            throw new \Exception('Plugin manifest file not found');
        }

        $configArray = $this->filesystem->getRequire($pluginManifestFile);

        $plugin = ModuleManifest::fromPluginConfig(
            $configArray,
            $this->moduleRoot
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

    public function activateModule($name)
    {
        $activeManifest = $this->getActiveManifest();
        if (!in_array($name, $activeManifest)) {
            $activeManifest[] = $name;
        }
        $this->writeActiveManifest($activeManifest);
        $this->successNotify($name);
    }

    public function deactivateModule($name)
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
        return $this->loadModuleManifest($name);
    }
}

