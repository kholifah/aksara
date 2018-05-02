<?php

namespace Plugins\User\UserCapability;

interface UserCapabilityInterface
{
    public function userHasCapability($userId, $capabilityId);
    public function hasCapability($capabilityId);
}
