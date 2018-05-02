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

        $this->app->bind(
            \Plugins\User\RoleCapability\RoleCapabilityInterface::class,
            \Plugins\User\RoleCapability\Interactor::class
        );

        $this->app->bind(
            'rolecapability',
            \Plugins\User\RoleCapability\RoleCapabilityInterface::class
        );

        $this->app->singleton(
            \Plugins\User\UserCapability\UserCapabilityInterface::class,
            \Plugins\User\UserCapability\Interactor::class
        );

        $this->app->bind(
            'usercapability',
            \Plugins\User\UserCapability\UserCapabilityInterface::class
        );
    }
}

