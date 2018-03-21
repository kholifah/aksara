<?php
namespace Aksara\AssetRegistry;

interface AssetQueueInterface
{
    public function enqueue($location, $type, $url, $id, $priority = 20, $footer=false);
    public function enqueueV2($module, $assetPath, $id = false, $priority = 20);
}
