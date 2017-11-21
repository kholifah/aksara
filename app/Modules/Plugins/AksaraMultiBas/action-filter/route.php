<?php

// modify post ordering
\Eventy::addAction('aksara.init', function () {
    $countries = get_registered_languages();
return;
    foreach ($countries as $country) {

        if($country['default']) {
            continue;
        }

        \Eventy::addAction('aksara.post-type.permalink.search', function($route, $routeName) use ($country) {
            \Route::get( $country['language_code'].'/'.$route, ['as' => $routeName.'.lang-'.$country['language_code'], 'uses' =>'\App\Modules\Plugins\PostType\Http\FrontEndController@serve']);
        }, 10, 2);
        \Eventy::addAction('aksara.post-type.permalink.home', function($route, $routeName) use ($country) {
            \Route::get( $country['language_code'].'/'.$route, ['as' => $routeName.'.lang-'.$country['language_code'], 'uses' =>'\App\Modules\Plugins\PostType\Http\FrontEndController@serve']);
        }, 10, 2);
        \Eventy::addAction('aksara.post-type.permalink.archive-post-type', function($route, $routeName) use ($country) {
            \Route::get( $country['language_code'].'/'.$route, ['as' => $routeName.'.lang-'.$country['language_code'], 'uses' =>'\App\Modules\Plugins\PostType\Http\FrontEndController@serve']);
        }, 10, 2);
        \Eventy::addAction('aksara.post-type.permalink.single', function($route, $routeName) use ($country) {
            \Route::get( $country['language_code'].'/'.$route, ['as' => $routeName.'.lang-'.$country['language_code'], 'uses' =>'\App\Modules\Plugins\PostType\Http\FrontEndController@serve']);
        }, 10, 2);
    }

});
