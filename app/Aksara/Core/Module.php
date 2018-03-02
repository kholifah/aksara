<?php
namespace App\Aksara\Core;

use Aksara\Exceptions\LoadModuleException;
use Aksara\ModuleKey;
use Aksara\ErrorLoadModule\ErrorLoadModuleHandler;

class Module
{
    const PLUGIN_FOLDER = 'aksara-plugins';

    // $type = front-end, plugin, admin,core
    public function loadModules($type, $path)
    {
        try {
            $modules = \File::directories($path);

            foreach ($modules as $modulePath) {
                $this->registerModule($type, $modulePath);
            }

            foreach ($modules as $modulePath) {
                // non active module don't need to be loaded
                $moduleName = $this->getModuleSlug($modulePath);

                if (!$this->getModuleStatus($type, $moduleName)) {
                    continue;
                }
                $this->loadModule($type, $moduleName);
            }

            //module successfully loaded, remove any init vars
            if (session()->has('activating_module')) {
                session()->forget('activating_module');
            }
            if (session()->has('deactivating_module')) {
                session()->forget('deactivating_module');
            }
        } catch (LoadModuleException $e) {
            $handler = app(ErrorLoadModuleHandler::class);
            $handler->handle($e);
            throw $e;
        }

    }

    // $type = front-end, plugin, cms
    public function loadModule($type, $moduleName)
    {
        try {
            $module =  \Config::get('aksara.modules.'.$type.'.'.$moduleName, false);

            if (!$module) {
                return false;
            }

            $moduleIndex = $module['modulePath'].'/index.php' ;
            $moduleHelper = $module['modulePath'].'/helper.php';
            $moduleRoutes = $module['modulePath'].'/routes.php';
            $viewFolder = $module['modulePath'].'/resources/views' ;
            $languageFolder = $module['modulePath'].'/resources/lang' ;
            $migrationFolder = $module['modulePath'].'/migrations' ;

            // Check if dependency not met
            $moduleDescription = \Config::get('aksara.modules', []);
            $moduleDescription = $moduleDescription[$type][$moduleName];
            // modules-> not found dependencies -> notice
            // - disable modules (plugin)
            // - force enable modules (front-end/admin)
            if ($type != 'core') {
                if (isset($moduleDescription['dependencies'])) {
                    // Create dependencies array
                    if (is_string($moduleDescription['dependencies'])) {
                        $dependencies[] = $moduleDescription['dependencies'];
                    } elseif (is_array($moduleDescription['dependencies'])) {
                        $dependencies = $moduleDescription['dependencies'];
                    } else {
                        $dependencies = [];
                    }

                    foreach ($dependencies as $dependency) {
                        if (!$this->getModuleStatus('plugin', $dependency)) {
                            if ($type == 'plugin') {
                                admin_notice('danger', 'Plugin '.$moduleDescription['name'].' di-nonaktifkan karena dependency '.$dependency.' tidak aktif.');
                                $this->deactivateModule($type, $moduleName);
                                return false;
                            } else {
                                $successActivate = $this->activateModule('plugin', $dependency);
                                $this->loadModule('plugin', $dependency);
                                if (!$successActivate) {
                                    admin_notice('danger', 'Plugin '.$dependency.' tidak ada dalam sistem.');
                                    return false;
                                } else {
                                    admin_notice('danger', 'Plugin '.$dependency.' diaktifkan karena merupakan dependency dari '.$moduleName);
                                }
                            }
                        }
                    }
                }
            }

            // register index
            if (file_exists($moduleIndex)) {

                if (file_exists($moduleHelper)) {
                    require_once($moduleHelper);
                }

                if (file_exists($moduleRoutes)) {
                    require_once($moduleRoutes);
                }

                // Register view namespace
                if (is_dir($viewFolder)) {
                    view()->addNamespace($type.':'.$moduleName, $viewFolder);
                }

                // Register language namesapce
                if (is_dir($languageFolder)) {
                    \Lang::addNamespace($type.':'.$moduleName, $languageFolder);
                }

                // register migration
                // @TODO Migration
                if (is_dir($migrationFolder)) {
                    app()->afterResolving('migrator', function ($migrator) use ($migrationFolder) {
                        $migrator->path($migrationFolder);
                    });
                }

                require_once($moduleIndex);

                return true;
            }

            return false;
        } catch (\Error $e) {
            throw new LoadModuleException(
                new ModuleKey(
                    $type,
                    $moduleName
                ));
        }
    }

