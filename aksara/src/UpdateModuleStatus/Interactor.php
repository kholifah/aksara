<?php
namespace Aksara\UpdateModuleStatus;

use Aksara\ModuleIdentifier;
use Aksara\ModuleStatus\ModuleStatus;
use Aksara\Repository\OptionRepository;

class Interactor implements UpdateModuleStatusHandler
{
    private $moduleStatus;
    private $optionRepo;

    public function __construct(
        ModuleStatus $moduleStatus,
        OptionRepository $optionRepo
    ){
        $this->moduleStatus = $moduleStatus;
        $this->optionRepo = $optionRepo;
    }

    public function activate(ModuleIdentifier $key)
    {
        $type = $key->getType();
        $moduleName = $key->getModuleName();

        if (!$this->moduleStatus->isRegistered($type, $moduleName)) {
            return false;
        }

        $activeModules = $this->optionRepo->getOptions(
            'aksara.modules.actives', []);

        if (!isset($activeModules[$type])) {
            $activeModules[$type] = [];
        }

        array_push($activeModules[$type], $moduleName);

        $this->optionRepo->setOptions('aksara.modules.actives', $activeModules);


        return true;
    }

    public function deactivate(ModuleIdentifier $moduleId)
    {
        $type = $moduleId->getType();
        $moduleName = $moduleId->getModuleName();

        $activeModules = $this->optionRepo->getOptions(
            'aksara.modules.actives', []);

        if (!isset($activeModules[$type])) {
            return;
        }

        if (in_array($moduleName, $activeModules[$type])) {
            $key = array_search($moduleName, $activeModules[$type]);
            unset($activeModules[$type][$key]);
        }

        $this->optionRepo->setOptions('aksara.modules.actives', $activeModules);

        return true;
    }

}

