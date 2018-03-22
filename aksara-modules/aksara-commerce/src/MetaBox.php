<?php
namespace Plugins\AksaraCommerce;

class MetaBox
{
    public function render($post)
    {
        echo view('aksara-commerce::metabox', compact('post'))->render();
    }

    public function save($post, $request)
    {
        $price = intval($request->input('aksara_commerce.price', 0));
        $stock = intval($request->input('aksara_commerce.stock', 0));

        set_post_meta($post->id, 'price', $price);
        set_post_meta($post->id, 'stock', $stock);
    }
}
