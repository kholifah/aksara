<?php
namespace Aksara\ModuleStatus;

use Aksara\ModuleStatusInfo;

interface ModuleStatus
{
    public function getStatus($type, $moduleName) : ModuleStatusInfo;
}
