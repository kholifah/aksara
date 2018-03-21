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

//TODO
//create v2 function of above function, that parameter should not be url, instead:
//module type/name
//asset path/relative from assets folder in module: eg: css/flag-icon.min.css
function aksara_admin_enqueue_style_v2($module, $assetPath, $id = false, $priority = 20)
{
}
