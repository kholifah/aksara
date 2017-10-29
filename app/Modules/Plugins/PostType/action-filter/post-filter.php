<?php

\Eventy::addFilter('aksara.post-type.front-end.post-excerpt',function($content){

    $maxLength = 250;
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
