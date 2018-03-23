<?php

//query-filter
//
function multibas_table_index_exclude_translation($query)
{
    $query->addQuery(function($query){
        $query = $query->whereNotIn('id',function($query){
            $query->select('post_id as id')
                  ->from(with(new \Plugins\PostType\Model\PostMeta())->getTable())
                  ->where('meta_key', 'is_translation');
        });

        return $query;
    });

    return $query;
}

function multibas_get_translated_post_frontpage($query)
{
    // Return original post if the current locale is default OR there is no language defined
    if(is_default_multibas_locale() || !get_multibas_default_locale()) {
        $query->addQuery(function($query){
            $query = $query->whereNotIn('id',function($query){
                $query->select('post_id as id')
                      ->from(with(new \Plugins\PostType\Model\PostMeta())->getTable())
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
                      ->from(with(new \Plugins\PostType\Model\PostMeta())->getTable())
                      ->where('meta_key', 'multibas-translation-'.$locale);
            });

            return $query;
        });
    }

    return $query;
}

function multibas_table_index_exclude_option_pages($query)
{
    $query = $query->whereNotIn('id',function($query){
        $query->select('post_id as id')
              ->from(with(new \Plugins\PostType\Model\PostMeta())->getTable())
              ->where('meta_key', 'is_translation');
    });

    return $query;
}

function multibas_column($cols, $postType) {

    $languages = get_registered_locales();

    foreach( $languages as $language ) {
        insert_after_array_key($cols, 'title',
            [ ' multibas-locale-'.$language['locale'].' multibas-'.$language['language_code'] => ['title'=>'<span class="flag-icon flag-icon-'.$language['flag_code'].'"></span>','class'=>"multibas-column no-sort",'width'=>'25px']]
        );
    }

    return $cols;
}

function multibas_row($colsId, $post) {
    if( !str_contains($colsId,'multibas') ) {
        return;
    }

    $languages = get_registered_locales();

    // Separate them multibas class on the column
    $colsId = explode(' ', $colsId);

    $locale = $colsId[1];
    $locale = str_replace("multibas-locale-", "", $locale);


    $lang = $colsId[2];
    $lang = str_replace("multibas-", "", $lang);


    foreach( $languages as $language ) {
        if( $locale == $language['locale'] ) {
            if( $language['default'] == true) {
                echo '<td class="multibas-column" ><span class="glyphicon glyphicon-ok" ></span></td>';
            }
            else {
                 $translatedPost = get_translated_post($post, $language['language_code']);

                 if( $translatedPost ) {
                     echo '<td class="multibas-column"><a href="'.route('admin.'.get_current_post_type_args('route').'.edit', $translatedPost->id).'" class="glyphicon glyphicon-pencil" ></a></td>';
                 }
                 else {
                     echo '<td class="multibas-column"><a class="glyphicon glyphicon-plus" href="'.route('aksara-multibas-generate-translation', ['postId'=>$post->id, 'lang'=>$lang]).'"></a></td>';
                 }
            //
            }
        }
    }
}
