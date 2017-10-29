<?php
namespace App\Aksara\Core\ModuleManager\Console\Commands;

use App\User;
use App\DripEmailer;
use Illuminate\Console\Command;

class MigrationCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'aksara:migrate {type} {module-name}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Menjalankan migrasi pada module';


    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        $type = $this->argument('type');
        $moduleName = $this->argument('module-name');

        $modules = \Config::get('aksara.modules');

        if (!isset($modules[$type])) {
            $this->error('Jenis module '.$type.' tidak ada, gunakan [plugin,admin,front-end]');
        }

        if (!isset($modules[$type][$moduleName])) {
            $this->error('Module dengan nama '.$moduleName.' tidak ada');
        }

        $module = $modules[$type][$moduleName];

        $module['migrationPath'] = str_replace(base_path(), "", $module['migrationPath']);

        $this->call('migrate', array('--path' => $module['migrationPath']));
    }
}
