<?php
use App\Modules\Plugins\PostType\Model\PostMeta;
use App\Modules\Plugins\PostType\Model\Post;
use App\Modules\Plugins\AksaraMultiBas\TranslationEngine;

function get_registered_locales()
{
    return collect(json_decode(get_options('multibas_countries', "[]"),true));
}

function get_translated_post($post, $lang)
{
    $translationEngine = new TranslationEngine();
    return $translationEngine->getTranslatedPost($post,$lang);
}

function get_post_language($post)
{
    $postMeta = PostMeta::where('post_id', $post->id)
                            ->where('meta_key','like','multibas-translation-%')
                            ->first();
    if( !$postMeta ) {
        return get_multibas_default_locale();
    }

    return str_replace("multibas-translation-", "", $postMeta->meta_key);
}

function set_multibas_language($lang=false)
{
    $languageSwitcher = \App::make('App\Modules\Plugins\AksaraMultiBas\LocaleSwitcher');
    return $languageSwitcher->setLanguage($lang);
}

function get_current_multibas_locale()
{
    $languageSwitcher = \App::make('App\Modules\Plugins\AksaraMultiBas\LocaleSwitcher');
    return $languageSwitcher->getCurrentLocale();
}

function is_default_multibas_locale($lang = false)
{
    $languageSwitcher = \App::make('App\Modules\Plugins\AksaraMultiBas\LocaleSwitcher');
    return $languageSwitcher->isDefaultLocale($lang);
}
function get_multibas_default_locale()
{
    $languageSwitcher = \App::make('App\Modules\Plugins\AksaraMultiBas\LocaleSwitcher');
    return $languageSwitcher->getDefaultLocale();
}