    // @TODO module_activation seharusnya dihapus pada saat laravel berhasil clean shutdown, tapi karena tidak ada hook shutdown pada laravel maka caranya adalah dicek, jika counter sudah 2 dihapus
    public function moduleStatusChangeListener()
    {
        $moduleActivation = \get_options('module_activation', false);
        $moduleDeactivation = \get_options('module_deactivation', false);

        if (!$moduleActivation && !$moduleDeactivation) {
            return;
        }

        if (!$moduleActivation) {
            $moduleInQuestion = $moduleDeactivation;
            $type = 'deactive';
        } else {
            $moduleInQuestion = $moduleActivation;
            $type = 'activation';
        }

        $moduleInQuestion['counter']++ ;

        if ($type == 'activation') {
            set_options('module_activation', $moduleInQuestion);
        } else {
            set_options('module_deactivation', $moduleInQuestion);
        }


        if ($moduleInQuestion['counter'] >= 2) {
            $this->moduleStatusChangeListenerMessage($type, $moduleInQuestion);
            delete_options('module_activation');
            delete_options('module_deactivation');
        }
    }

    public function moduleStatusChangeListenerMessage($type, $moduleInQuestion)
    {
        if ($type == 'activation') {
            if ($this->getModuleStatus($moduleInQuestion['moduleType'], $moduleInQuestion['moduleName'])) {
                admin_notice('success', $moduleInQuestion['moduleType'].' - '.$moduleInQuestion['moduleName'].' berhasil diaktifkan.');
            } else {
                admin_notice('warning', $moduleInQuestion['moduleType'].' - '.$moduleInQuestion['moduleName'].' gagal diaktifkan karena terdapat error.');
            }
        } else {
            if ($this->getModuleStatus($moduleInQuestion['moduleType'], $moduleInQuestion['moduleName'])) {
                admin_notice('warning', $moduleInQuestion['moduleType'].' - '.$moduleInQuestion['moduleName'].' gagal di-nonaktifkan  karena terdapat error..');
            } else {
                admin_notice('success', $moduleInQuestion['moduleType'].' - '.$moduleInQuestion['moduleName'].' berhasil dinon-aktifkan');
            }
        }
    }
    // Deactive last activated plugin if causing error, only on activati
    public function moduleActivationErrorHandler($exception)
    {
        // $this->deactivateModule('plugin','post-type');
        $moduleActivation = \get_options('module_activation', false);
        $moduleDeactivation = \get_options('module_deactivation', false);

        if ($moduleDeactivation) {
            $this->activateModule($moduleDeactivation['moduleType'], $moduleDeactivation['moduleName']);
            $this->moduleStatusChangeListenerMessage('deactive', $moduleDeactivation);
            delete_options('module_deactivation');
        } elseif ($moduleActivation) {
            if (\App::runningInConsole() || isset($_GET['deactive'])) {
                $this->deactivateModule($moduleActivation['moduleType'], $moduleActivation['moduleName']);
                $this->moduleStatusChangeListenerMessage('activation', $moduleActivation);
                delete_options('module_activation');

                if (\App::runningInConsole()) {
                    echo 'Modul '.$moduleActivation['moduleName'].' dinon-aktifkan karena terjadi terjadi kesalahan.';
                    return;
                }

                header('Location: '.url('admin/aksara-module-manager'));
                die();
            }

            // On special an database exception
            if ($moduleActivation['counter'] <= 2 && $exception instanceof \Illuminate\Database\QueryException) {
                $moduleActivation['counter'] = 0;


                set_options('module_activation', $moduleActivation);
                // set_options('module_activation', $moduleActivation);
                $text =  '<p>Modul gagal diaktifkan karena terjadi eksepsi database, coba non aktifkan modul ini dan jalankan migrasi :</p>';
                $text .=  '<pre>php artisan aksara:migrate plugin'.$moduleActivation['moduleName'].'</pre>';
                $text .=  '<a href="?deactive=true">Non aktifkan plugin '.$moduleActivation['moduleName'].'.</a>';
                $text .=  '<pre>'.$exception.'</pre>';

                // @TODO move to view
                echo $text;
                die();
            }
        }
    }

