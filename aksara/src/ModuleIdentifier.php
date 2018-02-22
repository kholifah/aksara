<?php
namespace Aksara;

interface ModuleIdentifier
{
    public function getType() : string;
    public function getModuleName() : string;
}

