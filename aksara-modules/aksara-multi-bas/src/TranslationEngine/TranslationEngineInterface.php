<?php

namespace Plugins\AksaraMultiBas\TranslationEngine;

interface TranslationEngineInterface
{
    function getTranslatedPost($post, $lang);

    /*
     * Create post translation
     */
    function createPostTranslation($postId,$lang);
}

