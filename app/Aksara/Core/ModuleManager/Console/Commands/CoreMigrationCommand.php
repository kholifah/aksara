<?php
namespace App\Aksara\Core\ModuleManager\Console\Commands;

use App\User;
use App\DripEmailer;
use Illuminate\Console\Command;
use Illuminate\FileSystem\FileSystem;
use Illuminate\Config\Repository as Config;

class CoreMigrationCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'aksara:migrate:core';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Menjalankan migrasi pada core module';

    private $fileSystem;

    public function __construct(
        Config $config,
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
            $this->info('Core migration tidak ada, gunakan aksara:make:migration:core untuk membuat migrasi di core.');
            return;
        }

        $this->call('migrate', [
            '--path' => $path
        ]);
    }
}

