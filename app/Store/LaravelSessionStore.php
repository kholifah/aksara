<?php
namespace App\Store;

use Illuminate\Session\Store;
use Aksara\Repository\SessionRepository;

class LaravelSessionStore implements SessionRepository
{
    private $store;

    public function __construct(Store $store)
    {
        $this->store = $store;
    }

    public function has($name)
    {
        return $this->store->has($name);
    }

    public function get($name, $default = null)
    {
        return $this->store->get($name, $default);
    }

    public function put($key, $value = null)
    {
        return $this->store->put($key, $value);
    }

    public function forget($key)
    {
        return $this->store->forget($key);
    }

    public function flash($key, $value = null)
    {
        return $this->store->flash($key, $value);
    }

    public function push($key, $value = null)
    {
        return $this->store->push($key, $value);
    }

}
