<?php
namespace App\Modules\Plugins\PostType;
use App\Modules\Plugins\PostType\Repository\AksaraQuery;

class Permalink
{
    private $options = [ "{post-type}/{slug}",
                         "{year}/{month}/{slug}",
                         "{taxonomy-name[name]}/{term-name}/{slug}",
                         "{slug}" ];
    private $where = [];
    private $replace = [];

    public function init()
    {
        $registeredTaxonomies = \Config::get('aksara.post-type.taxonomies');
        foreach ($registeredTaxonomies as $taxonomy => $taxonomyArgs) {
            $this->replace['{taxonomy-name['.$taxonomy.']}'] = $taxonomyArgs['slug'];
        }

        $this->replace['{term-name}'] = '{term}';

        \Route::pattern('year', '[0-9]+');
        \Route::pattern('month', '[0-9]+');
    }

    public function getOptions()
    {
        return $this->options;
    }


    public function getPostPermalinkFormat($postType)
    {
        $postPermalinkFormat = "";
        $options = get_options('website_options', []);

        // get from options
        if( isset($options['permalink']) && isset($options['permalink'][$postType]) ) {
            $postPermalinkFormat = $options['permalink'][$postType];
        }
        // page and post special treatment for default value
        elseif( $postType == 'post' || $postType == 'page' ) {
            $postPermalinkFormat =  $this->options[3];
        }
        else {
            // default
            $postPermalinkFormat =  $this->options[0];
        }


        // filter and return
        return \Eventy::filter('aksara.post-type.front-end.post-permalink-format', $postPermalinkFormat);
    }

    public function getPermalink($post)
    {
        $postPermalink = $this->getPostPermalinkFormat($post->post_type);

        $postPermalink = \Eventy::filter('aksara.post-type.front-end.post-permalink.before',$postPermalink,$post);

        $postPermalink = str_replace("{post-type}", $post->post_type, $postPermalink);
        $postPermalink = str_replace("{slug}", $post->post_slug, $postPermalink);
        $postPermalink = str_replace("{year}", $post->post_date->format('Y'), $postPermalink);
        $postPermalink = str_replace("{month}", $post->post_date->format('m'), $postPermalink);
        $postPermalink = url($postPermalink);

        return \Eventy::filter('aksara.post-type.front-end.post-permalink.after',$postPermalink,$post);
    }

    public function getPostPermalinkRoutes($postType)
    {
        $format  = $this->getPostPermalinkFormat($postType);

        foreach ( $this->replace as $pattern => $replace ) {
            $format = str_replace($pattern, $replace, $format);
        }

        // replace post type
        $format = str_replace('{post-type}',get_post_type_args('slug',$postType),$format) ;
        return $format;
    }

    public function generatePostPermalinkRoutes()
    {
        $postTypes = \Config::get('aksara.post-type.post-types');
        foreach ($postTypes as $postType => $args) {

            $format = $this->getPostPermalinkRoutes($postType);

            // register archive
            if( get_post_type_args('publicly_queryable',$postType) && get_post_type_args('has_archive',$postType) ) {
                \Route::get( get_post_type_args('slug_plural',$postType), ['as' => 'aksara.post-type.front-end.archive-post-type.'.$postType, 'uses' =>'\App\Modules\Plugins\PostType\Http\FrontEndController@serve']);
                \Eventy::action('aksara.post-type.permalink.archive-post-type', get_post_type_args('slug_plural',$postType), 'aksara.post-type.front-end.archive-post-type.'.$postType);
            }

            // register single route
            if( get_post_type_args('publicly_queryable',$postType) ) {

                // Do not register catch all route again
                if($format != "{slug}") {
                    $route = \Route::get( $format, ['as' => 'aksara.post-type.front-end.single.'.$postType, 'uses' =>'\App\Modules\Plugins\PostType\Http\FrontEndController@serve']);
                    \Eventy::action('aksara.post-type.permalink.single', $format, 'aksara.post-type.front-end.single.'.$postType);
                }

            }
        }
    }

    public function generatePostArchivePermalinkRoutes()
    {
        // Register Taxonomy
        $registeredTaxonomies = \Config::get('aksara.post-type.taxonomies');

        foreach ($registeredTaxonomies as $taxonomy => $taxonomyArgs) {
            if($taxonomyArgs['has_archive']) {
                \Route::get( $taxonomyArgs['slug'], ['as' => 'aksara.post-type.front-end.archive-taxonomy.'.$taxonomy, 'uses' =>'\App\Modules\Plugins\PostType\Http\FrontEndController@serve']);
                \Eventy::action('aksara.post-type.permalink.archive-taxonomy', $taxonomyArgs['slug'], 'aksara.post-type.front-end.archive-taxonomy.'.$taxonomy);
                \Route::get( $taxonomyArgs['slug'].'/{term?}', ['as' => 'aksara.post-type.front-end.archive-taxonomy.'.$taxonomy, 'uses' =>'\App\Modules\Plugins\PostType\Http\FrontEndController@serve']);
                \Eventy::action('aksara.post-type.permalink.archive-taxonomy-terms',  $taxonomyArgs['slug'].'/{term?}', 'aksara.post-type.front-end.archive-taxonomy.'.$taxonomy);
            }
        }
    }

    public function generateSearchRoute()
    {
        // Generate search
        $path = 'search';
        \Route::get( $path, ['as' => 'aksara.post-type.front-end.search', 'uses' =>'\App\Modules\Plugins\PostType\Http\FrontEndController@serve']);
        \Eventy::action('aksara.post-type.permalink.search', $path, 'aksara.post-type.front-end.search');
    }

    public function generateHomeRoute()
    {
        // Generate home
        \Eventy::action('aksara.post-type.permalink.home', '/', 'aksara.post-type.front-end.home');
        \Route::get('/', ['as' => 'aksara.post-type.front-end.home', 'uses' =>'\App\Modules\Plugins\PostType\Http\FrontEndController@serve']);
    }

    /*
     * Catch All Remaining Route AKA `{slug}`
     */
    public function generateCatchAll()
    {
        // @TODO route `en/posts` is mistakenly routed to `en/{slug}`
        \Eventy::addAction('aksara.routes.after', function() {
            $routeParamsFrontEnd = \Eventy::filter('aksara.middleware.front_end', ['middleware' => ['web','csrf']]);

            // Catch All Controller
            $path = '{slug}';
            $routeName = 'aksara.post-type.front-end.single.catch-all';

            $routeParamsFrontEnd['as'] = $routeName;
            $routeParamsFrontEnd['uses'] = '\App\Modules\Plugins\PostType\Http\FrontEndController@serve';

            \Eventy::action('aksara.post-type.permalink.catch-all', $path, $routeParamsFrontEnd);
            \Route::get( $path, $routeParamsFrontEnd);
        },99);
    }

}
