<?php
namespace Plugins\User\Providers;

use Illuminate\Support\ServiceProvider;

class UserServiceProvider extends ServiceProvider
{
    public function register()
    {
        $this->app->bind(
            \Plugins\User\RoleCapability\ConfigRepository::class,
            \Plugins\User\Repository\LaravelConfig::class
        );

        $this->app->bind(
            \Plugins\User\RoleCapability\RoleCapabilityInterface::class,
            \Plugins\User\RoleCapability\Interactor::class
        );

        $this->app->bind(
            'rolecapability',
            \Plugins\User\RoleCapability\RoleCapabilityInterface::class
        );
    }
}

