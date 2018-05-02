<?php

namespace Plugins\User\UserCapability;

interface UserCapabilityInterface
{
    public function hasCapability($id, $parent = false);
}
