<?php
namespace App\Aksara\Core\ModuleManager\Console\Commands;

trait MigrationMaker
{
    protected function executeMakeMigration($path)
    {
        if (!is_dir($path)) {
            if (!file_exists($path)) {
                $this->fileSystem->makeDirectory($path, 0755, true);
            } else {
                $this->error("Nama direktori $path sudah terpakai");
            }
        }

        $path = str_replace(base_path(), '', $path);

        $create = $this->option('create');
        $table = $this->option('table');

        $args = [
            'name' => $this->argument('name'),
            '--path' => $path,
        ];

        if (!is_null($create)) {
            $args['--create'] = $create;
        }

        if (!is_null($table)) {
            $args['--table'] = $table;
        }

        $this->call('make:migration', $args);
    }
}
