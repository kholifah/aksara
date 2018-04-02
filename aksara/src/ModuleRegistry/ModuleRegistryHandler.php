<?php

namespace Aksara\ModuleRegistry;

interface ModuleRegistryHandler
{
    public function getModulePath($name) : ModulePath;
    public function getRegisteredModules();
    public function getRegisteredModulesGrouped();
    public function getActiveModules();
    public function isActive($name);
    public function isRegistered($name);
    public function activateModule($name);
    public function deactivateModule($name);
    public function getManifest($name);
}
