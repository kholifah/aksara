<?php
namespace Aksara;

class PluginManifest
{
    private $name;
    private $description;
    private $dependencies;
    private $providers;
    private $aliases;
    private $helpers;
    private $active;

    public function __construct(
        string $name,
        string $description,
        array $dependencies = [],
        array $providers = [],
        array $aliases = [],
        array $helpers = [],
        bool $active = false
    ){
        $this->name = $name;
        $this->description = $description;
        $this->dependencies = $dependencies;
        $this->providers = $providers;
        $this->aliases = $aliases;
        $this->helpers = $helpers;
        $this->active = $active;
    }

    public function getActive()
    {
        return $this->active;
    }

    public function setActive(bool $active)
    {
        $this->active = $active;
    }

    public function getHelpers()
    {
        return $this->helpers;
    }

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

    public function getProviders()
    {
        return $this->providers;
    }

    public function getAliases()
    {
        return $this->aliases;
    }

    public static function fromPluginConfig(array $array, bool $active = false)
    {
        return new static (
            $array['name'],
            $array['description'],
            isset($array['dependencies']) ? $array['dependencies'] : [],
            isset($array['providers']) ? $array['providers'] : [],
            isset($array['aliases']) ? $array['aliases'] : [],
            isset($array['helpers']) ? $array['helpers'] : [],
            $active
        );
    }

    public function toManifestArray()
    {
        return [
            $this->name => [
                'description' => $this->description,
                'dependencies' => $this->dependencies,
                'providers' => $this->providers,
                'aliases' => $this->aliases,
                'helpers' => $this->helpers,
            ]
        ];
    }
}
