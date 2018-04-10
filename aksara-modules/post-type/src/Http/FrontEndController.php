<?php
namespace Plugins\PostType\Http;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Plugins\PostType\Repository\AksaraQuery;
use Plugins\PostType\Model\Post as Post;

class FrontEndController extends Controller
{
    /*
     * Serve all front end route ex: Post Type, Taxonomy, Author, home, 404 and search
     */
    function serve()
    {
        \Eventy::action('aksara.post-type.front-end.before-query');
        $routeName = \Request::route()->getName();

        // aksara.post-type.front-end.template.data
        $data = [];
        $data['posts'] = false;
        $data['post'] = false;
        $data['postType'] = false;
        $data['taxonomy'] = false;
        $aksaraQueryArgs = false;

        if( str_contains($routeName,'single') ) {

            // Check if slug exist
            \Config::set('aksara.post-type.front-end.template.is-single',true);

            $data['postType'] =  get_current_post_type();

            $aksaraQueryArgs['post_type'] = $data['postType'];
            $aksaraQueryArgs['post_slug'] = \Request::route('slug');

            $viewPriorities = [
                'single-'.$data['postType'],
                'single',
            ];
        }
        elseif (str_contains($routeName,'archive-taxonomy') ) {
            \Config::set('aksara.post-type.front-end.template.is-archive',true);
            \Config::set('aksara.post-type.front-end.template.is-archive-taxonomy',true);

            $data['taxonomy'] = get_current_taxonomy();

            $viewPriorities = [
                'archive-'.$data['taxonomy'],
                'archive-taxonomy',
                'archive',
            ];

            $term = \Request::route('term');

            if( !$term )
                $aksaraQueryArgs['taxonomy'] = $data['taxonomy'] ;
            else {
                $aksaraQueryArgs['taxonomy_query'] = [
                        'and'=> [
                            'taxonomy' => $data['taxonomy'],
                            'field' => 'slug',
                            'terms' => $term,
                            'include_children' => true
                        ]
                    ] ;
            }

            $aksaraQueryArgs['post_type'] = false;
        }
        elseif (str_contains($routeName,'archive-post-type') ) {

            \Config::set('aksara.post-type.front-end.template.is-archive',true);
            \Config::set('aksara.post-type.front-end.template.is-archive-post-type',true);

            $data['postType'] =  get_current_post_type();
            $viewPriorities = [
                'archive-'.$data['postType'],
                'archive',
            ];
            $aksaraQueryArgs['post_type'] = $data['postType'];
        }
        elseif (str_contains($routeName,'home') ) {

            \Config::set('aksara.post-type.front-end.template.is_home',true);

            $aksaraQueryArgs['post_type'] = 'post' ;

            $viewPriorities = [
                'home',
            ];
        }
        elseif (str_contains($routeName,'search') ) {

            \Config::set('aksara.post-type.front-end.template.is-archive',true);
            \Config::set('aksara.post-type.front-end.template.is-search',true);

            $aksaraQueryArgs['post_type'] = false;

            $viewPriorities = [
                'search',
                'archive',
            ];
        }

        // Search Query Param
        if ( ( \Config::get('aksara.post-type.front-end.template.is-archive',false) ||
               \Config::get('aksara.post-type.front-end.template.is-search',false) ) &&
               \Request::input('query') ) {

                \Config::set('aksara.post-type.front-end.template.is-search',true);

                $aksaraQueryArgs['query'] = \Request::input('query');
        }

        // Modifiying the generated AksaraQuery is possible using this filter
        $aksaraQueryArgs = \Eventy::filter('aksara.post-type.front-end.template.query-args', $aksaraQueryArgs);

        if( is_array($aksaraQueryArgs) ) {

            $aksaraQuery = new AksaraQuery($aksaraQueryArgs);

            // Modifiying query builder
            $aksaraQuery = \Eventy::filter('aksara.post-type.front-end.template.query', $aksaraQuery);
            set_current_aksara_query($aksaraQuery);

            $data['posts'] = $aksaraQuery->paginate();
            $data['post'] = $data['posts']->first();

            set_current_post($data['post']);

            if( \Config::get('aksara.post-type.front-end.template.is-single',false) ) {
                if( !$data['post'] )
                    abort(404,'Page Not Found');
            }
        }

        get_current_aksara_query();

        // Add or alter template data is possible
        $data = \Eventy::filter('aksara.post-type.front-end.template.data',$data);
        // Alter the default view
        $viewPriorities = \Eventy::filter('aksara.post-type.front-end.template.view',$viewPriorities,$data);

        \Eventy::action('aksara.post-type.front-end.before-render',$data);

        foreach ($viewPriorities as $viewPriority) {
            if(frontend_view_exists($viewPriority)) {
                return frontend_view($viewPriority, compact('data'));
            }
        }

        abort(404,'Page Not Found');
    }
}
