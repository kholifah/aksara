<?php
namespace Aksara\ErrorLoadModule;

use Aksara\Exceptions\LoadModuleException;

interface ErrorLoadModuleHandler
{
    public function handle(LoadModuleException $exception);
}
