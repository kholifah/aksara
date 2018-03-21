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
}
