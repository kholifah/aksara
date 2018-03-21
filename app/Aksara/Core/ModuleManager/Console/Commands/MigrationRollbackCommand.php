<?php

namespace App\Aksara\Core\ModuleManager\Console\Commands;

use Illuminate\Config\Repository as Config;
use Illuminate\Console\Command;

class MigrationRollbackCommand extends Command
{
    use PluginGetter;

    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'aksara:migrate:rollback';

    protected $description = 'Rollback migrasi modul aksara (semua modul)';

    private $migrator;

    public function __construct(
        Config $config
    ){
        parent::__construct();
        $this->config = $config;
        $this->migrator = app('migrator');
    }

    public function handle()
    {
        $this->registerV1();
        $this->registerV2();
        $this->executeRollback();
    }

    private function registerV1()
    {
        $modules = $this->allV1();

        foreach ($modules as $type => $module) {
            foreach ($module as $name => $manifest) {
                if (isset($manifest['migrationPath'])) {
                    $this->migrator->path($manifest['migrationPath']);
                }
            }
        }
    }

    private function registerV2()
    {
        $modules = $this->allV2();

        foreach ($modules as $module) {
            $this->migrator->path($module->getModulePath()->migration());
        }
    }

    private function executeRollback()
    {
        $this->call('migrate:rollback');
    }
}
