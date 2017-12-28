<?php
namespace App\Aksara\Core\ModuleManager\Console\Commands;

use App\User;
use App\DripEmailer;
use Illuminate\Console\Command;
use Illuminate\Config\Repository as Config;
use Illuminate\FileSystem\FileSystem;

class MigrationCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'aksara:migrate';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Menjalankan migrasi pada semua module';

    private $config;

    public function __construct(
        Config $config,
        FileSystem $fileSystem
    ){
        parent::__construct();
        $this->config = $config;
        $this->fileSystem = $fileSystem;
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        $this->migrateCore();
        $this->migrateModules();
    }

    private function migrateModules()
    {
        $this->info('Migrasi modul...');

        $modules = $this->config->get('aksara.modules');

        foreach ($modules as $type => $moduleList) {
            foreach ($moduleList as $moduleName => $module) {
                $this->info("[$type] $moduleName:");
                if (!isset($module['migrationPath'])) {
                    $this->info(
                        "Module ini tidak memiliki direktori 'migrations'.");
                    continue;
                }
                $module['migrationPath'] = str_replace(
                    base_path(),
                    "",
                    $module['migrationPath']
                );
                $this->call('migrate', [
                    '--path' => $module['migrationPath']
                ]);
            }
        }
    }

    private function migrateCore()
    {
        $this->info('Migrasi core...');

        $path = app_path('Aksara/Core/migrations');

        if (!$this->fileSystem->exists($path)) {
            $this->info('Core migration tidak ada');
            return;
        }
        $path = str_replace(base_path(), "", $path);

        $this->call('migrate', [
            '--path' => $path
        ]);
    }
}
