<?php

// modify post ordering
\Eventy::addAction('aksara.admin.init-completed', function () {
    $postTypes = \Config::get('aksara.post-type.post-types');
    $languages = get_registered_locales();

    foreach ($postTypes as $postType => $args) {
            \Eventy::addFilter('aksara.post-type.'.$postType.'.index.table.column', 'multibas_column', 1, 2);
            \Eventy::addAction('aksara.post-type.'.$postType.'.index.table.row', 'multibas_row', 1, 2);
    }
});

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
