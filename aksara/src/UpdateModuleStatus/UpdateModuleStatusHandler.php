<?php
namespace Aksara\UpdateModuleStatus;

use Aksara\ModuleIdentifier;

interface UpdateModuleStatusHandler
{
    public function activate(ModuleIdentifier $key);
    public function deactivate(ModuleIdentifier $key);
}
