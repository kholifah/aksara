<?php

return [
    'name' => 'sample-frontend',
    'description' => 'Sample Frontend theme for Aksara',
    'dependencies'=> ['menu','post-type','user'],

    //Laravel service Providers defined in plugin
    'providers' => [
        'Frontend\\Sample\\Providers\\RouteServiceProvider',
    ],

    'type' => 'frontend',
];
