<?php
namespace App\Aksara\Core\ModuleManager\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Database\Migrations\Migrator;
use Illuminate\Support\Collection;

class MigrationCheckCommand extends Command
{
    protected $signature = 'aksara:migrate:check
        {type?} {moduleName?}';

    protected $description = 'Cek migrasi komplit dalam boolean';

    public function __construct()
    {
        parent::__construct();
    }

    public function handle()
    {
        $type = $this->argument('type') ?? '';
        $moduleName = $this->argument('moduleName') ?? '';

        $complete = migration_complete($type, $moduleName);

        $this->info($complete ? "Migration completed\n" : "Migration not completed\n");
    }

}

