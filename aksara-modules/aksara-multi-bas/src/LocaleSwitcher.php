<?php
namespace Plugins\AksaraMultiBas;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cookie;
use Illuminate\Support\Facades\Config;

/*
 * Switch the locale
 */
class LocaleSwitcher
{
    /*
     * - Based on `multibas_lang` parameter if exist and then redirect to current page
     * Will set both application and front end locale
     */
    public function setCurrentLanguangeFromParam()
    {
        if(\Request::input('multibas_locale')) {
            $this->setLocale(\Request::input('multibas_locale'));
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
            $this->setLocale($locale);
        }
        else {
            $this->setLocale(false);
        }
    }

    /*
     * Check if the current locale is also default locale
     */
    public function isDefaultLocale($locale=false)
    {
        if($locale==false) {
            $locale = $this->getCurrentLocale();
        }
        $defaultLocale = $this->getDefaultLocale();

        if(!$defaultLocale) {
            return false;
        }

        return $defaultLocale == $locale;
    }

    /*
     * As the function name suggest
     */
    public function getDefaultLocale()
    {
        $locales = get_registered_locales();

        if(sizeof($locales)==0) {
            return false;
        }

        $default = $locales->pluck('default')->search(true);
        $locale = $locales[$default];

        return $locale['language_code'];
    }

    /*
     * Set locale and persist to cookies
     * If locale not set, it will use the default locale
     */
    public function setLocale($locale)
    {
        $locales = get_registered_locales();

        $localeIndex = $locales->pluck('language_code')->search($locale);

        // Fallback to default locale , only if locales has been added
        if($localeIndex === false && sizeof($locales) != 0) {
            $locale = $this->getDefaultLocale();
        }

        // Set locale
        Config::set('aksara.aksara-multi-bas.current_locale',$locale);

        // Only set cookies
        if($locale) {
            setcookie("aksara_multibas_locale", $locale, 0, '/');
            \App::setLocale($locale);
        }

        return $locale;
    }

    /*
     * Get current locale
     */
    public function getCurrentLocale()
    {
        return Config::get('aksara.aksara-multi-bas.current_locale');
    }

}
