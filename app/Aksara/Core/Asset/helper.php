<?php

function aksara_enqueue_script($url, $id=false, $priority=20, $footer = false)
{
    \AssetQueue::enqueue('front-end', 'script', $url, $id, $priority, $footer);
}

function aksara_enqueue_style($url, $id =false, $priority=20)
{
    \AssetQueue::enqueue('front-end', 'style', $url, $id, $priority);
}

function aksara_admin_enqueue_script($url, $id=false, $priority=20, $footer = false)
{
    \AssetQueue::enqueue('admin', 'script', $url, $id, $priority, $footer);
}

function aksara_admin_enqueue_style($url, $id=false, $priority=20)
{
    \AssetQueue::enqueue('admin', 'style', $url, $priority);
}

function aksara_admin_enqueue_module_style($module, $assetPath, $id = false, $priority = 20)
{
    \AssetQueue::enqueueModuleAsset('admin', 'style', $module, $assetPath, $id, $priority);
}
