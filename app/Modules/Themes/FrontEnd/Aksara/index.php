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
    // register_image_size('thumbnail',500,500,true);
    // register_image_size('thumbnail-2',600,600,false);
    // register_image_size('large',1200,900,true);
    // register_image_size('mashead',0,900,true);
    register_image_size('masthead',0,500);

    // Enqueue Style
    aksara_enqueue_style(url("assets/modules/FrontEnd/Aksara/vendor/bootstrap/css/bootstrap.min.css"));
    aksara_enqueue_style(url("assets/modules/FrontEnd/Aksara/vendor/font-awesome/css/font-awesome.min.css"));
    aksara_enqueue_style('https://fonts.googleapis.com/css?family=Lora:400,700,400italic,700italic');
    aksara_enqueue_style('https://fonts.googleapis.com/css?family=Open+Sans:300italic,400italic,600italic,700italic,800italic,400,300,600,700,800');
    aksara_enqueue_style(url("assets/modules/FrontEnd/Aksara/css/clean-blog.css"));

    // Enqueue Script
    aksara_enqueue_script(url("assets/modules/FrontEnd/Aksara/vendor/jquery/jquery.min.js"));
    aksara_enqueue_script(url("assets/modules/FrontEnd/Aksara/vendor/popper/popper.min.js"));
    aksara_enqueue_script(url("assets/modules/FrontEnd/Aksara/vendor/bootstrap/js/bootstrap.min.js"));
    aksara_enqueue_script(url("assets/modules/FrontEnd/Aksara/js/clean-blog.min.js"));

    add_page_template('Contact Form', 'front-end:aksara::page-contact-form');
    add_page_template('About Us', 'front-end:aksara::page-about-us');
});
