<?php
namespace App\Aksara\Core\ModuleManager\Console\Commands;

use App\User;
use App\DripEmailer;
use Illuminate\Console\Command;
use Illuminate\Config\Repository as Config;
use Illuminate\FileSystem\FileSystem;
use Aksara\PluginRegistry\PluginRegistryHandler;

class MakeMigrationCommand extends Command
{
    use MigrationMaker;
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'aksara:make:migration
        {type-name : type and name of the module (type/module-name)}
        {name : The name of the migration.}
        {--create= : The table to be created.}
        {--table= : The table to migrate.}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Generate file migration di dalam module';

    private $fileSystem;
    private $config;

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct(
        FileSystem $fileSystem,
        Config $config,
        PluginRegistryHandler $pluginRegistry
    ){
        parent::__construct();
        $this->fileSystem = $fileSystem;
        $this->config = $config;
        $this->pluginRegistry = $pluginRegistry;
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        $typeName = $this->argument('type-name');
        $typeArray = explode('/', $typeName);

        if (count($typeArray) != 2) {
            $this->error('Format type-name tidak valid,
                gunakan format tipe/nama-modul');
        }

        $this->makeModuleMigration($typeArray);
    }

    private function getPluginV2($name)
    {
        if (!$this->pluginRegistry->isRegistered($name)) {
            return false;
        }
        $plugin = $this->pluginRegistry->getManifest($name);
        return $plugin;
    }

    private function makeModuleMigration($typeArray)
    {
        $type = $typeArray[0];
        $moduleName = $typeArray[1];

        $path = '';

        //check plugin v2
        if (strtolower($type) == 'plugin') {
            $pluginV2 = $this->getPluginV2($moduleName);
            if ($pluginV2 != false) {
                $path = $pluginV2->getPluginPath()->migration();
            }
        }

        if (empty($path)) {
            //legacy module loader

            $modules = $this->config->get('aksara.modules');

            if (!isset($modules[$type])) {
                $this->error('Jenis module '
                    . $type
                    .' tidak ada, gunakan [core,plugin,admin,front-end]');
            }

            if (!isset($modules[$type][$moduleName])) {
                $this->error('Module dengan nama '.$moduleName.' tidak ada');
            }

            $module = $modules[$type][$moduleName];

            if (!isset($module['migrationPath'])) {
                $this->info("Module [$type] $moduleName tidak memiliki direktori 'migrations'.");
                return false;
            }

            $path = $module['migrationPath'];
        }

        $this->executeMakeMigration($path);
    }
}
