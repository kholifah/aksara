<?php

\Eventy::addAction('aksara.routes.front_end',function(){
    \Route::get('robots.txt',function(){
        $options = get_options('website_options', []);

        $options['robots_txt'] = isset($options['robots_txt']) ? $options['robots_txt'] : false ;
        header('Content-Type: text/plain');
        if( $options['robots_txt'] ) {
            echo "User-agent: *";
            echo PHP_EOL ;
            echo "Disallow: /admin/";
        }
        else {
            echo "User-agent: *";
            echo PHP_EOL ;
            echo "\nDisallow: /";
        }

        die();
    });
});
