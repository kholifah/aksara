<?php
namespace App\Aksara\Core\ModuleManager\Console\Commands;

use App\User;
use App\DripEmailer;
use Illuminate\Console\Command;
use Illuminate\Config\Repository as Config;
use Illuminate\FileSystem\FileSystem;
use Illuminate\Console\GeneratorCommand;
use Illuminate\Support\Composer;

class MakeSeedCommand extends GeneratorCommand
{
    use SeedMaker;
    use PluginGetter;
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

    private $config;
    private $composer;
    private $version;
    private $moduleV2;

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct(
        FileSystem $fileSystem,
        Config $config,
        Composer $composer
    ){
        parent::__construct($fileSystem);
        $this->config = $config;
        $this->composer = $composer;
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
        case 1: $this->makeSeedV2($typeArray); break;
        case 2: $this->makeSeedV1($typeArray); break;
        default: $this->error('Format type-name tidak valid,
                gunakan format tipe/nama-modul (v1) atau nama-modul (v2'); break;
        }
    }

    private function makeSeedV2($typeArray)
    {
        $this->version = 2;
        $moduleName = $typeArray[0];

        $this->moduleV2 = $this->getPluginV2($moduleName);

        parent::handle();
        $this->composer->dumpAutoloads();
    }

    /**
     * Get the destination class path.
     *
     * @param  string  $name
     * @return string
     */
    protected function getPath($name)
    {
        if ($this->version == 2 && !is_null($this->moduleV2)) {
            return $this->moduleV2->getModulePath()->seed()."/$name.php";
        }
        return $this->laravel->databasePath().'/seeds/'.$name.'.php';
    }

    /**
     * Parse the class name and format according to the root namespace.
     *
     * @param  string  $name
     * @return string
     */
    protected function qualifyClass($name)
    {
        return $name;
    }

    /**
     * Get the stub file for the generator.
     *
     * @return string
     */
    protected function getStub()
    {
        return __DIR__.'/stubs/seeder.stub';
    }

    private function makeSeedV1($typeArray)
    {
        $this->version = 1;

        $type = $typeArray[0];
        $moduleName = $typeArray[1];

        $module = $this->getPluginV1($type, $moduleName);

        if (!isset($module['seedPath'])) {
            $this->info(
                "Module [$type] $moduleName tidak memiliki direktori 'seeds'.");
            return false;
        }

        $path = $module['seedPath'];

        $this->executeMakeSeed($path);

        $this->addNamespace($path);
    }

    public function addNamespace($path){
        $url_file = $path.'/'.$this->argument('name').'.php';
        $lines = file($url_file);

        $namespace = str_replace(base_path(), "", $path);
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
