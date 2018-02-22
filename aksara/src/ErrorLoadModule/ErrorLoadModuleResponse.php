<?php
namespace Aksara\ErrorLoadModule;

use Aksara\Exceptions\LoadModuleException;

class ErrorLoadModuleResponse
{
    private $exception;
    private $info;

    public function __construct(LoadModuleException $exception, string $info)
    {
        $this->exception = $exception;
        $this->info = $info;
    }

    public function getException() : LoadModuleException
    {
        return $this->exception;
    }

    public function getInfo() : string
    {
        return $this->info;
    }

    public function getMessage() : string
    {
        return $this->exception->getMessage() . ' ' . $this->info;
    }
}
