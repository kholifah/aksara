<?php
namespace Aksara\AssetRegistry;

interface AssetQueueInterface
{
    public function enqueue(string $location, string $type, $url, $id, $priority = 20, $footer=false);
    public function enqueueModuleAsset(
        string $location, string $type, $module, $assetPath, $id = false, $priority = 20, $footer = false
    );
}
