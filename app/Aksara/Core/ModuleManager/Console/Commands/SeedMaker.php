<?php
namespace App\Aksara\Core\ModuleManager\Console\Commands;

trait SeedMaker
{
    protected function executeMakeSeed($path)
    {
        if (!is_dir($path)) {
            if (!file_exists($path)) {
                $this->fileSystem->makeDirectory($path, 0755, true);
            } else {
                $this->error("Nama direktori $path sudah terpakai");
            }
        }
        $path = str_replace(base_path(), "", $path);
        $args = [
            'name' => '../..'.$path.'/'.$this->argument('name')
        ];

        $this->call('make:seeder', $args);
    }
}
