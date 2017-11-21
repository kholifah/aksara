<?php
// Set Page Template
\Eventy::addFilter('aksara.post-type.front-end.template.view', function($viewPriorities,$data) {
    if( is_single() && isset($data['post']) && $data['post']->post_type == 'page' ) {
        $pageTemplate = get_page_template($data['post']);

        if($pageTemplate != 'default')
            return [$pageTemplate];
    }
    return $viewPriorities;
},20,2);

// Set Homepage Template
\Eventy::addFilter('aksara.post-type.front-end.template.view', function($viewPriorities,$data) {

    $options = get_options('website_options', []);

    if( is_home() && isset($options['front_page']) && $options['front_page'] != 'default' ) {

        $post = \App\Modules\Plugins\PostType\Model\Post::find($options['front_page']);
        $pageTemplate = get_page_template($post);
        if($pageTemplate != 'default') {
            return [$pageTemplate];
        }
        // Return default single page priority
        else {
            return [
                'front-end:aksara::single-'.$data['postType'],
                'front-end:aksara::single'
            ];
        }
    }

    return $viewPriorities;
},20,2);

// Set post data
\Eventy::addFilter('aksara.post-type.front-end.template.query-args', function($args) {

    $options = get_options('website_options', []);

    if( is_home() && isset($options['front_page']) && $options['front_page'] != 'default' ) {

        // $post = \App\Modules\Plugins\PostType\Model\Post::find($options['front_page']);
        // $data['post'] = $post;
        // Query default aksara loop dengan jenis post
        $args['post_type'] = 'page';
        $args['id'] = $options['front_page'];

        // set_current_post($data['post']);
        \Config::set('aksara.post-type.front-end.template.is-single',true);
    }

    return $args;
},20,2);
