<?php

return [
    'name' => 'user',
    'description' => 'User and Role manager for Aksara',

    //Laravel service Providers defined in plugin
    'providers' => [
        'Plugins\\User\\Providers\\RouteServiceProvider',
        'Plugins\\User\\Providers\\UserServiceProvider',
    ],

    //Laravel Facade aliases defined in plugin
    'aliases' => [
        'RoleCapability' => 'Plugins\\User\\Facades\\RoleCapabilityFacade',
    ],
];
