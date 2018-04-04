<?php

return [
  'name' => 'aksara-frontend',
  'title' => 'Basic Aksara Theme',
  'description' => 'Sample Theme',
  'dependencies'=> ['menu','post-type','user'],
  'type' => 'frontend',
  'providers' => [
      'Frontend\\Aksara\\Providers\\FrontendServiceProvider',
  ]
];

