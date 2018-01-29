<?php
namespace Aksara\Repository;

interface OptionRepository
{
    public function getOptions($key = false, $default = false);
    public function setOptions($key = false, $value = false);
}
