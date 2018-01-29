<?php
namespace Aksara\Exceptions;

use Aksara\ModuleIdentifier;

class LoadModuleException extends AppException
{
    private $key;

    public function __construct(ModuleIdentifier $key)
    {
        $message = sprintf('Failed to load module: %s-%s', 
            $key->getType(),
            $key->getModuleName()
        );
        parent::__construct($message, 500, null);
        $this->key = $key;
    }

    public function getKey() : ModuleIdentifier
    {
        return $this->key;
    }

    public function toArray()
    {
        return [
            'dev_message' => $this->getMessage(),
            'user_message' => $this->getMessage(),
            'code' => 500,
            'more_info' => '@tonjoo',
        ];
    }
}

