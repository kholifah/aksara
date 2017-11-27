<?php

// modify post ordering
\Eventy::addAction('aksara.init', function () {
    $countries = get_registered_locales();

    foreach ($countries as $country) {

        if($country['default']) {
            continue;
        }

        \Eventy::addAction('aksara.post-type.permalink.search', function($route, $routeName) use ($country) {
            \Route::get( $country['language_code'].'/'.$route, ['as' => $routeName.'.multibas-locale-'.$country['language_code'], 'uses' =>'\App\Modules\Plugins\PostType\Http\FrontEndController@serve']);
        }, 10, 2);
        \Eventy::addAction('aksara.post-type.permalink.home', function($route, $routeName) use ($country) {
            \Route::get( $country['language_code'].'/'.$route, ['as' => $routeName.'.multibas-locale-'.$country['language_code'], 'uses' =>'\App\Modules\Plugins\PostType\Http\FrontEndController@serve']);
        }, 10, 2);
        \Eventy::addAction('aksara.post-type.permalink.archive-post-type', function($route, $routeName) use ($country) {
            \Route::get( $country['language_code'].'/'.$route, ['as' => $routeName.'.multibas-locale-'.$country['language_code'], 'uses' =>'\App\Modules\Plugins\PostType\Http\FrontEndController@serve']);
        }, 10, 2);
        \Eventy::addAction('aksara.post-type.permalink.single', function($route, $routeName) use ($country) {
            \Route::get( $country['language_code'].'/'.$route, ['as' => $routeName.'.multibas-locale-'.$country['language_code'], 'uses' =>'\App\Modules\Plugins\PostType\Http\FrontEndController@serve']);
        }, 10, 2);
        \Eventy::addAction('aksara.post-type.permalink.archive-taxonomy', function($route, $routeName) use ($country) {
            \Route::get( $country['language_code'].'/'.$route, ['as' => $routeName.'.multibas-locale-'.$country['language_code'], 'uses' =>'\App\Modules\Plugins\PostType\Http\FrontEndController@serve']);
        }, 10, 2);
        \Eventy::addAction('aksara.post-type.permalink.archive-taxonomy-terms', function($route, $routeName) use ($country) {
            \Route::get( $country['language_code'].'/'.$route, ['as' => $routeName.'.multibas-locale-'.$country['language_code'], 'uses' =>'\App\Modules\Plugins\PostType\Http\FrontEndController@serve']);
        }, 10, 2);
        \Eventy::addAction('aksara.post-type.permalink.catch-all', function($route, $routeParamsFrontEnd) use ($country) {

            $routeParamsFrontEnd['as'] = $routeParamsFrontEnd['as'].'.multibas-locale-'.$country['language_code'];
            \Route::get( $country['language_code'].'/'.$route, $routeParamsFrontEnd);
        }, 10, 2);

    }

});
