<?php
// modify post ordering
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

// Force Query to return post only on current language
\Eventy::addFilter('aksara.post-type.front-end.template.query', 'multibas_get_translated_post_frontpage');

function multibas_get_translated_post_frontpage($query)
{
    //@TODO get current lang
    $routeName = \Request::route()->getName();
    $lang = 'en';

    // if(is_single()) {
    //     return $query;
    // }
    // default language
    if(!str_contains($routeName, 'lang-'.$lang)) {
        $query->addQuery(function($query){
            $query = $query->whereNotIn('id',function($query){
                $query->select('post_id as id')
                      ->from(with(new \App\Modules\Plugins\PostType\Model\PostMeta())->getTable())
                      ->where('meta_key', 'is_translation');
            });

            return $query;
        });
    }
    // translated
    else {
        $query->addQuery(function($query) use ($lang) {
            $query = $query->whereIn('id',function($query) use ($lang) {
                $query->select('post_id as id')
                      ->from(with(new \App\Modules\Plugins\PostType\Model\PostMeta())->getTable())
                      ->where('meta_key', 'multibas-translation-'.$lang);
            });

            return $query;
        });
    }

    return $query;
}

// Set translation if translation detected
\Eventy::addFilter('aksara.post-type.front-end.template.query-args', function($args) {
    $routeName = \Request::route()->getName();
    $lang = 'en';

    // default language, skip
    if(!str_contains($routeName, 'lang-'.$lang)) {
        return $args;
    }

    if( is_home() && isset($args['id']) ) {

        $post = \App\Modules\Plugins\PostType\Model\Post::find($args['id']);
        $postTranslated = get_translated_post($post,$lang);

        if($postTranslated) {
            $args['id'] = $postTranslated->id;
        }

    }

    return $args;
},100,1);


// Load pages only on default language on website options pages
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
