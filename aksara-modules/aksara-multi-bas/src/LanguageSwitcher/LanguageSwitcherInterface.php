<?php

namespace Plugins\AksaraMultiBas\LanguageSwitcher;

/*
 * Switch the locale
 */
interface LanguageSwitcherInterface
{
    /*
     * - Based on `multibas_lang` parameter if exist and then redirect to current page
     * Will set both application and front end locale
     */
    public function setCurrentLanguangeFromParam();
    /*
     * - Route
     * - Cookie
     * Will set both application and front end locale
     */
    public function setCurrentLanguange();
}

