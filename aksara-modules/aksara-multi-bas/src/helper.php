<?php
use Plugins\PostType\Model\PostMeta;
use Plugins\PostType\Model\Post;

function get_registered_locales()
{
    return collect(json_decode(get_options('multibas_countries', "[]"),true));
}

function get_translated_post($post, $lang)
{
    return \TranslationEngine::getTranslatedPost($post,$lang);
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
    return \LocaleSwitcher::setLanguage($lang);
}

function get_current_multibas_locale()
{
    return \LocaleSwitcher::getCurrentLocale();
}

function is_default_multibas_locale($lang = false)
{
    return \LocaleSwitcher::isDefaultLocale($lang);
}

function get_multibas_default_locale()
{
    return \LocaleSwitcher::getDefaultLocale();
}

function multibas_admin_enqueue_script($assetPath, $id=false, $priority=20, $footer=false)
{
    aksara_admin_enqueue_module_script('aksara-multi-bas', $assetPath, $id, $priority, $footer);
}

function multibas_admin_enqueue_style($assetPath, $id, $priority, $footer)
{
    aksara_admin_enqueue_module_style('aksara-multi-bas', $assetPath, $id, $priority, $footer);
}

