<?php
namespace Aksara\AssetRegistry;

use Aksara\Entities\Module;

//TODO
//convert facade to injection for better testability
class QueueInteractor implements AssetQueueInterface
{
    // $type = 'js' | 'css'
    // $location = 'admin' | front-end
    // $id
    // $priority
    // in footer
    public function enqueue($location, $type, $url, $id, $priority = 20, $footer=false)
    {
        if (!in_array($location, AssetLocation::allValues())) {
            return false;
        }

        if (!in_array($type, AssetType::allValues())) {
            return false;
        }

        if ($type == 'script' && $footer == true) {
            $location = $location.'-footer';
        }

        $config = \Config::get('aksara.assets', []);

        if (!isset($config[$location][$type][$priority])) {
            $config[$location][$type][$priority] = [];
        }

        array_push($config[$location][$type][$priority], $url);

        \Config::set('aksara.assets', $config);
    }

    public function enqueueModuleAsset(
        $location, $type, $module, $assetPath, $id = false, $priority = 20, $footer = false
    ){
        $nameArray = explode('/', $module);

        $path = '';

        switch (count($nameArray)) {
        case 1:
            $path = $this->getPathV2($nameArray);
            break;
        case 2:
            $path = $this->getPathV1($nameArray);
            break;
        default: throw new \Exception('Format type-name tidak valid,
                gunakan format tipe/nama-modul (v1) atau nama-modul (v2)');
        }

        $url = url($path.'/'.$assetPath);

        $this->enqueue($location, $type, $url, $id, $priority, $footer);
    }

    private function getPathV2($nameArray)
    {
        $moduleName = $nameArray[0];
        $publicAssetPath = 'assets/modules-v2/'.$moduleName;
        return $publicAssetPath;
    }

    private function getPathV1($nameArray)
    {
        $type = $nameArray[0];
        $moduleName = $nameArray[1];

        $modules = \Config::get('aksara.modules');

        if (!isset($modules[$type])) {
            throw new \Exception('Jenis module '
                . $type
                .' tidak ada, gunakan [core,plugin,admin,front-end]');
        }

        if (!isset($modules[$type][$moduleName])) {
            throw new \Exception('Module dengan nama '.$moduleName.' tidak ada');
        }

        $moduleCfg = $modules[$type][$moduleName];

        $module = Module::fromConfig($type, $moduleName, $moduleCfg);

        $moduleNamespace = aksara_unslugify($moduleName, true);

        switch ($module->getType()) {
        case Module::PLUGIN_TYPE:
            return 'assets/modules/Plugins/'.$moduleNamespace;
        case Module::FRONTEND_TYPE:
            return 'assets/modules/Frontend/'.$moduleNamespace;
        case Module::ADMIN_TYPE:
            return 'assets/modules/Admin/'.$moduleNamespace;
        case Module::CORE_TYPE:
            return 'assets/modules/Core/'.$moduleNamespace;
        default: throw new \Exception('Tipe modul '.$module->getType().' tidak terdaftar');
        }
    }


}

