<?php
namespace Aksara\ModuleStatus;

use Aksara\ModuleStatusInfo;

interface ModuleStatus
{
    public function getStatus($type, $moduleName) : ModuleStatusInfo;
    public function isActive($type, $moduleName) : bool;
    public function isRegistered($type, $moduleName) : bool;
    public function getVersion($type, $moduleName) : int;
}
