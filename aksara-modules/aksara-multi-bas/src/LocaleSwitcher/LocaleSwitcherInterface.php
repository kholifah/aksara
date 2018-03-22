<?php
namespace Plugins\AksaraMultiBas\LocaleSwitcher;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cookie;
use Illuminate\Support\Facades\Config;

/*
 * Switch the locale
 */
interface LocaleSwitcherInterface
{
    /*
     * Check if the current locale is also default locale
     */
    public function isDefaultLocale($locale=false);

    /*
     * As the function name suggest
     */
    public function getDefaultLocale();

    /*
     * Set locale and persist to cookies
     * If locale not set, it will use the default locale
     */
    public function setLocale($locale);

    /*
     * Get current locale
     */
    public function getCurrentLocale();

}

