<?php
namespace Aksara\UpdateModuleStatus;

use Aksara\ModuleIdentifier;
use Aksara\ModuleStatus\ModuleStatus;
use Aksara\Repository\OptionRepository;
use Aksara\Repository\SessionRepository;

class Interactor implements UpdateModuleStatusHandler
{
    private $moduleStatus;
    private $optionRepo;
    private $sessionRepo;

    public function __construct(
        ModuleStatus $moduleStatus,
        OptionRepository $optionRepo,
        SessionRepository $sessionRepo
    ){
        $this->moduleStatus = $moduleStatus;
        $this->optionRepo = $optionRepo;
        $this->sessionRepo = $sessionRepo;
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
        $notice = [
            'labelClass' => 'success',
            'content' => $key->getType() .
            ' - ' . $key->getModuleName() .
            ' berhasil ' . ($active ? 'diaktifkan' : 'di non-aktifkan')
        ];

        $this->flashNotify($notice);
    }

    //TODO refactor this to: admin_notifier
    private function flashNotify($notice)
    {
        if ($this->sessionRepo->has('admin_notice')) {
            $messages = $this->sessionRepo->get('admin_notice');
            array_push($messages, $notice);
            $this->sessionRepo->flash('admin_notice', $messages);
        } else {
            $this->sessionRepo->flash('admin_notice', [ $notice ]);
        }
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

