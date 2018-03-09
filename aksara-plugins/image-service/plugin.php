<?php

return [
    'name' => 'image-service',
    'description' => 'Plugin for serving image with optimization',
    'dependencies'=> [],

    //Laravel service Providers defined in plugin
    'providers' => [
        'Plugins\\ImageService\\Providers\\ImageServiceProvider',
    ],

    //Laravel Facade aliases defined in plugin
    'aliases' => [
        'ImageService' => 'Plugins\\ImageService\\Facades\\ImageService',
        'ImageConfig' => 'Plugins\\ImageService\\Facades\\ImageConfig',
    ],

    //helpers file
    'helpers' => [
        'helper.php',
    ],
];
