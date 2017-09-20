<?php
namespace App\Aksara\Core;

class Module
{
  // $type = front-end, plugin, admin,core
  function loadModules($type, $path )
  {
    $modules = \File::directories($path);

    foreach ( $modules as $modulePath )
    {
      $this->registerModule( $type, $modulePath );
    }

    foreach ( $modules as $modulePath )
    {
      // non active module don't need to be loaded
      $moduleName = $this->getModuleSlug($modulePath);

      if( !$this->getModuleStatus( $type, $moduleName ) )
        continue;

      $this->loadModule( $type, $moduleName );

    }
  }

  // $type = front-end, plugin, cms
  function loadModule( $type, $moduleName )
  {
    $module =  \Config::get('aksara.modules.'.$type.'.'.$moduleName, false );

    if( !$module )
      return false;

    $moduleIndex = $module['modulePath'].'/index.php' ;
    $moduleHelper = $module['modulePath'].'/helper.php';
    $moduleRoutes = $module['modulePath'].'/routes.php';
    $viewFolder = $module['modulePath'].'/resources/views' ;
    $migrationFolder = $module['modulePath'].'/migrations' ;



    // Check if dependency not met
    $moduleDescription = \Config::get('aksara.modules',[]);
    $moduleDescription = $moduleDescription[$type][$moduleName];
    // modules-> not found dependencies -> notice
    // - disable modules (plugin)
    // - force enable modules (front-end/admin)
    if( $type != 'core' )
    {
      if( isset($moduleDescription['dependencies']) )
      {
        // Create dependencies array
        if( is_string($moduleDescription['dependencies']) )
          $dependencies[] = $moduleDescription['dependencies'];
        elseif( is_array($moduleDescription['dependencies']) )
          $dependencies = $moduleDescription['dependencies'];
        else
          $dependencies = [];

        foreach ($dependencies as $dependency)
        {
          if( !$this->getModuleStatus('plugin',$dependency) )
          {
            if( $type == 'plugin' )
            {
              admin_notice('danger','Plugin '.$moduleDescription['name'].' di-nonaktifkan karena dependency '.$dependency.' tidak aktif.');
              $this->deactivateModule( $type, $moduleName );
              return false;
            }
            else
            {
              $successActivate = $this->activateModule( 'plugin', $dependency);

              if( !$successActivate ) {
                admin_notice('danger','Plugin '.$dependency.' tidak ada dalam sistem.');
                return false;
              }
              else
              {
                admin_notice('danger','Plugin '.$dependency.' diaktifkan karena merupakan dependency dari '.$moduleName);
              }
            }
          }
        }
      }
    }

    // register index
    if( file_exists( $moduleIndex ) )
    {

      require_once( $moduleIndex );

      if( file_exists($moduleHelper) )
        require_once( $moduleHelper );

      if( file_exists($moduleRoutes) )
        require_once( $moduleRoutes );

      // register view
      if( is_dir( $viewFolder ) )
      {
        // let's add /app/custom_views via namespace
        view()->addNamespace($type.':'.$moduleName, $viewFolder);
        // then:
        // view('my_views::some.view.name') // /app/custom_views/some/view/name.blade.php
      }

      // register migration
      // @TODO Migration
      if( is_dir($migrationFolder) )
      {
        app()->afterResolving('migrator', function ($migrator) use ($migrationFolder) {
          $migrator->path($migrationFolder);
        });
      }

      return true;
    }

    return false;
  }

  function moduleActivationMessage($activatedModule)
  {
      if( $this->getModuleStatus($activatedModule['moduleType'],$activatedModule['moduleName']) )
          admin_notice('success',$activatedModule['moduleType'].' - '.$activatedModule['moduleName'].' berhasil diaktifkan.');
      else
          admin_notice('warning',$activatedModule['moduleType'].' - '.$activatedModule['moduleName'].' gagal diaktifkan karena terdapat error.');
  }
  // Deactive last activated plugin if causing error
  function moduleActivationErrorHandler()
  {
    // $this->deactivateModule('plugin','post-type');
    // from ModuleManagerController
    $activatedModule = \get_options('module_activation',false);
    if( $activatedModule )
    {
        $this->deactivateModule($activatedModule['moduleType'],$activatedModule['moduleName']);
        $this->moduleActivationMessage($activatedModule);
        \delete_options('module_activation');
    }
  }

