<?php

function aksara_enqueue_script($url, $id=false, $priority=20, $footer = false)
{
    \AssetQueue::frontend()
        ->script()
        ->url($url)
        ->id($id)
        ->priority($priority)
        ->footer($footer)
        ->enqueue();
}

function aksara_enqueue_style($url, $id =false, $priority=20)
{
    \AssetQueue::frontend()
        ->style()
        ->url($url)
        ->id($id)
        ->priority($priority)
        ->enqueue();
}

function aksara_admin_enqueue_script($url, $id=false, $priority=20, $footer = false)
{
    \AssetQueue::admin()
        ->script()
        ->url($url)
        ->id($id)
        ->priority($priority)
        ->footer($footer)
        ->enqueue();
}

function aksara_admin_enqueue_style($url, $id=false, $priority=20)
{
    \AssetQueue::admin()
        ->style()
        ->url($url)
        ->id($id)
        ->priority($priority)
        ->enqueue();
}

function aksara_enqueue_module_script($module, $assetPath, $id=false, $priority=20, $footer = false)
{
    \AssetQueue::frontend()
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
    \AssetQueue::frontend()
        ->style()
        ->module($module)
        ->assetPath($assetPath)
        ->id($id)
        ->priority($priority)
        ->enqueue();
}

function aksara_admin_enqueue_module_script($module, $assetPath, $id=false, $priority=20, $footer = false)
{
    \AssetQueue::admin()
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
    \AssetQueue::admin()
        ->style()
        ->module($module)
        ->assetPath($assetPath)
        ->id($id)
        ->priority($priority)
        ->enqueue();
}
