<?php
\Eventy::addFilter('aksara.post-type.front-end.post-permalink.before',function($permalink, $post) {
    $translationLang = get_post_meta($post->id,'is_translation');

    if( $translationLang ) {
        return get_post_language($post).'/'.$permalink;
    }

    return $permalink;
},100,2);
