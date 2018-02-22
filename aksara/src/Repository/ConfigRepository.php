<?php
namespace Aksara\Repository;

interface ConfigRepository
{
    public function get($key, $default = null);
}
