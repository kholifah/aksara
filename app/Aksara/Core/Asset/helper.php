<?php

function aksara_enqueue_script($url,$priority=10)
{
  $asset = \App::make('enqueue');
  $asset->enqueue('front-end','script',$url,$priority);
}

function aksara_enqueue_style($url,$priority=10)
{
  $asset = \App::make('enqueue');
  $asset->enqueue('front-end','style',$url,$priority);
}

function aksara_admin_enqueue_script($url,$priority=10)
{
  $asset = \App::make('enqueue');
  $asset->enqueue('admin','script',$url,$priority);
}

function aksara_admin_enqueue_style($url,$priority=10)
{
  $asset = \App::make('enqueue');
  $asset->enqueue('admin','style',$url,$priority);
}
