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

            $permalink->generatePostArchivePermalinkRoutes();
            $permalink->generateSearchRoute();
            $permalink->generateHomeRoute();
            $permalink->generatePostPermalinkRoutes();

            // Catch All Controller
            \Route::get( '{slug}', ['as' => 'aksara.post-type.front-end.single.catch-all', 'uses' =>'\App\Modules\Plugins\PostType\Http\FrontEndController@serve']);
        },30);
    }
}
