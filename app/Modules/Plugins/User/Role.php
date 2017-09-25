<?php
namespace App\Modules\Plugins\User;

class Role
{
    public function addCapability($name, $id = false, $parent = false)
    {
        if (!$name) {
            throw new \Exception('capability name not set');
        }

        if (!$id) {
            $id = aksara_slugify($name);
        } else {
            $id = aksara_slugify($id);
        }

        $capabilities = \Config::get('aksara.user.capabilities', []);

        if ($parent) {
            if (!isset($capabilities[$parent])) {
                throw new \Exception('Parrent '.$parent.' is not defined');
            }

            $capabilities[$parent]['capabilities'][$id] = [ 'name' => $name ];
        } else {
            if (isset($capabilities[$id])) {
                throw new \Exception('capability '.$id.' is already defined');
            }

            $capabilities[$id] = [
                    'name' => $name,
                    'capabilities' => []
                ];
        }

        \Config::set('aksara.user.capabilities', $capabilities);

        return true;
    }

    public function getCapability($id)
    {
        $capability =  array_search_value_recursive($id, \Config::get('aksara.user.capabilities', []));

        if (!$capability) {
            throw new \Exception('capability '.$id.' is not defined');
        }

        return $capability;
    }
}
