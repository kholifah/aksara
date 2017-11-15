<?php
use App\Modules\Plugins\PostType\Model\PostMeta;
use App\Modules\Plugins\PostType\Model\Post;
use App\Modules\Plugins\AksaraMultiBas\TranslationEngine;

function get_registered_languages()
{
    return collect(json_decode(get_options('multibas_countries', "[]"),true));
}

function get_translated_post($post,$lang)
{
    $translationEngine = new TranslationEngine();
    return $translationEngine->getTranslatedPost($post,$lang);
}

function set_multibas_language($lang=false)
{
    $languageSwitcher = \App::make('App\Modules\Plugins\AksaraMultiBas\LanguageSwitcher');
    return $languageSwitcher->setLanguage($lang);
}

function get_current_multibas_language()
{
    $languageSwitcher = \App::make('App\Modules\Plugins\AksaraMultiBas\LanguageSwitcher');
    return $languageSwitcher->getCurrentLanguage();
}
