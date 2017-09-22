<?php
// modify post ordering
\Eventy::addAction('aksara.init',function(){

    $postTypes = \Config::get('aksara.post_type');
    $postTypes = array_keys($postTypes);

    foreach ($postTypes as $postType) {

        \Eventy::addfilter('aksara.post-type.'.$postType.'.index.pre-get-post',function( $posts){

            if( get_current_post_type() == 'page' )
                $posts = $posts->orderBy('post_title','asc');
            else
                $posts = $posts->orderBy('post_date','desc');

            return $posts;
        });
    }
},90);
