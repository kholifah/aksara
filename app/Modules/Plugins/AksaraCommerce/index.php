<?php
\Eventy::addAction('aksara.init', function () {
    // Register Product
    $argsPost = [
    'label' => [
      'name' => 'Product'
    ],
    'route' => 'product',
    'icon' => 'ti-shopping-cart'
  ];

    register_post_type('product', $argsPost);

    $argsCategory = [
        'label' => [
          'name' => 'Category Product'
        ],
      ];

    register_taxonomy('product-category', ['product'], $argsCategory);

    add_post_type_to_taxonomy('category', 'product');
});

\Eventy::addAction('aksara.init', function () {

  // $metabox = \App::make('metabox');
    // bisa juga pake kelas kalau mau
    add_meta_box('e-commerce-metabox', 'product', 'App\Modules\Plugins\AksaraCommerce\MetaBox@render', 'App\Modules\Plugins\AksaraCommerce\MetaBox@save');
});
