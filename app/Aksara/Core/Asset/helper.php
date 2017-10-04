<?php

function aksara_enqueue_script($url, $id=false, $priority=20, $footer = false)
{
    $asset = \App::make('enqueue');
    $asset->enqueue('front-end', 'script', $url, $id, $priority, $footer);
}

function aksara_enqueue_style($url, $id =false, $priority=20)
{
    $asset = \App::make('enqueue');
    $asset->enqueue('front-end', 'style', $url, $id, $priority);
}

function aksara_admin_enqueue_script($url, $id=false, $priority=20, $footer = false)
{
    $asset = \App::make('enqueue');
    $asset->enqueue('admin', 'script', $url, $id, $priority, $footer);
}

function aksara_admin_enqueue_style($url, $id=false, $priority=20)
{
    $asset = \App::make('enqueue');
    $asset->enqueue('admin', 'style', $url, $priority);
}
