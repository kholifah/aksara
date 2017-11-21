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
    $routeName = \Request::route()->getName();
    $lang = 'en';

    if(!str_contains($routeName, 'lang-'.$lang)) {
        return $query;
    }

    $query->addQuery(function($query) use ($lang) {
        $query = $query->whereIn('id',function($query) use ($lang) {
            $query->select('post_id as id')
                  ->from(with(new \App\Modules\Plugins\PostType\Model\PostMeta())->getTable())
                  ->where('meta_key', 'multibas-translation-'.$lang);
        });

        return $query;
    });

    return $query;
}
