<?php
namespace Aksara\Repository;

interface SessionRepository
{
    public function has($name);
    public function get($name, $default = null);
    public function put($key, $value = null);
    public function forget($key);
    public function flash($key, $value = null);
    public function push($key, $value = null);
}
