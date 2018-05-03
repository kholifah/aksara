<?php
namespace Plugins\User\Providers;

use Aksara\Providers\AbstractModuleProvider;

class UserServiceProvider extends AbstractModuleProvider
{
    protected function safeRegister()
    {
        $this->app->bind(
            \Plugins\User\RoleCapability\ConfigRepository::class,
            \Plugins\User\Repository\LaravelConfig::class
        );
    }
}

