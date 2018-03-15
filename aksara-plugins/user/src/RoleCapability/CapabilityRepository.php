<?php

namespace Plugins\User\RoleCapability;

interface CapabilityRepository
{
    public function all();
    public function add(Capability $data);
    public function find($id) : Capability;
}
