<?php

namespace Aksara\ModuleLoader;

use Aksara\ModuleRegistry\ModuleManifest;

interface ModuleLoaderInterface
{
    public function load(ModuleManifest $module);
}
