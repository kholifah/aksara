<?php
namespace App\Aksara\Core\ModuleManager\Console\Commands;

use App\User;
use App\DripEmailer;
use Illuminate\Console\Command;
use Illuminate\Config\Repository as Config;
use Illuminate\FileSystem\FileSystem;

class MakeSeedCommand extends Command
{
    use SeedMaker;
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'aksara:make:seeder
        {type-name : type and name of the module (type/module-name)}
        {name : The name of the migration.}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Generate file seeder di dalam module';

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

        $path = str_replace(base_path(), "", $module['seedPath']);

        $this->executeMakeSeed($path);

        $this->addNamespace($path, $module['seedPath']);
    }

    public function addNamespace($path, $seedPath){
        $url_file = public_path($path.'/'.$this->argument('name').'.php');
        $url_file = str_replace('public/', '', $url_file);
        $lines = file($url_file);

        $namespace = str_replace(base_path(), "", $seedPath);
        $namespace = str_replace('/', '\\', $namespace);
        $namespace = substr_replace($namespace, 'A', 0, 2);
        
        $current = '';
        if($lines){
            $lines[1] = "namespace ".$namespace.";\n\n";
            $lines[4] = "class ".$this->argument('name')." extends Seeder\n";

            foreach ($lines as $data) {
                $current .= $data;
            }
        }
                
        file_put_contents($url_file, $current);
        
    }


}
