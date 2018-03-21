<?php
namespace Aksara\AssetRegistry;

//TODO
//convert facade to injection for better testability
class QueueInteractor implements AssetQueueInterface
{
    protected $location = ['admin','front-end','admin-footer','front-end-footer'];
    protected $type = ['script','style'];

    public function __construct()
    {
    }

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

    public function enqueueV2($module, $assetPath, $id = false, $priority = 20)
    {
    }
}

