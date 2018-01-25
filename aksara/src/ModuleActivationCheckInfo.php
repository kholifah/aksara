<?php
namespace Aksara;

use Illuminate\Contracts\Support\Arrayable;

class ModuleActivationCheckInfo implements Arrayable
{
    private $type;
    private $slug;
    private $dependencies;
    private $migrations;

    public function __construct(
        string $type,
        string $slug,
        array $dependencies = [],
        array $migrations = []
    ){
        $this->type = $type;
        $this->slug = $slug;
        $this->dependencies = $dependencies;
        $this->migrations = $migrations;
    }

    public function getType() : string
    {
        return $this->type;
    }

    public function getSlug() : string
    {
        return $this->slug;
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
            'slug' => $this->slug,
            'dependencies' => $this->dependencies,
            'migrations' => $this->migrations,
            'allow_activation' => $this->allowActivation(),
        ];
    }
}
