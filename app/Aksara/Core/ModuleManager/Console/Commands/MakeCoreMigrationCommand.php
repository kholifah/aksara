<?php
namespace App\Aksara\Core\ModuleManager\Console\Commands;

use App\User;
use App\DripEmailer;
use Illuminate\Console\Command;
use Illuminate\FileSystem\FileSystem;

class MakeCoreMigrationCommand extends Command
{
    use MigrationMaker;
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'aksara:make:migration:core
        {name : The name of the migration.}
        {--create= : The table to be created.}
        {--table= : The table to migrate.}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Generate file migration di dalam core';

    private $fileSystem;

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct(
        FileSystem $fileSystem
    ){
        parent::__construct();
        $this->fileSystem = $fileSystem;
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        $path = app_path('Aksara/Core/migrations');

        if (!$this->fileSystem->exists($path)) {
            $this->fileSystem->makeDirectory($path);
        }

        $this->executeMakeMigration($path);
    }
}

