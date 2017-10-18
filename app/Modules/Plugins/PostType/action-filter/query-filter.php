<?php

\Eventy::addFilter('aksara.post-type.front-end.template.query-args',function($args){

    if( \Auth::check() ) {
        $args['post_status'] = ['publish','draft'];
    }

    return $args;
});
