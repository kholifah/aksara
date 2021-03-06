<?php
namespace Aksara\ModuleRegistry;

class ModuleManifest
{
    private $name;
    private $description;
    private $dependencies;
    private $providers;
    private $aliases;
    private $active;
    private $title;

    private function __construct(
        string $name,
        string $description,
        ModulePath $pluginPath,
        array $dependencies = [],
        array $providers = [],
        array $aliases = [],
        string $type = 'plugin',
        ?string $title = null,
        bool $active = false
    ){
        $this->name = $name;
        $this->description = $description;
        $this->modulePath = $pluginPath;
        $this->dependencies = $dependencies;
        $this->providers = $providers;
        $this->aliases = $aliases;
        $this->type = $type;
        $this->title = $title;
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

    public function getModulePath() : ModulePath
    {
        return $this->modulePath;
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

    public function getType()
    {
        return $this->type;
    }

    public function getTitle()
    {
        return $this->title;
    }

    public static function fromModuleConfig(array $array, string $moduleRoot)
    {
        $module = new static (
            $array['name'],
            $array['description'],
            new ModulePath($moduleRoot, $array['name']),
            isset($array['dependencies']) ? $array['dependencies'] : [],
            isset($array['providers']) ? $array['providers'] : [],
            isset($array['aliases']) ? $array['aliases'] : [],
            isset($array['type']) ? $array['type'] : 'plugin',
            isset($array['title']) ? $array['title'] : null
        );
        return $module;
    }

    public function toManifestArray()
    {
        return [
            $this->name => [
                'description' => $this->description,
                'module_path' => $this->modulePath->toArray(),
                'dependencies' => $this->dependencies,
                'providers' => $this->providers,
                'aliases' => $this->aliases,
                'type' => $this->type,
                'title' => $this->title,
            ]
        ];
    }
}
