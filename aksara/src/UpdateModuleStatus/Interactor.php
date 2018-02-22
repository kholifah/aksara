<?php
namespace Aksara\UpdateModuleStatus;

use Aksara\ModuleIdentifier;
use Aksara\ModuleStatus\ModuleStatus;
use Aksara\Repository\OptionRepository;
use Aksara\AdminNotif\AdminNotifRequest;
use Aksara\AdminNotif\AdminNotifHandler;

class Interactor implements UpdateModuleStatusHandler
{
    private $moduleStatus;
    private $optionRepo;
    private $notifHandler;

    public function __construct(
        ModuleStatus $moduleStatus,
        OptionRepository $optionRepo,
        AdminNotifHandler $notifHandler
    ){
        $this->moduleStatus = $moduleStatus;
        $this->optionRepo = $optionRepo;
        $this->notifHandler = $notifHandler;
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

        $this->successNotify($key);

        return true;
    }

    private function successNotify(ModuleIdentifier $key, $active = true)
    {
        $notifRequest = new AdminNotifRequest(
            'success',
            $key->getType() .
                ' - ' . $key->getModuleName() .
                ' berhasil ' . ($active ? 'diaktifkan' : 'di non-aktifkan')
        );

        $this->notifHandler->handle($notifRequest);
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
        $this->successNotify($moduleId, false);

        return true;
    }

}

