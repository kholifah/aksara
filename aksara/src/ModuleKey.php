<?php
namespace Aksara;

use Illuminate\Contracts\Support\Arrayable;

class ModuleKey implements Arrayable
{
    private $type;
    private $moduleName;

    public function __construct(
        string $type,
        string $moduleName
    ){
        $this->type = $type;
        $this->moduleName = $moduleName;
    }

    public function __toString()
    {
        return $this->type . '/' . $this->moduleName;
    }

    public function toArray()
    {
        return [
            'type' => $this->type,
            'module_name' => $this->moduleName,
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
}
