<?php
namespace Aksara\AssetRegistry;

use Zerobit\Support\Enum;

class AssetType extends Enum
{
    const SCRIPT = 'script';
    const STYLE = 'style';

    public function __construct($value)
    {
        parent::__construct($value, true);
    }

    public static function script() : self
    {
        return new static(self::SCRIPT);
    }

    public static function style() : self
    {
        return new static(self::STYLE);
    }
}