    // activate module
    public function activateModule($type, $moduleName)
    {
        if (!$this->isModuleRegistered($type, $moduleName)) {
            return false;
        }

        $activeModules = \get_options('aksara.modules.actives', []);

        if (!isset($activeModules[$type])) {
            $activeModules[$type] = [];
        }

        array_push($activeModules[$type], $moduleName);

        \set_options('aksara.modules.actives', $activeModules);

        return true;
    }

    // deactive module
    public function deactivateModule($type, $moduleName)
    {
        $activeModules = \get_options('aksara.modules.actives', []);

        if (!isset($activeModules[$type])) {
            return;
        }

        if (in_array($moduleName, $activeModules[$type])) {
            $key = array_search($moduleName, $activeModules[$type]);
            unset($activeModules[$type][$key]);
        }

        \set_options('aksara.modules.actives', $activeModules);

        return true;
    }

    // cek module status (activated or not)
    public function getModuleStatus($type, $moduleName)
    {
        // @TODO if front-end / admin should check first
        if ( $type =='admin' || $type == 'core') {
            return true;
        }

        if (\Config::get('aksara.module_manager.load_all', false)) {
            return true;
        }

        // get module status from databases
        $activeModules = \get_options('aksara.modules.actives', []);

        if (!isset($activeModules[$type])) {
            return false;
        }

        if (in_array($moduleName, $activeModules[$type])) {
            return true;
        }

        return false;
    }

    // convert name into slug
    public function getModuleSlug($module)
    {
        return \aksara_slugify($module);
    }

    public function isModuleRegistered($type, $moduleName)
    {
        $registeredModules = \Config::get('aksara.modules', []);


        if (!isset($registeredModules[$type])) {
            return false;
        }

        return isset($registeredModules[$type][$moduleName]);
    }

    // Register module into config
    public function registerModule($type, $modulePath)
    {
        $registeredModules = \Config::get('aksara.modules', []);

        if (!isset($registeredModules[$type])) {
            $registeredModules[$type] = [];
        }

        $moduleDescription = $modulePath.'/description.php' ;

        //TODO need refactor here
        //if path contains aksara-plugins
        if (strpos($modulePath, self::PLUGIN_FOLDER) !== false) {
            //use [plugin-name] from aksara-plugins/[plugin-name]
            $pos = strpos($modulePath, self::PLUGIN_FOLDER) + strlen(self::PLUGIN_FOLDER);
            $moduleName = explode('/', substr($modulePath, $pos))[1];
        } else {
            $moduleName =  $this->getModuleSlug($modulePath);
        }

        if (file_exists($moduleDescription)) {
            $registeredModules[$type][$moduleName] =  require $moduleDescription;
        } else {
            $registeredModules[$type][$moduleName] =  [];
        }

        if (!isset($registeredModules[$type][$moduleName]['name'])) {
            $registeredModules[$type][$moduleName]['name'] = $moduleName;
        }

        if (!isset($registeredModules[$type][$moduleName]['description'])) {
            $registeredModules[$type][$moduleName]['description'] = "";
        }

        if (!isset($registeredModules[$type][$moduleName]['dependencies'])) {
            $registeredModules[$type][$moduleName]['dependencies'] = [];
        }

        if (is_string($registeredModules[$type][$moduleName]['dependencies'])) {
            $registeredModules[$type][$moduleName]['dependencies'] = [$registeredModules[$type][$moduleName]['dependencies']];
        }

        $registeredModules[$type][$moduleName]['modulePath'] = $modulePath;

        //use config in description.php to determine migrationPath
        if (!isset($registeredModules[$type][$moduleName]['migrationPath'])) {
            //if not configured, use default in subdir /migrations
            $migrationFolder = $modulePath.'/migrations' ;
            if (is_dir($migrationFolder)) {
                $registeredModules[$type][$moduleName]['migrationPath'] =
                    $migrationFolder;
            }
        }

        \Config::set('aksara.modules', $registeredModules);
    }

    public function initActivation($slug,$type='plugin')
    {
        \set_options('module_activation', [
            'moduleType' => $type,
            'moduleName' => $slug,
            'counter' => 0
        ]);

        //@todo
        $this->activateModule($type, $slug);
    }

    public function initDeactivation($slug,$type='plugin')
    {
        \set_options('module_deactivation', [
            'moduleType' => $type,
            'moduleName' => $slug,
            'counter' => 0
        ]);

        //@todo
        $this->deactivateModule($type, $slug);
    }
}
