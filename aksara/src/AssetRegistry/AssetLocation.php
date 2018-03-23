<?php
namespace Aksara\AssetRegistry;

use Zerobit\Support\Enum;

class AssetLocation extends Enum
{
    const ADMIN = 'admin';
    const FRONTEND = 'front-end';
    const ADMIN_FOOTER = 'admin-footer';
    const FRONTEND_FOOTER = 'front-end-footer';

    public function __construct($value)
    {
        parent::__construct($value, true);
    }

    public static function frontend() : self
    {
        return new static(self::FRONTEND);
    }

    public static function admin() : self
    {
        return new static(self::ADMIN);
    }

    public static function adminFooter() : self
    {
        return new static(self::ADMIN_FOOTER);
    }
 
    public static function frontendFooter() : self
    {
        return new static(self::FRONTEND_FOOTER);
    }
}
