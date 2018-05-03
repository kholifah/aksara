<?php

namespace Plugins\User\UserCapability;

interface UserCapabilityInterface
{
    public function userHasCapability($userId, $capabilityId);
    public function hasAny($capabilities = []);
    public function hasCapability($capabilityId);
}
