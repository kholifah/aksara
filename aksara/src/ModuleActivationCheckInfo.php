<?php
namespace Aksara;

use Illuminate\Contracts\Support\Arrayable;

class ModuleActivationCheckInfo implements Arrayable, ModuleIdentifier
{
    private $type;
    private $moduleName;
    private $dependencies;
    private $migrations;
    private $seeds;

    public function __construct(
        string $type,
        string $moduleName,
        array $dependencies = [],
        array $migrations = [],
        array $seeds = []
    ){
        $this->type = strtolower($type);
        $this->moduleName = $moduleName;
        $this->dependencies = $dependencies;
        $this->migrations = $migrations;
        $this->seeds = $seeds;
    }

    public function getType() : string
    {
        return $this->type;
    }

    public function getModuleName() : string
    {
        return $this->moduleName;
    }

    public function getDependencies() : array
    {
        return $this->dependencies;
    }

    public function getMigrations() : array
    {
        return $this->migrations;
    }

    public function getSeeds() : array
    {
        return $this->seeds;
    }

    public function allowActivation() : bool
    {
        //no pending migrations
        if (count($this->migrations) > 0) {
            return false;
        }
        //no unregistered dependencies
        foreach ($this->dependencies as $dependency) {
            if (!$dependency->getIsRegistered()) {
                return false;
            }
        }
        return true;
    }

    public function toArray()
    {
        $array = [
            'type' => $this->type,
            'module_name' => $this->moduleName,
            'dependencies' => array_map(function ($item) {
                return $item->toArray();
            }, $this->dependencies),
            'migrations' => array_map(function ($item) {
                return (string)$item;
            }, $this->migrations),
            'migration_paths' => array_map(function ($item) {
                return $item->getPath();
            }, $this->migrations),
            'allow_activation' => $this->allowActivation(),
            'seed_commands' => $this->seeds,
        ];
        return $array;
    }
}
