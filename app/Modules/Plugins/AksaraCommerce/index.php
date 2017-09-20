<?php
\Eventy::addAction('aksara.init_completed', function(){
  // Register Product
  $argsPost = [
    'label' => [
      'name' => 'Product'
    ],
    'route' => 'product',
    'icon' => 'ti-shopping-cart'
  ];

  register_post_type('product',$argsPost);

  $argsCategory = [
        'label' => [
          'name' => 'Category'
        ],
      ];

  register_taxonomy('product-category', ['product'], $argsCategory);

});

\Eventy::addAction('aksara.init_completed', function(){

  // $metabox = \App::make('metabox');
  // bisa juga pake kelas kalau mau
  add_meta_box('e-commerce-metabox','product','App\Modules\Plugins\AksaraCommerce\MetaBox@render','App\Modules\Plugins\AksaraCommerce\MetaBox@save');


});
