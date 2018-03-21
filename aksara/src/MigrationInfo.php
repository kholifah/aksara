<?php

namespace Aksara;

use Illuminate\Contracts\Support\Arrayable;

class MigrationInfo implements Arrayable
{
    private $type;
    private $name;
    private $path;
    private $version;

    public function __construct(string $type, string $name, string $path, int $version)
    {
        $this->type = $type;
        $this->name = $name;
        $this->path = $path;
        $this->version = $version;
    }

    public static function bulk(string $type, string $name, array $paths, int $version)
    {
        $result = array();
        foreach ($paths as $path) {
            $item = new static($type, $name, $path, $version);
            $result[] = $item;
        }
        return $result;
    }

    public function getPath()
    {
        return $this->path;
    }

    public function getVersion()
    {
        return $this->version;
    }

    public function toArray()
    {
        return [
            'type' => $this->type,
            'name' => $this->name,
            'path' => $this->path,
            'version' => $this->version,
        ];
    }

    public function getParams()
    {
        if ($this->version == 1) {
            return "$this->type/$this->name";
        }
        return $this->name;
    }

    public function __toString()
    {
        //dump as migration command
        return 'php artisan aksara:migrate ' . $this->getParams();
    }
}
