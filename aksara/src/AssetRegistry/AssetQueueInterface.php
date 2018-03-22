<?php
namespace Aksara\AssetRegistry;

interface AssetQueueInterface
{
    public function enqueue($location, $type, $url, $id, $priority = 20, $footer=false);
    public function enqueueModuleAsset(
        $location, $type, $module, $assetPath, $id = false, $priority = 20, $footer = false
    );
}
