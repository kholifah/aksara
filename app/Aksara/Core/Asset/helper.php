<?php

function aksara_enqueue_script($url, $id=false, $priority=20, $footer = false)
{
    \AssetQueueFactory::frontend()
        ->script()
        ->url($url)
        ->id($id)
        ->priority($priority)
        ->footer($footer)
        ->enqueue();
}

function aksara_enqueue_style($url, $id =false, $priority=20)
{
    \AssetQueueFactory::frontend()
        ->style()
        ->url($url)
        ->id($id)
        ->priority($priority)
        ->enqueue();
}

function aksara_admin_enqueue_script($url, $id=false, $priority=20, $footer = false)
{
    \AssetQueueFactory::admin()
        ->script()
        ->url($url)
        ->id($id)
        ->priority($priority)
        ->footer($footer)
        ->enqueue();
}

function aksara_admin_enqueue_style($url, $id=false, $priority=20)
{
    \AssetQueueFactory::admin()
        ->style()
        ->url($url)
        ->id($id)
        ->priority($priority)
        ->enqueue();
}

function aksara_enqueue_module_script($module, $assetPath, $id=false, $priority=20, $footer = false)
{
    \AssetQueueFactory::frontend()
        ->script()
        ->module($module)
        ->assetPath($assetPath)
        ->id($id)
        ->priority($priority)
        ->footer($footer)
        ->enqueue();
}

function aksara_enqueue_module_style($module, $assetPath, $url, $id =false, $priority=20)
{
    \AssetQueueFactory::frontend()
        ->style()
        ->module($module)
        ->assetPath($assetPath)
        ->id($id)
        ->priority($priority)
        ->enqueue();
}

function aksara_admin_enqueue_module_script($module, $assetPath, $id=false, $priority=20, $footer = false)
{
    \AssetQueueFactory::admin()
        ->script()
        ->module($module)
        ->assetPath($assetPath)
        ->id($id)
        ->priority($priority)
        ->footer($footer)
        ->enqueue();
}


function aksara_admin_enqueue_module_style($module, $assetPath, $id = false, $priority = 20)
{
    \AssetQueueFactory::admin()
        ->style()
        ->module($module)
        ->assetPath($assetPath)
        ->id($id)
        ->priority($priority)
        ->enqueue();
}
