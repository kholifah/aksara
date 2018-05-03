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

    //will only return false if:
    //capabilities is not empty
    //and user has no capability for any capability in parameter
    public function hasAny($capabilities = [])
    {
        if (empty($capabilities)) {
            $capabilities = [];
        }
        if (!is_array($capabilities)) {
            $capabilities =  [ $capabilities ];
        }
        //default true when $capabilities is empty
        $capable = true;
        foreach ($capabilities as $capability) {
            $capable = $this->hasCapability($capability);
            //if $capabilities is not empty
            //and user has capability for at least one, then pass
            if ($capable) break;
        }
        return $capable;
    }

    public function hasCapability($capabilityId)
    {
        $user = \Auth::user();
        $userId = $user->id;
        return $this->userHasCapability($userId, $capabilityId);
    }
}
