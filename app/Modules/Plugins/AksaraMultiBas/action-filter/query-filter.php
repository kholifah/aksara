<?php
/*
 * Prevent translated content from showing up in post type table
 */
\Eventy::addAction('aksara.admin.init-completed', function () {
    $postTypes = \Config::get('aksara.post-type.post-types');
    foreach ($postTypes as $postType => $args) {
        \Eventy::addFilter( 'aksara.post-type.'.$postType.'.index.query', 'multibas_table_index_exclude_translation', 1, 2);
    }
});

/*
 * Return all post only on the current language
 */
\Eventy::addFilter('aksara.post-type.front-end.template.query', 'multibas_get_translated_post_frontpage');

/*
 * Get post translation for homepage
 */
\Eventy::addFilter('aksara.post-type.front-end.template.query-args', function($args) {

    // Return original post if the current locale is default OR there is no language defined
    if(is_default_multibas_locale() || !get_multibas_default_locale()) {
        return $args;
    }


    if( is_home() && isset($args['id']) ) {

        $locale = get_current_multibas_locale();
        $post = \App\Modules\Plugins\PostType\Model\Post::find($args['id']);
        $postTranslated = get_translated_post($post, $locale);

        if($postTranslated) {
            $args['id'] = $postTranslated->id;
        }
    }

    return $args;
},100,1);


/*
 * Load pages only on default language on website options pages
 */
\Eventy::addFilter('aksara.post-type.front-end.option.pages-query', 'multibas_table_index_exclude_option_pages');

