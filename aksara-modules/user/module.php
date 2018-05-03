<?php

return [
    'name' => 'user',
    'description' => 'User and Role manager for Aksara',

    //Laravel service Providers defined in plugin
    'providers' => [
        'Plugins\\User\\Providers\\RouteServiceProvider',
        'Plugins\\User\\Providers\\UserServiceProvider',
        'Plugins\\User\\Providers\\CapabilityServiceProvider',
    ],

    //Laravel Facade aliases defined in plugin
    'aliases' => [
        'RoleCapability' => 'Plugins\\User\\Facades\\RoleCapabilityFacade',
        'UserCapability' => 'Plugins\\User\\Facades\\UserCapabilityFacade',
    ],

    'type' => 'plugin',
];
