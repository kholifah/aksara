<?php
namespace Aksara\Repository;

interface OptionRepository
{
    public function getOptions($key, $default = false);
}
