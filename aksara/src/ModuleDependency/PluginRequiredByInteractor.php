<?php
namespace Aksara\ModuleDependency;

use Aksara\ModuleKey;
use Aksara\Repository\ConfigRepository;
use Aksara\ModuleStatus\ModuleStatus;

class PluginRequiredByInteractor implements PluginRequiredBy
{
    private $configRepo;
    private $moduleStatus;

    public function __construct(
        ConfigRepository $configRepo,
        ModuleStatus $moduleStatus
    ){
        $this->configRepo = $configRepo;
        $this->moduleStatus = $moduleStatus;
    }

    public function isRequired(string $pluginName) : bool
    {
        $requiredBy = $this->getRequiredBy($pluginName);
        return count($requiredBy) > 0;
    }

    public function getRequiredBy(string $pluginName) : array
    {
        //get all modules from config aksara.modules
        $modules = $this->configRepo->get('aksara.modules');

        //loop through all which has dependency to this module
        $requiredBy = [];
        foreach ($modules as $moduleType => $moduleTypeItems) {
            foreach ($moduleTypeItems as $slug => $module) {
                if (!isset($module['dependencies'])) {
                    continue;
                }
                if (!in_array($pluginName, $module['dependencies'])) {
                    continue;
                }
                if (!$this->moduleStatus->isActive($moduleType, $slug)) {
                    continue;
                }
                $requiredBy[] = new ModuleKey($moduleType, $slug);
            }
        }
        return $requiredBy;
    }
}
