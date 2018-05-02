<?php

namespace Plugins\User\UserCapability;

use App\User;

class Interactor implements UserCapabilityInterface
{
    private $user;

    public function __construct(User $user)
    {
        $this->user = $user;
    }

    public function userHasCapability($userId, $capabilityId)
    {
        $user = $this->user->find($userId);

        foreach ($user->roles as $role) {
            $permissions = $role->permissions;
            $hasPermission = in_array($capabilityId, $permissions);
            if ($hasPermission) {
                return true;
            }
        }
        return false;
    }

    public function hasCapability($capabilityId)
    {
        $userId = \Auth::user()->id;
        return $this->userHasCapability($userId, $capabilityId);
    }
}
