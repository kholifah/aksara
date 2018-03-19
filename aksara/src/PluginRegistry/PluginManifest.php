<?php
namespace Aksara\PluginRegistry;

class PluginManifest
{
    private $name;
    private $description;
    private $dependencies;
    private $providers;
    private $aliases;
    private $active;

    public function __construct(
        string $name,
        string $description,
        PluginPath $pluginPath,
        array $dependencies = [],
        array $providers = [],
        array $aliases = [],
        bool $active = false
    ){
        $this->name = $name;
        $this->description = $description;
        $this->pluginPath = $pluginPath;
        $this->dependencies = $dependencies;
        $this->providers = $providers;
        $this->aliases = $aliases;
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

    public function getName()
    {
        return $this->name;
    }

    public function getDescription()
    {
        return $this->description;
    }

    public function getPluginPath() : PluginPath
    {
        return $this->pluginPath;
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

    public static function fromPluginConfig(array $array, string $pluginRoot)
    {
        return new static (
            $array['name'],
            $array['description'],
            new PluginPath($pluginRoot, $array['name']),
            isset($array['dependencies']) ? $array['dependencies'] : [],
            isset($array['providers']) ? $array['providers'] : [],
            isset($array['aliases']) ? $array['aliases'] : []
        );
    }

    public function toManifestArray()
    {
        return [
            $this->name => [
                'description' => $this->description,
                'plugin_path' => $this->pluginPath->toArray(),
                'dependencies' => $this->dependencies,
                'providers' => $this->providers,
                'aliases' => $this->aliases,
            ]
        ];
    }
}
