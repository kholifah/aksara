<?php
namespace App\Aksara\Core\ModuleManager\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Database\Migrations\Migrator;
use Illuminate\Support\Collection;

class MigrationPendingCommand extends Command
{
    protected $signature = 'aksara:migrate:pending
        {type?} {moduleName?}';

    protected $description = 'Cek migrasi pending';

    public function __construct()
    {
        parent::__construct();
    }

    public function handle()
    {
        $type = $this->argument('type') ?? '';
        $moduleName = $this->argument('moduleName') ?? '';

        $pendings = migration_pending($type, $moduleName);

        $this->info("Pending migrations:");
        foreach ($pendings as $pending) {
            $this->info($pending);
        }
    }

}


