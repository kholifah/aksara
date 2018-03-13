<?php
namespace Aksara\Application\Laravel;

use Aksara\Application\ApplicationInterface;
use Illuminate\Contracts\Foundation\Application as ApplicationContract;

class LaravelApplication implements ApplicationInterface
{
    private $app;

    public function __construct(ApplicationContract $app)
    {
        $this->app = $app;
    }

    public function basePath($path = '')
    {
        return $this->app->basePath($path);
    }
}
