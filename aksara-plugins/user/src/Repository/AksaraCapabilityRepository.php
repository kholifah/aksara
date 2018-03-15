<?php

namespace Plugins\User\RoleCapability;

use Plugins\User\RoleCapability\CapabilityRepository;

class AksaraCapabilityRepository implements CapabilityRepository
{
    public function all()
    {
        $arrays = $this->allArray();

        $result = [];
        foreach ($arrays as $array) {
            $result[] = $this->convertToObject($array);
        }
        return $result;
    }

    private function allArray()
    {
        $arrays = \Config::get('aksara.user.capabilities', []);
        return $arrays;
    }

    public function add(Capability $data)
    {
        $arrays = $this->allArray();

        $parent = $data->getParent();
        $id = $data->getId();
        $name = $data->getName();

        if ($parent) {
            if (!isset($arrays[$parent])) {
                throw new \Exception('Parent '.$parent.' is not defined');
            }

            $arrays[$parent]['capabilities'][$id] = [ 'name' => $name ];
        } else {
            if (isset($arrays[$id])) {
                throw new \Exception('capability '.$id.' is already defined');
            }

            $arrays[$id] = [
                    'name' => $name,
                    'capabilities' => []
                ];
        }

        \Config::set('aksara.user.capabilities', $arrays);

        return true;
    }

    public function find($id) : ?Capability
    {
        $array =  array_search_value_recursive($id,
            \Config::get('aksara.user.capabilities', []));

        if (!$array) {
            return null;
        }

        return $this->convertToObject($array);
    }

    private function convertToObject($array)
    {
        //dd($array);
        return new Capability($array['id'], $array['name'], $array['parent']);
    }

}
