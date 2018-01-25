<?php
namespace Aksara\ModuleDependency;

interface PluginRequiredBy
{
    public function isRequired(string $pluginName) : bool;
    public function getRequiredBy(string $pluginName) : array;
}
