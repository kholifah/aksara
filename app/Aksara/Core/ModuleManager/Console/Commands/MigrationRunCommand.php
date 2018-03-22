<?php
namespace App\Aksara\Core\ModuleManager\Console\Commands;

use Illuminate\Config\Repository as Config;
use Illuminate\Console\Command;

class MigrationRunCommand extends Command
{
    use PluginGetter;

    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'aksara:migrate
        {type-name : [v1] type and name of the module (type/module-name); [v2] name of the module}';

    protected $description = 'Eksekusi migrasi modul aksara';

    public function __construct(
        Config $config
    ){
        parent::__construct();
        $this->config = $config;
    }

    public function handle()
    {
        $typeName = $this->argument('type-name');
        $typeArray = explode('/', $typeName);

        switch (count($typeArray)) {
        case 1: $this->runMigrationV2($typeArray); break;
        case 2: $this->runMigrationV1($typeArray); break;
        default: $this->error('Format type-name tidak valid,
                gunakan format tipe/nama-modul (v1) atau nama-modul (v2)'); break;
        }
    }

    private function runMigrationV2(array $typeArray)
    {
        $moduleName = $typeArray[0];

        $path = '';

        $pluginV2 = $this->getPluginV2($moduleName);
        if (!$pluginV2) {
            throw new \Exception("$moduleName tidak ditemukan dalam module V2");
        }
        $path = $pluginV2->getModulePath()->migration();

        $this->executeMigration($path);
    }

    private function runMigrationV1(array $typeArray)
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

        $this->executeMigration($path);
    }

    private function executeMigration($path)
    {
        $path = str_replace(base_path(), '/', $path);
        $args = [
            '--path' => $path,
        ];

        $this->call('migrate', $args);
    }

}
