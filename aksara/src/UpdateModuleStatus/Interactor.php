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

        $this->notify($key);

        return true;
    }

    //TODO refactor this to: admin_notifier
    //TODO rapikan fungsi
    private function notify(ModuleIdentifier $key, $active = true)
    {
        if ($this->sessionRepo->has('admin_notice')) {
            $this->sessionRepo->push('admin_notice', [
                'labelClass' => 'success',
                'content' => $key->getType() .
                ' - ' . $key->getModuleName() .
                ' berhasil ' . ($active ? 'diaktifkan' : 'di non-aktifkan')
            ]);
        } else {
            $this->sessionRepo->flash('admin_notice', [[
                'labelClass' => 'success',
                'content' => $key->getType() .
                ' - ' . $key->getModuleName() .
                ' berhasil ' . ($active ? 'diaktifkan' : 'di non-aktifkan')
            ]]);
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
        $this->notify($moduleId, false);

        return true;
    }

}

