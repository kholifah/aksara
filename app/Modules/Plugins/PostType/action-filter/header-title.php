<?php
\Eventy::addAction('aksara.front-end.head',function(){

    //Add title to <title>
    if( is_single() ) {
        \Eventy::addFilter('aksara.site-title',function($title){
            $post = get_current_aksara_query();
            return $title.' - '.$post[0]->post_title;
        });
    }

    echo view('plugin:post-type::partials.header-meta')->render();
});
