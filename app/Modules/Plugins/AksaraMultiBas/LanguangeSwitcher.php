<?php
namespace App\Modules\Plugins\AksaraMultiBas;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cookie;
use Illuminate\Support\Facades\Config;

class LanguageSwitcher
{

    public function setLanguageFromParam()
    {
        if(\Request::input('multibas_lang')) {
            $this->setLanguage(\Request::input('multibas_lang'));
             $previousUrl = \Request::url();
             $queryParams = collect(\Request::query())->forget('multibas_lang')->toArray();
             $queryParams = http_build_query($queryParams);
             $queryParams = $queryParams == "" ? $queryParams : "?".$queryParams;

             header("Location: {$previousUrl}{$queryParams}");
             die();
        }
    }

    public function setLanguage($lang)
    {
        $langs = get_registered_languages();
        $langIndex = $langs->pluck('language_code')->search($lang);

        if($langIndex === false) {
            $default = $langs->pluck('default')->search(true);
            $lang = $langs[$default]['language_code'];
        }

        // @TODO change to laravel cookies implementation
        // Cookie::queue('aksara_multibas_lang', $lang, 60);
        setcookie("aksara_multibas_lang", $lang, 0, '/');
        Config::set('aksara.aksara-multi-bas.current_language',$lang);
        // $request = new Request();
        // $request->cookie('aksara_multibas_lang');

        return $lang;
    }

    public function getCurrentLanguage()
    {
        if(isset($_COOKIE["aksara_multibas_lang"])) {
            return $_COOKIE["aksara_multibas_lang"];
        }
        else if(Config::get('aksara.aksara-multi-bas.current_language',false))
        {
            return Config::get('aksara.aksara-multi-bas.current_language');
        }
        else{
            return $this->setLanguage(false);
        }
    }

}
