<?php

return [
    'name' => 'aksara',
    'description' => 'Frontend theme for Aksara',
    'dependencies'=> ['menu','post-type','user'],

    //Laravel service Providers defined in plugin
    'providers' => [
        'Plugins\\Aksara\\Providers\\RouteServiceProvider',
    ],

    //Laravel Facade aliases defined in plugin
    'aliases' => [
        
    ],

    'type' => 'front-end',
];
