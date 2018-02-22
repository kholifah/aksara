<?php
namespace App\Store;

use Aksara\Repository\ConfigRepository;
use Illuminate\Config\Repository as Config;

class LaravelConfig implements ConfigRepository
{
    private $config;

    public function __construct(Config $config)
    {
        $this->config = $config;
    }

    public function get($key, $default = null)
    {
        return $this->config->get($key, $default);
    }
}
