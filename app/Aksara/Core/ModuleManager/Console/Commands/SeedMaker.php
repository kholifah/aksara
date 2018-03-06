<?php
namespace App\Aksara\Core\ModuleManager\Console\Commands;

trait SeedMaker
{
    protected function executeMakeSeed($path)
    {
        $args = [
            'name' => '../..'.$path.'/'.$this->argument('name')
        ];

        $this->call('make:seeder', $args);
    }
}
