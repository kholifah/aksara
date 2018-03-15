<?php
namespace Plugins\User\RoleCapability;

class Capability
{
    private $name;
    private $id;
    private $capabilities;

    public function __construct(string $id, string $name, array $capabilities = [])
    {
        $this->id = $id;
        $this->name = $name;
        $this->capabilities = $capabilities;
    }

    public function getId()
    {
        return $this->id;
    }

    public function getName()
    {
        return $this->name;
    }

    public function getCapabilities()
    {
        return $this->capabilities;
    }

    public function addCapability(string $capability)
    {
        $this->capabilities[] = $capability;
    }
}
