<?php

// Test Filter
//
// Eventy::addFilter('aksara.route.login',function($route){
//   return 'login/rahasia/kaltara';
// });
//
// Eventy::addFilter('aksara.route.register',function($route){
//   return 'rahasia-register';
// });
// Register Post
// $argsPost = [
//   'label' => [
//     'name' => 'Galllery'
//   ],
//   'route' => 'gallery',
//   'icon' => 'ti-gallery'
// ];

// register_post_type('gallery',$argsPost);

//\Eventy::addAction('aksara.notif' , function ( $notif )
//{
//    admin_notice('danger', $notif);
//});
// \Config::set('aksara.module_manager.load_all',true);

\Eventy::addAction('aksara.init', function () {
    register_menu(
      ['primary' => [
                    'label' => 'Primary'
                    ]]
                  );

    register_menu(
      ['footer' => [
                    'label' => 'Footer'
                  ]]
                );

    register_menu(
      ['top' => [
                    'label' => 'Top'
                  ]]
                );
    aksara_admin_enqueue_script(url('assets/modules/Admin/Aksara/js/script.min.js'),'aksara-admin',10,true);
});

//@TODO Enqueue semua script dan css admin side kesini

/**
  * Header
  * 1. script utama admin
  * 2. JS Jquery
  * Footer
  * 2. script utama admin
  */
