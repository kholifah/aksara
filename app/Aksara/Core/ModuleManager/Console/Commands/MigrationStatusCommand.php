<?php
namespace App\Aksara\Core\ModuleManager\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Database\Migrations\Migrator;
use Illuminate\Support\Collection;
use Symfony\Component\Console\Input\InputOption;

class MigrationStatusCommand extends Command
{
    protected $signature = 'aksara:migrate:status
        {--database= : The database connection to use}
        {--path= : The path to migration files to use}';

    protected $description = 'Cek status migrasi semua modul';

    /**
     * The migrator instance.
     *
     * @var \Illuminate\Database\Migrations\Migrator
     */
    protected $migrator;

    public function __construct(Migrator $migrator)
    {
        parent::__construct();
        $this->migrator = $migrator;
    }

    public function handle()
    {
        $this->migrator->setConnection($this->option('database'));

        if (! $this->migrator->repositoryExists()) {
            return $this->error('No migrations found.');
        }

        $paths = migration_paths();

        if (count($migrations = $this->getStatusFor($paths)) > 0) {
            $this->table(['Ran?', 'Migration'], $migrations);
        } else {
            $this->error('No migrations found');
        }
    }

    private function getStatusFor($paths)
    {
        $files = $this->migrator->getMigrationFiles($paths);
        $ran = $this->migrator->getRepository()->getRan();

        $collection = Collection::make($files)
            ->map(function ($migration) use ($ran) {
                $migrationName = $this->migrator->getMigrationName($migration);

                return in_array($migrationName, $ran)
                    ? ['<info>Y</info>', $migrationName]
                    : ['<fg=red>N</fg=red>', $migrationName];
            });

        return $collection;
    }


}
