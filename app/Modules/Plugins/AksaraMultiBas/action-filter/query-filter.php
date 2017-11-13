<?php


// modify post ordering
\Eventy::addAction('aksara.admin.init-completed', function () {
    $postTypes = \Config::get('aksara.post-type.post-types');
    foreach ($postTypes as $postType => $args) {
        \Eventy::addFilter( 'aksara.post-type.'.$postType.'.index.query', 'multibas_table_index_exclude_translation', 1, 2);
    }
});

function multibas_table_index_exclude_translation($query) {

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
