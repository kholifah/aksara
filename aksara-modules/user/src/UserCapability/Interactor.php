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

    public function userHasCapability($userId, $capabilityId, $args = [])
    {
        $user = $this->user->find($userId);

        foreach ($user->roles as $role) {
            $permissions = $role->permissions;
            $hasPermission = in_array($capabilityId, $permissions);
            if ($hasPermission) {
                $capability = \RoleCapability::get($capabilityId);
                if ($capability['callback']) {
                    $callback = get_callback($capability['callback']);
                    return call_user_func_array($callback, $args);
                }
                return true;
            }
        }
        return false;
    }

    private function isAssoc($arr)
    {
        if (!is_array($arr)) return false;
        if (array() === $arr) return false;
        return array_keys($arr) !== range(0, count($arr) - 1);
    }


    //will only return false if:
    //capabilities is not empty
    //and user has no capability for any capability in parameter
    public function hasAny($capabilities = [])
    {
        //format
        //(['some-capability', 'some-special-capability' => [1, 2, 3]])
        if (empty($capabilities)) {
            $capabilities = [];
        }
        if (!is_array($capabilities) && !$this->isAssoc($capabilities)) {
            $capabilities =  [ $capabilities ];
        }
        //default true when $capabilities is empty
        $capable = true;

        foreach ($capabilities as $key => $capability) {
            if (is_array($capability)) {
                $capable = $this->hasCapability($key, $capability);
            } else {
                $capable = $this->hasCapability($capability);
            }
            //if $capabilities is not empty
            //and user has capability for at least one, then pass
            if ($capable) break;
        }
        return $capable;
    }

    public function hasCapability($capabilityId, $args = [])
    {
        $user = \Auth::user();
        $userId = $user->id;
        return $this->userHasCapability($userId, $capabilityId, $args);
    }
}
