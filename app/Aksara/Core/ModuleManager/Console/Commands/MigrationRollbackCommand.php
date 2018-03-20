<?php

namespace App\Aksara\Core\ModuleManager\Console\Commands;

use Illuminate\Config\Repository as Config;
use Illuminate\Console\Command;
use Aksara\PluginRegistry\PluginRegistryHandler;

class MigrationRollbackCommand extends Command
{
    use PluginGetter;

    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'aksara:migrate:rollback
        {type-name : [v1] type and name of the module (type/module-name); [v2] name of the module}';

    protected $description = 'Rollback migrasi modul aksara';

    public function __construct(
        Config $config,
        PluginRegistryHandler $pluginRegistry
    ){
        parent::__construct();
        $this->config = $config;
        $this->pluginRegistry = $pluginRegistry;
    }

    public function handle()
    {
        $typeName = $this->argument('type-name');
        $typeArray = explode('/', $typeName);

        switch (count($typeArray)) {
        case 1: $this->rollbackMigrationV2($typeArray); break;
        case 2: $this->rollbackMigrationV1($typeArray); break;
        default: $this->error('Format type-name tidak valid,
                gunakan format tipe/nama-modul (v1) atau nama-modul (v2'); break;
        }
    }

    private function rollbackMigrationV2(array $typeArray)
    {
        $moduleName = $typeArray[0];

        $path = '';

        $pluginV2 = $this->getPluginV2($moduleName);
        if (!$pluginV2) {
            throw new \Exception("$moduleName tidak ditemukan dalam module V2");
        }
        $path = $pluginV2->getPluginPath()->migration();

        $this->executeRollback($path);
    }

    private function rollbackMigrationV1(array $typeArray)
    {
        $type = $typeArray[0];
        $moduleName = $typeArray[1];

        $module = $this->getPluginV1($type, $moduleName);

        if (!$module) {
            return false;
        }

        $path = $module['migrationPath'];

        $this->executeRollback($path);
    }

    private function executeRollback($path)
    {
        $path = str_replace(base_path(), '/', $path);
        $args = [
            '--path' => $path,
        ];

        $this->call('migrate:rollback', $args);
    }
}
