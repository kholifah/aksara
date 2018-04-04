<?php

namespace Aksara\Providers;

use Illuminate\Support\ServiceProvider;
use Aksara\Exceptions\LoadModuleException;
use Aksara\Exceptions\ModuleRegistrationException;
use Aksara\ModuleKey;

abstract class AbstractModuleProvider extends ServiceProvider
{
    protected $moduleName;
    protected $type;

    protected function safeBoot() {}
    protected function safeRegister() {}

    public function __construct($app, $moduleName = null, $type = null)
    {
        parent::__construct($app);
        $this->moduleName = $moduleName;
        $this->type = $type;
    }

    public function boot()
    {
        try {
            $this->safeBoot();
        } catch (\Error $e) {
            throw new LoadModuleException(
                new ModuleKey(
                    $this->type,
                    $this->moduleName
                ));
        }
    }

    public function register()
    {
        try {
            $this->safeRegister();
        } catch (\Error $e) {
            throw new LoadModuleException(
                new ModuleKey(
                    $this->type,
                    $this->moduleName
                )
            );
        }
    }
}

