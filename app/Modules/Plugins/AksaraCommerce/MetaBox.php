<?php
namespace App\Modules\Plugins\AksaraCommerce;

class MetaBox
{
  function render($post)
  {
    echo view('plugin:aksara-commerce::metabox',compact('post'))->render();
  }

  function save($post,$request)
  {


    $price = intval($request->input('aksara_commerce.price',0));
    $stock = intval($request->input('aksara_commerce.stock',0));

    set_post_meta($post->id,'price',$price);
    set_post_meta($post->id,'stock',$stock);

  }
}
