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

            // $postTypes = \Config::get('aksara.post-type.post-types');
            // $registeredTaxonomies = \Config::get('aksara.post-type.taxonomies');
            //
            // // Post Type
            // // @TODO pake get_post_permalink_structure
            // foreach( $postTypes as $postType => $postTypeArgs ) {
            //     if( $postType == 'page') {
            //         continue;
            //     }
            //     elseif( $postType == 'post' ) {
            //         \Route::get( 'posts', ['as' => 'aksara.post-type.front-end.archive-post-type.posts', 'uses' =>'\App\Modules\Plugins\PostType\Http\FrontEndController@serve']);
            //     }
            //     else {
            //         \Route::get( $postTypeArgs['slug'].'/{slug}', ['as' => 'aksara.post-type.front-end.single.'.$postType, 'uses' =>'\App\Modules\Plugins\PostType\Http\FrontEndController@serve']);
            //         \Route::get( $postTypeArgs['slug_plural'], ['as' => 'aksara.post-type.front-end.archive-post-type.'.$postType, 'uses' =>'\App\Modules\Plugins\PostType\Http\FrontEndController@serve']);
            //     }
            // }
            $permalink->generatePostPermalinkRoutes();

            $permalink->generatePostArchivePermalinkRoutes();
            $permalink->generateSearchRoute();
            $permalink->generateHomeRoute();

            // Catch All Controller
            \Route::get( '{slug}', ['as' => 'aksara.post-type.front-end.single.catch-all', 'uses' =>'\App\Modules\Plugins\PostType\Http\FrontEndController@serve']);
        },30);
    }
}
