<?php

namespace Plugins\User\UserCapability;

interface UserCapabilityInterface
{
    public function userHasCapability($userId, $capabilityId, $args = []);
    public function hasAny($capabilities = []);
    public function hasCapability($capabilityId, $args = []);
}
