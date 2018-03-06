<?php
namespace App\Aksara\Core\ModuleManager\Console\Commands;

use App\User;
use App\DripEmailer;
use Illuminate\Console\Command;
use Illuminate\Config\Repository as Config;
use Illuminate\FileSystem\FileSystem;
use App\Aksara\Core\ModuleManager\Console\Commands\DatabaseSeeder;

class MakeSeedRunCommand extends Command
{
    
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'aksara:db:seed
        {type-name : type and name of the module (type/module-name)}
        {name : The name of the seed class.}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Execute file seeder di dalam module';

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

        if (count($typeArray) != 2) {
            $this->error('Format type-name tidak valid, gunakan format tipe/nama-modul');
        }

        $this->makeModuleSeed($typeArray);
    }

    private function makeModuleSeed($typeArray)
    {
        $type = $typeArray[0];
        $moduleName = $typeArray[1];

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

        if (!isset($module['seedPath'])) {
            $this->info("Module [$type] $moduleName tidak memiliki direktori 'seeds'.");
            return false;
        }

        $class = str_replace(base_path(), "", $module['seedPath']) ."/". $this->argument('name');
        $class = str_replace('/', '\\', $class);
        $class = substr_replace($class, 'A', 0, 2);

        $seed = new DatabaseSeeder();
        $seed->run($class);
    }
}
