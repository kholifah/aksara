<?php

return [
  'name' => 'aksara-multi-bas',
  'description' => 'Multi language support for Aksara Post Type',
  'dependencies'=> ['post-type'],

  'providers' => [
      'Plugins\\AksaraMultiBas\\Providers\\MultiBasActionFilterServiceProvider',
      'Plugins\\AksaraMultiBas\\Providers\\MultiBasServiceProvider',
  ],

  'aliases' => [
      'LocaleSwitcher' => 'Plugins\\AksaraMultiBas\\Facades\\LocaleSwitcherFacade',
      'LanguageSwitcher' => 'Plugins\\AksaraMultiBas\\Facades\\LanguageSwitcherFacade',
      'TranslationEngine' => 'Plugins\\AksaraMultiBas\\Facades\\TranslationEngineFacade',
  ],

  'type' => 'plugin',
];
