<?php

return [
    'name' => 'aksara-commerce',
    'description' => 'Sample E-Commerce for Aksara',
    'dependencies'=> ['post-type'],

    //Laravel service Providers defined in plugin
    'providers' => [
        'Plugins\\AksaraCommerce\\Providers\\RouteServiceProvider',
    ],

    //Laravel Facade aliases defined in plugin
    'aliases' => [

    ],

    'type' => 'plugin',
];
