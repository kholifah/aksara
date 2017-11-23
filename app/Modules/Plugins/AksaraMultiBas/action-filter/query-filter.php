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


function multibas_table_index_exclude_translation($query)
{
    $query->addQuery(function($query){
        $query = $query->whereNotIn('id',function($query){
            $query->select('post_id as id')
                  ->from(with(new \App\Modules\Plugins\PostType\Model\PostMeta())->getTable())
                  ->where('meta_key', 'is_translation');
        });

        return $query;
    });

    return $query;
}

/*
 * Return all post only on the current language
 */
\Eventy::addFilter('aksara.post-type.front-end.template.query', 'multibas_get_translated_post_frontpage');

function multibas_get_translated_post_frontpage($query)
{
    // Return original post if the current locale is default OR there is no language defined
    if(is_default_multibas_locale() || !get_multibas_default_locale()) {
        $query->addQuery(function($query){
            $query = $query->whereNotIn('id',function($query){
                $query->select('post_id as id')
                      ->from(with(new \App\Modules\Plugins\PostType\Model\PostMeta())->getTable())
                      ->where('meta_key', 'is_translation');
            });

            return $query;
        });
    }
    else {
        $locale = get_current_multibas_locale();
        $query->addQuery(function($query) use ($locale) {
            $query = $query->whereIn('id',function($query) use ($locale) {
                $query->select('post_id as id')
                      ->from(with(new \App\Modules\Plugins\PostType\Model\PostMeta())->getTable())
                      ->where('meta_key', 'multibas-translation-'.$locale);
            });

            return $query;
        });
    }

    return $query;
}

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

function multibas_table_index_exclude_option_pages($query)
{
    $query = $query->whereNotIn('id',function($query){
        $query->select('post_id as id')
              ->from(with(new \App\Modules\Plugins\PostType\Model\PostMeta())->getTable())
              ->where('meta_key', 'is_translation');
    });

    return $query;
}
