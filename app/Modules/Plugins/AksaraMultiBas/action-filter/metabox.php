<?php
// modify post ordering
\Eventy::addAction('aksara.init-completed', function () {
    $postTypes = \Config::get('aksara.post-type.post-types');

    foreach ($postTypes as $postType => $args) {
        add_meta_box('multibas', $postType, 'render_metabox_multibas', false, 'metabox-sidebar', 5);
    }
});

function render_metabox_multibas($post)
{
    $postLists = [];
    $languages = get_registered_languages();

    if( get_post_meta($post->id,'is_translation') ) {
        $originalPost = \App\Modules\Plugins\PostType\Model\PostMeta::where('meta_key','like','multibas-translation-%')
                                                                        ->where('post_id','=',$post->id)
                                                                        ->first();
        $post = \App\Modules\Plugins\PostType\Model\Post::where('id',$originalPost->meta_value)->first();
    }

    foreach ( $languages as $language ) {
        $postList = [];
        $postList['language'] = $language;
        $postList['post'] = $language['default'] ? $post : get_translated_post($post,$language['language_code']);

        array_push($postLists,$postList);
    }

    echo view('plugin:aksara-multi-bas::metabox', compact('postLists','post'))->render();
}