  // activate module
  function activateModule( $type, $moduleName )
  {
    if( !$this->isModuleRegistered($type,$moduleName) )
      return false;

    $activeModules = \get_options('aksara.modules.actives',[]);

    if( !isset( $activeModules[$type] ) )
      $activeModules[$type] = [];

    array_push( $activeModules[$type], $moduleName );

    \set_options('aksara.modules.actives', $activeModules );

    return true;
  }

  // deactive module
  function deactivateModule( $type, $moduleName )
  {
    $activeModules = \get_options('aksara.modules.actives',[]);

    if( !isset( $activeModules[$type] ) )
      return;

    if( in_array($moduleName, $activeModules[$type]) )
    {
       $key = array_search( $moduleName, $activeModules[$type] );
       unset($activeModules[$type][$key]);
    }

    \set_options('aksara.modules.actives', $activeModules );

    return true;
  }

  // cek module status (activated or not)
  function getModuleStatus( $type, $moduleName )
  {
    // @TODO if front-end / admin should check first
    if( $type == 'front-end' || $type =='admin' || $type == 'core' )
      return true;

    if( \Config::get('aksara.module_manager.load_all',false ) )
    {
      return true;
    }

    // get module status from databases
    $activeModules = \get_options('aksara.modules.actives',[]);

    if( !isset( $activeModules[$type] ) )
      return false;

    if( in_array($moduleName, $activeModules[$type]) )
      return true;

    return false;
  }

  // convert name into slug
  function getModuleSlug( $module )
  {
    return \aksara_slugify($module);
  }

  function isModuleRegistered( $type,$moduleName )
  {
    $registeredModules = \Config::get('aksara.modules', [] );


    if( !isset($registeredModules[$type]) )
      return false;

    return isset($registeredModules[$type][$moduleName]);

  }

  // Register module into config
  function registerModule( $type, $modulePath )
  {
    $registeredModules = \Config::get('aksara.modules', [] );

    if( !isset($registeredModules[$type]))
      $registeredModules[$type] = [];

    $moduleDescription = $modulePath.'/description.php' ;
    $moduleName =  $this->getModuleSlug($modulePath);

    if( file_exists($moduleDescription) )
      $registeredModules[$type][$moduleName] =  require $moduleDescription;
    else
      $registeredModules[$type][$moduleName] =  [];

    if( !isset( $registeredModules[$type][$moduleName]['name'] ) )
      $registeredModules[$type][$moduleName]['name'] = $moduleName;

    if( !isset( $registeredModules[$type][$moduleName]['description'] ) )
      $registeredModules[$type][$moduleName]['description'] = "";

    if( !isset( $registeredModules[$type][$moduleName]['dependencies'] ) )
      $registeredModules[$type][$moduleName]['dependencies'] = [];

    if( is_string( $registeredModules[$type][$moduleName]['dependencies'] ) )
      $registeredModules[$type][$moduleName]['dependencies'] = [$registeredModules[$type][$moduleName]['dependencies']];

    $registeredModules[$type][$moduleName]['modulePath'] = $modulePath;


    \Config::set('aksara.modules', $registeredModules );
  }

  function initActivation($slug)
  {
    \set_options('module_activation', [
        'moduleType' => 'plugin',
        'moduleName' => $slug,
        'counter' => 0
    ]);

    //@todo
    $this->activateModule('plugin', $slug);
  }

  // @TODO module_activation seharusnya dihapus pada saat laravel berhasil clean shutdown, tapi karena tidak ada hook shutdown pada laravel maka caranya adalah dicek, jika counter sudah 2 dihapus
  function incrementActivationCounter()
  {
    $moduleActivation = \get_options('module_activation', false );

    if( !$moduleActivation )
      return;

    $moduleActivation['counter'] = $moduleActivation['counter'] + 1;

    if( $moduleActivation['counter'] == 2 )
      delete_options('module_activation');
    else
      set_options('module_activation',$moduleActivation);
  }
}
