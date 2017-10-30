<?php
use App\Modules\Plugins\PostType\Model\PostMeta;
use App\Modules\Plugins\PostType\Model\Post;
use App\Modules\Plugins\AksaraMultiBas\TranslationEngine;

function get_registered_languages() {
    return collect(json_decode(get_options('multibas_countries', "[]"),true));
}

function get_translated_post($post,$lang) {
    $translationEngine = new TranslationEngine();

    return $translationEngine->getTranslatedPost($post,$lang);

}
