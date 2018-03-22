<?php

namespace Plugins\AksaraMultiBas\LanguageSwitcher;

/*
 * Switch the locale
 */
class Interactor implements LanguageSwitcherInterface
{
    /*
     * - Based on `multibas_lang` parameter if exist and then redirect to current page
     * Will set both application and front end locale
     */
    public function setCurrentLanguangeFromParam()
    {
        if(\Request::input('multibas_locale')) {
            \LocaleSwitcher::setLocale(\Request::input('multibas_locale'));
            $previousUrl = \Request::url();
            $queryParams = collect(\Request::query())->forget('multibas_locale')->toArray();
            $queryParams = http_build_query($queryParams);
            $queryParams = $queryParams == "" ? $queryParams : "?".$queryParams;

            header("Location: {$previousUrl}{$queryParams}");
            die();
        }
    }
    /*
     * - Route
     * - Cookie
     * Will set both application and front end locale
     */
    public function setCurrentLanguange()
    {
        // Set current locale based on route name
        $routeName = \Request::route()->getName();
        //
        if(str_contains($routeName, '.multibas-locale-')) {
            $locale = substr($routeName, strpos($routeName, ".multibas-locale-"));
            $locale = str_replace( '.multibas-locale-', '', $locale);
            \LocaleSwitcher::setLocale($locale);
        }
        else {
            \LocaleSwitcher::setLocale(false);
        }
    }
}
