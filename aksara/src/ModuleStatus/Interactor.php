<?php
namespace Aksara\ModuleStatus;

use Aksara\Repository\ConfigRepository;
use Aksara\Repository\OptionRepository;
use Aksara\ModuleStatusInfo;
use Aksara\PluginRegistry\PluginRegistryHandler;

class Interactor implements ModuleStatus
{
    private $configRepo;
    private $optionRepo;
    private $pluginRegistry;

    public function __construct(
        ConfigRepository $configRepo,
        OptionRepository $optionRepo,
        PluginRegistryHandler $pluginRegistry
    ){
        $this->configRepo = $configRepo;
        $this->optionRepo = $optionRepo;
        $this->pluginRegistry = $pluginRegistry;
    }

    public function getStatus($type, $moduleName) : ModuleStatusInfo
    {
        $isActive = $this->isActive($type, $moduleName);
        $isRegistered = $this->isRegistered($type, $moduleName);
        $version = $this->getVersion($type, $moduleName);

        return new ModuleStatusInfo(
            $type,
            $moduleName,
            $isActive,
            $isRegistered,
            $version
        );
    }

    public function getVersion($type, $moduleName) : int
    {
        if (strtolower($type) == 'plugin') {
            $pluginRegistered = $this->pluginRegistry->isRegistered($moduleName);

            if ($pluginRegistered) {
                return 2;
            }
        }
        return 1;
    }

    public function isRegistered($type, $moduleName) : bool
    {
        //check V2 first
        if (strtolower($type) == 'plugin') {
            $pluginRegistered = $this->pluginRegistry->isRegistered($moduleName);

            if ($pluginRegistered) {
                return true;
            }
        }

        $registeredModules = $this->configRepo->get('aksara.modules', []);

        if (!isset($registeredModules[$type])) {
            return false;
        }

        if (isset($registeredModules[$type][$moduleName])) {
            return true;
        }

        //not registered in any registry
        return false;
    }

    public function isActive($type, $moduleName) : bool
    {
        //check V2 first
        if (strtolower($type) == 'plugin') {
            $pluginActive = $this->pluginRegistry->isActive($moduleName);

            if ($pluginActive) {
                return true;
            }
        }

        // @TODO if front-end / admin should check first
        if ( $type =='admin' || $type == 'core') {
            return true;
        }

        if ($this->configRepo->get('aksara.module_manager.load_all', false)) {
            return true;
        }

        // get module status from databases
        $activeModules = $this->optionRepo->getOptions(
            'aksara.modules.actives', []
        );

        if (!isset($activeModules[$type])) {
            return false;
        }

        if (in_array($moduleName, $activeModules[$type])) {
            return true;
        }

        return false;
    }
}
