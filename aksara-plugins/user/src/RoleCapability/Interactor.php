<?php
namespace Plugins\User\RoleCapability;

//TODO refactor
//extract DTO's
class Interactor implements RoleCapabilityInterface
{
    private $configRepo;

    public function __construct(ConfigRepository $configRepo)
    {
        $this->configRepo = $configRepo;
    }

    public function add($name, $id = false, $parent = false)
    {
        if (!$name) {
            throw new \Exception('capability name not set');
        }

        // burn !
        if (!$id) {
            // id should not be created from name
            // it should be provided by the caller
            // on the contrary, name can be generated from id
            $id = aksara_slugify($name);
        } else {
            // id format should be as-is
            // if must be slug, then validate, don't convert
            $id = aksara_slugify($id);
        }

        $capabilities = $this->configRepo->get('aksara.user.capabilities', []);

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

        $this->configRepo->set('aksara.user.capabilities', $capabilities);

        return true;
    }

    public function get($id)
    {
        $capability =  array_search_value_recursive($id,
            $this->configRepo->get('aksara.user.capabilities', []));

        if (!$capability) {
            throw new \Exception('capability '.$id.' is not defined');
        }

        return $capability;
    }

    public function all()
    {
        $capabilities = $this->configRepo->get('aksara.user.capabilities', []);
        return $capabilities;
    }
}

