<?php

return [
  'name' => 'post-type',
  'description' => 'WordPress like Post Type manager for Aksara',
  'dependencies'=> ['user', 'image-service', ],

  'providers' => [
      'Plugins\\PostType\\Providers\\ActionFilterServiceProvider',
      'Plugins\\PostType\\Providers\\PostTypeServiceProvider',
  ]
];
