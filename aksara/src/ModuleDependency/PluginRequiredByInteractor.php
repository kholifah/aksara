<?php
namespace Aksara\ModuleDependency;

use Aksara\ModuleKey;
use Aksara\Repository\ConfigRepository;
use Aksara\ModuleStatus\ModuleStatus;
use Aksara\ModuleRegistry\ModuleRegistryHandler;

class PluginRequiredByInteractor implements PluginRequiredBy
{
    private $configRepo;
    private $moduleStatus;
    private $moduleRegistry;

    public function __construct(
        ConfigRepository $configRepo,
        ModuleStatus $moduleStatus,
        ModuleRegistryHandler $moduleRegistry
    ){
        $this->configRepo = $configRepo;
        $this->moduleStatus = $moduleStatus;
        $this->moduleRegistry = $moduleRegistry;
    }

    public function isRequired(string $pluginName) : bool
    {
        $requiredBy = $this->getRequiredBy($pluginName);
        return count($requiredBy) > 0;
    }

    public function getRequiredBy(string $pluginName) : array
    {
        //get all modules from config aksara.modules
        $modulesV1 = $this->configRepo->get('aksara.modules');

        //loop through all which has dependency to this module
        $requiredBy = [];
        foreach ($modulesV1 as $moduleType => $moduleTypeItems) {
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

        $plugins = $this->moduleRegistry->getActiveModules();
        foreach ($plugins as $plugin) {
            if (!in_array($pluginName, $plugin->getDependencies())) {
                continue;
            }
            $requiredBy[] = new ModuleKey('plugin', $plugin->getName());
        }

        return $requiredBy;
    }
}
