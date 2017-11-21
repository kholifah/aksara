<?php
namespace App\Aksara\Core\ModuleManager\Console\Commands;

trait MigrationMaker
{
    protected function executeMakeMigration($path)
    {
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
