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

\Eventy::addAction('aksara.init',function()
{
  register_menu( ['primary' => [
                    'label' => 'Primary'
                    ]]
                  );

  register_menu( ['footer' => [
                    'label' => 'Footer'
                  ]]
                );

});


add_page_template('Contact Form','front-end:aksara::page-contact-form');
add_page_template('About Us','front-end:aksara::page-about-us');
