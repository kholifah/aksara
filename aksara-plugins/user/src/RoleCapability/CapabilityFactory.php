<?php

namespace Plugins\User\RoleCapability;

use Cocur\Slugify\Slugify;

class CapabilityFactory
{
    private $slugifier;

    public function __construct(Slugify $slugifier)
    {
        $this->slugifier = $slugifier;
    }

    public function make($name, $id = false, $parent = false)
    {
    }

}
