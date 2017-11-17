<?php

\Eventy::addAction('aksara.front-end.head',function(){

    $options = get_options('website_options', []);
    $post = get_current_post();

    // Add Custom <title>
    if( is_single() ) {
        \Eventy::addFilter('aksara.site-title',function($title){
            $post = get_current_aksara_query();
            return $title.' - '.$post[0]->post_title;
        });
    }

    // Add Custom <meta name="description">
    if( is_single() ) {
        \Eventy::addFilter('aksara.site-description',function() use ($post) {
            return get_post_excerpt($post);
        });
    }
    else {
        if( isset($options['default_site_description']) ) {
            \Eventy::addFilter('aksara.site-description',function() use ($options) {
                return $options['default_site_description'];
            });
        }
    }

    // Open Graph
    $ogUrl = \Request::url();
    $ogTitle = is_single() ? get_post_title($post) : \Eventy::filter('aksara.site-title','Aksara');
    $ogDescription =  is_single() ? get_post_excerpt($post) : \Eventy::filter('aksara.site-description','Site Description');

    // get Image
    if( is_single() ) {
        $ogImage =  get_post_featured_image($post->id,'small') ;
        echo '<meta property="og:type" content="'.\Eventy::filter('aksara.post-type.og-site-type','article').'" />';
    }
    else {
        $ogImage = "";
    }

    echo view('plugin:post-type::partials.header-meta',compact('options','ogUrl','ogTitle','ogDescription','ogImage'))->render();
});
