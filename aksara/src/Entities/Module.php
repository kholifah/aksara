<?php
namespace Aksara\Entities;

class Module
{
    const PLUGIN_TYPE = 'plugin';
    const FRONTEND_TYPE = 'front-end';
    const ADMIN_TYPE = 'admin';
    const CORE_TYPE = 'core';

    private $type;
    private $key;
    private $path;
    private $name;
    //TODO: tambahkan property yang lain spt: migration, dependencies ketika refactor nanti

    public function __construct(
        $type,
        $key,
        $path,
        $name,
        $description = null,
        $dependencies = [],
        $migration = null
    ){
        $this->type = $type;
        $this->key = $key;
        $this->path = $path;
        $this->name = $name;
        $this->description = $description;
        $this->dependencies = $dependencies;
        $this->migration = $migration;
    }

    public static function fromConfigArray($modulesArray)
    {
        $modules = [];
        foreach ($modulesArray as $type => $moduleList) {
            foreach ($moduleList as $moduleKey => $module) {
                $obj = new static (
                    $type,
                    $moduleKey,
                    $module['modulePath'],
                    $module['name']
                );
                $modules[] = $obj;
            }
        }
        return $modules;
    }

    public function getType()
    {
        return $this->type;
    }

    public function getKey()
    {
        return $this->key;
    }

    public function getPath()
    {
        return $this->path;
    }

    public function getAssetPath()
    {
        return $this->getPath() . "/assets";
    }
    //TODO tambahkan yang lain yang diperlukan, misal routePath, migrationPath, dsb

    public function getName()
    {
        return $this->name;
    }

    public function getDescription()
    {
        return $this->description;
    }

    public function getDependencies()
    {
        return $this->dependencies;
    }

    public function getMigration()
    {
        return $this->migration;
    }
}
