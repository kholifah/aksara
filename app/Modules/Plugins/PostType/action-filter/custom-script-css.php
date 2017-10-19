<?php

\Eventy::addAction('aksara.front-end.head',function(){

    $options = get_options('website_options', []);

    echo @$options['header_script'];
    echo @$options['header_css'];
});

\Eventy::addAction('aksara.front-end.footer',function(){

    $options = get_options('website_options', []);

    echo @$options['footer_script'];
    echo @$options['footer_css'];
});
