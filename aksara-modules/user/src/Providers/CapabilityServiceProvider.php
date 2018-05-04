<?php

namespace Plugins\User\Providers;

use Aksara\Providers\AbstractModuleProvider;

class CapabilityServiceProvider extends AbstractModuleProvider
{
    /**
     * Boot application services
     *
     * e.g, route, anything needs to be preload
     */
    protected function safeBoot()
    {
        \Eventy::addFilter('aksara.menu.admin-sub-menu', function ($adminSubMenu) {
            foreach ($adminSubMenu as $name => $subMenu) {
                foreach ($subMenu as $index => $item) {
                    $capable = \UserCapability::hasAny(@$item['capability'] ?? []);
                    if (!$capable) {
                        unset($adminSubMenu[$name][$index]);
                    }
                }
            }
            return $adminSubMenu;
        });
    }

    protected function safeRegister()
    {
        $this->app->bind(
            \Plugins\User\RoleCapability\RoleCapabilityInterface::class,
            \Plugins\User\RoleCapability\Interactor::class
        );

        $this->app->bind(
            'rolecapability',
            \Plugins\User\RoleCapability\RoleCapabilityInterface::class
        );

        $this->app->bind(
            \Plugins\User\RoleCapability\ConfigRepository::class,
            \Plugins\User\Repository\LaravelConfig::class
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

