<?php
namespace Plugins\User\RoleCapability;

//TODO refactor
//extract DTO's
interface RoleCapabilityInterface
{
    public function add($name, $id = false, $parent = false);
    public function get($id);
    public function all();
}
