<?php
namespace App\Modules\Plugins\PostType;
use App\Modules\Plugins\PostType\Repository\AksaraQuery;

class FrontEnd
{
    /**
     * Registering front end route
     */
    function init()
    {
        \Eventy::addAction('aksara.routes.front_end',function(){
            $permalink = \App::make('App\Modules\Plugins\PostType\Permalink');
            $permalink->generatePostPermalinkRoute();
            $permalink->generatePostArchivePermalinkRoute();

            // Search
            \Route::get( 'search', ['as' => 'aksara.post-type.front-end.search.', 'uses' =>'\App\Modules\Plugins\PostType\Http\FrontEndController@serve']);

            // Home
            \Route::get( '/', ['as' => 'aksara.post-type.front-end.home.', 'uses' =>'\App\Modules\Plugins\PostType\Http\FrontEndController@serve']);

            // Catch All Controller
            \Route::get( '{slug}', ['as' => 'aksara.post-type.front-end.single.post', 'uses' =>'\App\Modules\Plugins\PostType\Http\FrontEndController@serve']);
        },30);
    }
}
