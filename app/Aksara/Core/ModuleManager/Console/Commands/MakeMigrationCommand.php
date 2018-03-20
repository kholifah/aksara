<?php
namespace App\Aksara\Core\ModuleManager\Console\Commands;

use App\User;
use App\DripEmailer;
use Illuminate\Console\Command;
use Illuminate\Config\Repository as Config;
use Illuminate\FileSystem\FileSystem;

class MakeMigrationCommand extends Command
{
    use MigrationMaker;
    use PluginGetter;
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
        Config $config
    ){
        parent::__construct();
        $this->fileSystem = $fileSystem;
        $this->config = $config;
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

        switch (count($typeArray)) {
        case 1: $this->makeMigrationV2($typeArray); break;
        case 2: $this->makeMigrationV1($typeArray); break;
        default: $this->error('Format type-name tidak valid,
                gunakan format tipe/nama-modul (v1) atau nama-modul (v2'); break;
        }
    }

    private function makeMigrationV2($typeArray)
    {
        $moduleName = $typeArray[0];

        $path = '';

        $pluginV2 = $this->getPluginV2($moduleName);
        if (!$pluginV2) {
            throw new \Exception("$moduleName tidak ditemukan dalam module V2");
        }
        $path = $pluginV2->getPluginPath()->migration();

        $this->executeMakeMigration($path);
    }

    private function makeMigrationV1($typeArray)
    {
        $type = $typeArray[0];
        $moduleName = $typeArray[1];

        $module = $this->getPluginV1($type, $moduleName);

        if (!$module) {
            return false;
        }
        if (!isset($module['migrationPath'])) {
            $this->info("Module [$type] $moduleName tidak memiliki direktori 'migrations'.");
            return false;
        }

        $path = $module['migrationPath'];

        $this->executeMakeMigration($path);
    }
}
