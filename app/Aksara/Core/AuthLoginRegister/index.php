<?php

\Eventy::addAction('aksara.init-after-routes',function(){

    $args = [
        'position' => 99,
        'menuTitle' => __('core:auth-login-register::default.logout'),
        'capability' =>[],
        'url' => route('admin.logout')
    ];

    add_admin_menu_toolbar_dropdown($args);
},20);
