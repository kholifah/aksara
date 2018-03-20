<?php
namespace Aksara\ModuleRegistry;

class ModulePath
{
    private $pluginRoot;
    private $name;

    public function __construct(string $pluginRoot, string $name)
    {
        $this->pluginRoot = $pluginRoot;
        $this->name = $name;
    }

    public function root()
    {
        return $this->pluginRoot.DIRECTORY_SEPARATOR.$this->name;
    }

    public function database()
    {
        return $this->root().DIRECTORY_SEPARATOR.'database';
    }

    public function migration()
    {
        return $this->database().DIRECTORY_SEPARATOR.'migrations';
    }

    public function seed()
    {
        return $this->database().DIRECTORY_SEPARATOR.'seeds';
    }

    public function resource()
    {
        return $this->root().DIRECTORY_SEPARATOR.'resources';
    }

    public function view()
    {
        return $this->resource().DIRECTORY_SEPARATOR.'views';
    }

    public function lang()
    {
        return $this->resource().DIRECTORY_SEPARATOR.'lang';
    }

    public function toArray()
    {
        return [
            'migration' => $this->migration(),
            'view' => $this->view(),
        ];
    }
}
