<?php

namespace Plugins\PostType\FrontEnd;

use Plugins\PostType\Permalink\PermalinkInterface;

class Interactor implements FrontEndInterface
{
    private $permalink;

    public function __construct(PermalinkInterface $permalink)
    {
        $this->permalink = $permalink;
    }

    /**
     * Registering front end route
     */
    function boot()
    {
        \Eventy::addAction('aksara.routes.front_end',function(){
            $this->generatePostArchivePermalinkRoutes();
            $this->generateSearchRoute();
            $this->generatePostPermalinkRoutes();
            $this->generateHomeRoute();
            $this->generateCatchAll();
        },99);
    }

    private function generateHomeRoute()
    {
        // Generate home
        \Eventy::action('aksara.post-type.permalink.home', '/', 'aksara.post-type.front-end.home');
        \Route::get('/', ['as' => 'aksara.post-type.front-end.home', 'uses' =>'\Plugins\PostType\Http\FrontEndController@serve']);
    }

    private function generateCatchAll()
    {
        // @TODO route `en/posts` is mistakenly routed to `en/{slug}`
        \Eventy::addAction('aksara.routes.after', function() {
            $routeParamsFrontEnd = \Eventy::filter('aksara.middleware.front_end', ['middleware' => ['web','csrf']]);

            // Catch All Controller
            $path = '{slug}';
            $routeName = 'aksara.post-type.front-end.single.catch-all';

            $routeParamsFrontEnd['as'] = $routeName;
            $routeParamsFrontEnd['uses'] = '\Plugins\PostType\Http\FrontEndController@serve';

            \Eventy::action('aksara.post-type.permalink.catch-all', $path, $routeParamsFrontEnd);
            \Route::get( $path, $routeParamsFrontEnd);
        },99);
    }

    private function generatePostPermalinkRoutes()
    {
        $postTypes = \Config::get('aksara.post-type.post-types');
        foreach ($postTypes as $postType => $args) {

            $format = $this->permalink->getPostPermalinkRoutes($postType);

            // register archive
            if( get_post_type_args('publicly_queryable',$postType) && get_post_type_args('has_archive',$postType) ) {
                \Route::get( get_post_type_args('slug_plural',$postType), ['as' => 'aksara.post-type.front-end.archive-post-type.'.$postType, 'uses' =>'\App\Modules\Plugins\PostType\Http\FrontEndController@serve']);
                \Eventy::action('aksara.post-type.permalink.archive-post-type', get_post_type_args('slug_plural',$postType), 'aksara.post-type.front-end.archive-post-type.'.$postType);
            }

            // register single route
            if( get_post_type_args('publicly_queryable',$postType) ) {

                // Do not register catch all route again
                if($format != "{slug}") {
                    $route = \Route::get( $format, ['as' => 'aksara.post-type.front-end.single.'.$postType, 'uses' =>'\Plugins\PostType\Http\FrontEndController@serve']);
                    \Eventy::action('aksara.post-type.permalink.single', $format, 'aksara.post-type.front-end.single.'.$postType);
                }

            }
        }
    }

    private function generateSearchRoute()
    {
        // Generate search
        $path = 'search';
        \Route::get( $path, ['as' => 'aksara.post-type.front-end.search', 'uses' =>'\Plugins\PostType\Http\FrontEndController@serve']);
        \Eventy::action('aksara.post-type.permalink.search', $path, 'aksara.post-type.front-end.search');
    }

    private function generatePostArchivePermalinkRoutes()
    {
        // Register Taxonomy
        $registeredTaxonomies = \Config::get('aksara.post-type.taxonomies');

        foreach ($registeredTaxonomies as $taxonomy => $taxonomyArgs) {
            if($taxonomyArgs['has_archive']) {
                \Route::get( $taxonomyArgs['slug'], ['as' => 'aksara.post-type.front-end.archive-taxonomy.'.$taxonomy, 'uses' =>'\Plugins\PostType\Http\FrontEndController@serve']);
                \Eventy::action('aksara.post-type.permalink.archive-taxonomy', $taxonomyArgs['slug'], 'aksara.post-type.front-end.archive-taxonomy.'.$taxonomy);
                \Route::get( $taxonomyArgs['slug'].'/{term?}', ['as' => 'aksara.post-type.front-end.archive-taxonomy.'.$taxonomy, 'uses' =>'\Plugins\PostType\Http\FrontEndController@serve']);
                \Eventy::action('aksara.post-type.permalink.archive-taxonomy-terms',  $taxonomyArgs['slug'].'/{term?}', 'aksara.post-type.front-end.archive-taxonomy.'.$taxonomy);
            }
        }
    }
}
