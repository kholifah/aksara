<?php
namespace Aksara;

use Illuminate\Contracts\Support\Arrayable;

class ModuleActivationCheckInfo implements Arrayable, ModuleIdentifier
{
    private $type;
    private $moduleName;
    private $dependencies;
    private $migrations;

    public function __construct(
        string $type,
        string $moduleName,
        array $dependencies = [],
        array $migrations = []
    ){
        $this->type = strtolower($type);
        $this->moduleName = $moduleName;
        $this->dependencies = $dependencies;
        $this->migrations = $migrations;
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

    public function allowActivation() : bool
    {
        //no pending migrations
        if (count($this->migrations) > 0) {
            return false;
        }
        //no unregistered
        foreach ($this->dependencies as $dependency) {
            if (!$dependency->getIsRegistered()) {
                return false;
            }
        }
        return true;
    }

    public function toArray()
    {
        return [
            'type' => $this->type,
            'module_name' => $this->moduleName,
            'dependencies' => array_map(function ($item) {
                return $item->toArray();
            }, $this->dependencies),
            'migrations' => array_map(function ($item) {
                return (string)$item;
            }, $this->migrations),
            'allow_activation' => $this->allowActivation(),
        ];
    }
}
