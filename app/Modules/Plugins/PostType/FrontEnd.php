<?php
namespace App\Modules\Plugins\PostType;
use App\Modules\Plugins\PostType\Repository\AksaraQuery;

class FrontEnd
{

    function init()
    {
        \Eventy::addAction('aksara.routes.front_end',function(){
            $postTypes = \Config::get('aksara.post-type.post-types');
            $registeredTaxonomies = \Config::get('aksara.post-type.taxonomies');

            // Post Type
            foreach( $postTypes as $postType => $postTypeArgs ) {
                if( $postType == 'page') {
                    continue;
                }
                elseif( $postType == 'post' ) {
                    \Route::get( 'posts', ['as' => 'aksara.post-type.front-end.archive-post-type.posts', 'uses' =>'\App\Modules\Plugins\PostType\Http\FrontEndController@serve']);
                }
                else {
                    \Route::get( $postTypeArgs['slug'].'/{slug}', ['as' => 'aksara.post-type.front-end.single.'.$postType, 'uses' =>'\App\Modules\Plugins\PostType\Http\FrontEndController@serve']);
                    \Route::get( $postTypeArgs['slug_plural'], ['as' => 'aksara.post-type.front-end.archive-post-type.'.$postType, 'uses' =>'\App\Modules\Plugins\PostType\Http\FrontEndController@serve']);
                }
            }

            // Taxonomy
            foreach ($registeredTaxonomies as $taxonomy => $taxonomyArgs) {
                \Route::get( $taxonomyArgs['slug'].'/{term?}', ['as' => 'aksara.post-type.front-end.archive-taxonomy.'.$taxonomy, 'uses' =>'\App\Modules\Plugins\PostType\Http\FrontEndController@serve']);
            }
            \Route::get( 'search', ['as' => 'aksara.post-type.front-end.search.', 'uses' =>'\App\Modules\Plugins\PostType\Http\FrontEndController@serve']);

            \Route::get( '/', ['as' => 'aksara.post-type.front-end.home.', 'uses' =>'\App\Modules\Plugins\PostType\Http\FrontEndController@serve']);


            \Route::get( '/{slug}', ['as' => 'aksara.post-type.front-end.single.post', 'uses' =>'\App\Modules\Plugins\PostType\Http\FrontEndController@serve']);

        },30);
    }
}
