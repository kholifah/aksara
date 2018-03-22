<?php
include "admin_helper.php";
include "option_helper.php";

function get_calback($callback)
{
    if (is_string($callback) && strpos($callback, '@'))
    {
        $callback = explode('@', $callback);

        if( !class_exists($callback[0]) )
            throw new Exception($callback[0].'@'.$callback[1].' is not a Callable', 1);

        return array(app( $callback[0]), $callback[1]);
    }
    else if (is_callable($callback))
    {
        return $callback;
    }
    else
    {
        throw new Exception($callback.' is not a Callable', 1);
    }
}

function aksara_slugify($name)
{
    return \Strings::slug($name);
}

function aksara_unslugify($string, $capitalizeFirstCharacter = false)
{
    return \Strings::slugToCamel($string, $capitalizeFirstCharacter);
}

function slug_to_title($string, $capitalizeFirstCharacter = false)
{
    return \Strings::slugToTitle($string, $capitalizeFirstCharacter);
}

// @todo segment ada cms berarti admin
function is_admin()
{
    $segments = \Request::segments();

    if( count($segments) != 0 && $segments[0] == 'admin' ) {
        return true;
    }

    return false;
}

function insert_after_array_key( &$array, $needle, $value = [])
{
    \Arrays::insertAfterKey($array, $needle, $value);
}

// search value for given key
function array_search_value_recursive($needle, $haystack, $returnObject = true)
{
    return \Arrays::searchValueRecursive($needle, $haystack, $returnObject);
}

// search key for given value
function array_search_key_recursive($needle, $haystack, $returnObject = true)
{
    return \Arrays::searchKeyRecursive($needle, $haystack, $returnObject);
}

function array_delete_recursive(array $array, callable $callback)
{
    return \Arrays::deleteRecursive($array, $callback);
}

function get_country_code()
{
    $countries = file_get_contents(app_path().'/Aksara/Lib/locale_lang_flag.json');
    return collect(json_decode($countries,true));
}

if (!function_exists('migration_path_v2')) {
    /**
     * Get all path to migrations V2
     *
     * @return array
     */
    function migration_path_v2($type = '', $moduleName = '')
    {
        $dirs = [];
        if (!empty($type) && !empty($moduleName)) {
            if (strtolower($type) == 'plugin') {
                //plugin v2
                $path = ModuleRegistry::getModulePath($moduleName);
                if (is_dir($path->migration())) {
                    $dirs[] = $path->migration();
                }
            }
            return $dirs;
        }

        $dirs[] = migration_path_core();

        if (empty($type) || strtolower($type) == 'plugin') {
            $plugins = ModuleRegistry::getRegisteredModules();

            foreach ($plugins as $plugin) {
                $path = ModuleRegistry::getModulePath($plugin->getName());
                if (is_dir($path->migration())) {
                    $dirs[] = $path->migration();
                }
            }
        }

        return $dirs;
    }
}

if (!function_exists('migration_path_core')) {
    /**
     * Get all path to migrations
     *
     * @return array
     */
    function migration_path_core()
    {
        return app()->databasePath().DIRECTORY_SEPARATOR.'migrations';
    }
}

if (!function_exists('migration_path_v1')) {
    /**
     * Get all path to migrations V1
     *
     * @return array
     */
    function migration_path_v1($type = '', $moduleName = '')
    {
        $moduleTypes = config('aksara.modules');
        $dirs = [];
        if (!empty($type) && !empty($moduleName)) {
            if (isset($moduleTypes[$type][$moduleName])) {
                $module = $moduleTypes[$type][$moduleName];
                if (isset($module['migrationPath'])) {
                    $dirs[] = $module['migrationPath'];
                }
            }
            return $dirs;
        }

        $dirs[] = migration_path_core();

        foreach ($moduleTypes as $typeItems) {
            foreach ($typeItems as $module) {
                if (isset($module['migrationPath'])) {
                    $dirs[] = $module['migrationPath'];
                }
            }
        }
        return $dirs;
    }
}

if (!function_exists('migration_path')) {
    /**
     * Get all path to migrations
     *
     * @return array
     */
    function migration_path($type = '', $moduleName = '')
    {
        $v1 = migration_path_v1($type, $moduleName);
        $v2 = migration_path_v2($type, $moduleName);
        $all = array_unique(array_merge($v1, $v2));
        return $all;
    }
}

if (!function_exists('migration_files')) {
    /**
     * Get all migrations files in configured paths
     *
     * @param  string  $path
     * @return string
     */
    function migration_files($dirs)
    {
        $migrator = app('migrator');
        $files = $migrator->getMigrationFiles($dirs);
        return $files;
    }
}

if (!function_exists('migration_ran')) {

    /**
     * Get migration already ran
     *
     * @return array
     */
    function migration_ran()
    {
        $migrator = app('migrator');
        $ran = $migrator->getRepository()->getRan();
        return $ran;
    }
}

if (!function_exists('migration_names')) {
    /**
     * Get migration names
     *
     * @param string $type
     * @param string $moduleName
     * @return Collection
     */
    function migration_names($type = '', $moduleName = '')
    {
        $paths = migration_path($type, $moduleName);
        $files = migration_files($paths);

        $migrator = app('migrator');
        $collection = collect($files);

        $migrationNames = $collection->map(function ($migration) use ($migrator) {
            $migrationName = $migrator->getMigrationName($migration);
            return $migrationName;
        });
        return $migrationNames->values();
    }
}

if (!function_exists('migration_complete')) {

    /**
     * Check migration status of module
     *
     * @param string $type
     * @param string $moduleName
     * @return bool
     */
    function migration_complete($type = '', $moduleName = '')
    {
        $ran = migration_ran();
        $migrationNames = migration_names($type, $moduleName);

        foreach ($migrationNames as $migrationName) {
            if (!in_array($migrationName, $ran)) {
                return false;
            }
        }

        return true;
    }
}

if (!function_exists('migration_pending')) {

    /**
     * Get list of pending migrations
     *
     * @param string $type
     * @param string $moduleName
     * @return array
     */
    function migration_pending($type = '', $moduleName = '')
    {
        $ran = migration_ran();
        $migrationNames = migration_names($type, $moduleName);

        $pendings = [];
        foreach ($migrationNames as $migrationName) {
            if (!in_array($migrationName, $ran)) {
                $pendings[] = $migrationName;
            }
        }

        return $pendings;
    }
}

