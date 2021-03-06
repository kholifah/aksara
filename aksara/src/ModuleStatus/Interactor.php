<?php
namespace Aksara\ModuleStatus;

use Aksara\Repository\ConfigRepository;
use Aksara\Repository\OptionRepository;
use Aksara\ModuleStatusInfo;
use Aksara\ModuleRegistry\ModuleRegistryHandler;

class Interactor implements ModuleStatus
{
    private $configRepo;
    private $optionRepo;
    private $moduleRegistry;

    public function __construct(
        ConfigRepository $configRepo,
        OptionRepository $optionRepo,
        ModuleRegistryHandler $moduleRegistry
    ){
        $this->configRepo = $configRepo;
        $this->optionRepo = $optionRepo;
        $this->moduleRegistry = $moduleRegistry;
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
        $pluginRegistered = $this->moduleRegistry->isRegistered($moduleName);

        if ($pluginRegistered) {
            return 2;
        }
        return 1;
    }

    public function isRegistered($type, $moduleName) : bool
    {
        //check V2 first
        $pluginRegistered = $this->moduleRegistry->isRegistered($moduleName);

        if ($pluginRegistered) {
            return true;
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
        $pluginActive = $this->moduleRegistry->isActive($moduleName);

        if ($pluginActive) {
            return true;
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
