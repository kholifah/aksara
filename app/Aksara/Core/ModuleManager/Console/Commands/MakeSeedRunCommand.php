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
    use PluginGetter;

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

        switch (count($typeArray)) {
        case 1: $this->runSeedV2($typeArray); break;
        case 2: $this->runSeedV1($typeArray); break;
        default: $this->error('Format type-name tidak valid,
                gunakan format tipe/nama-modul (v1) atau nama-modul (v2'); break;
        }
    }

    private function runSeedV2($typeArray)
    {
        $module = $this->getPluginV2($typeArray[0]);

        $class = $this->argument('name');
        $includeFile = $module->getModulePath()->seed()."/$class.php";

        spl_autoload_register(function ($class) use ($includeFile) {
            include $includeFile;
        });

        $seeder = new $class();
        $seeder->run();
    }

    private function runSeedV1($typeArray)
    {
        $type = $typeArray[0];
        $moduleName = $typeArray[1];

        $module = $this->getPluginV1($type, $moduleName);

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
