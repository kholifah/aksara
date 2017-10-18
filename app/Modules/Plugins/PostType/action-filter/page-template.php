<?php

\Eventy::addFilter('aksara.post-type.front-end.template.view',function($viewPriorities,$data) {
    if( $data['postType'] == 'post' && $data['post']->post_type == 'page' ) {
        $pageTemplate = get_page_template($data['post']);
        return [$pageTemplate];
    }
    return $viewPriorities;
},20,2);
