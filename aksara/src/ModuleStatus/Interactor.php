<?php
namespace Aksara\ModuleStatus;

use Aksara\Repository\ConfigRepository;
use Aksara\Repository\OptionRepository;
use Aksara\ModuleStatusInfo;

class Interactor implements ModuleStatus
{
    private $configRepo;
    private $optionRepo;

    public function __construct(
        ConfigRepository $configRepo,
        OptionRepository $optionRepo
    ){
        $this->configRepo = $configRepo;
        $this->optionRepo = $optionRepo;
    }

    public function getStatus($type, $moduleName) : ModuleStatusInfo
    {
        $isActive = $this->isActive($type, $moduleName);
        $isRegistered = $this->isRegistered($type, $moduleName);

        return new ModuleStatusInfo(
            $type,
            $moduleName,
            $isActive,
            $isRegistered
        );
    }

    public function isRegistered($type, $moduleName) : bool
    {
        $registeredModules = $this->configRepo->get('aksara.modules', []);

        if (!isset($registeredModules[$type])) {
            return false;
        }

        return isset($registeredModules[$type][$moduleName]);
    }

    public function isActive($type, $moduleName) : bool
    {
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
