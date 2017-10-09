<?php

\Eventy::addFilter('aksara.post-type.front-end.post_excerpt',function($content){

    $maxLength = 300;
    $startPos = 0;

    $content = strip_tags($content);

    if(strlen($content) > $maxLength) {
		$excerpt   = substr($content, $startPos, $maxLength-3);
		$lastSpace = strrpos($excerpt, ' ');
		$excerpt   = substr($excerpt, 0, $lastSpace);
		$excerpt  .= ' [...]';
	} else {
		$excerpt = $content;
	}

	return $excerpt;
});
//
\Eventy::addFilter('aksara.post-type.front-end.post_permalink',function($slug,$post){

    if( $post->post_type == 'post' || $post->post_type == 'page' ) {
        $permalink = '';
    }
    else {
        $postTypeSlug = get_post_type_args('slug',$post->post_type);

        $permalink = '/'.$postTypeSlug;
    }

    return url($permalink.'/'.$slug);

},20,2);
