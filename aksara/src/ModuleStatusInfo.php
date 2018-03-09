<?php
namespace Aksara;

use Illuminate\Contracts\Support\Arrayable;

class ModuleStatusInfo implements Arrayable
{
    private $type;
    private $moduleName;
    private $isActive;
    private $isRegistered;
    private $version;

    public function __construct(
        string $type,
        string $moduleName,
        bool $isActive,
        bool $isRegistered,
        int $version = 1
    ){
        $this->type = $type;
        $this->moduleName = $moduleName;
        $this->isActive = $isActive;
        $this->isRegistered = $isRegistered;
        $this->version = $version;
    }

    public function getVersion() : int
    {
        return $this->version;
    }

    public function toArray()
    {
        return [
            'type' => $this->type,
            'module_name' => $this->moduleName,
            'is_active' => $this->isActive,
            'is_registered' => $this->isRegistered,
            'version' => $this->version,
        ];
    }

    public function getType() : string
    {
        return $this->type;
    }

    public function getModuleName() : string
    {
        return $this->moduleName;
    }

    public function getIsActive() : bool
    {
        return $this->isActive;
    }

    public function getIsRegistered() : bool
    {
        return $this->isRegistered;
    }
}
