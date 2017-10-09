<?php
namespace App\Modules\Plugins\PostType\Http;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Modules\Plugins\PostType\Repository\AksaraQuery;
use App\Modules\Plugins\PostType\Model\Post as Post;

class FrontEndController extends Controller
{
    function serve()
    {
        $routeName = \Request::route()->getName();

        // aksara.post-type.front-end.template.data
        $data = [];
        $data = \Eventy::filter('aksara.post-type.front-end.template.data',$data);
        $data['posts'] = false;
        $data['post'] = false;
        $data['postType'] = false;
        $data['taxonomy'] = false;
        $aksaraQueryArgs = false;

        if( str_contains($routeName,'single') ) {

            // Check if slug exist
            \Config::set('aksara.post-type.front-end.template.is_single',true);

            $data['postType'] =  get_current_post_type();

            $aksaraQueryArgs['post_type'] = $data['postType'];
            $aksaraQueryArgs['post_slug'] = \Request::route('slug');

            $viewPriorities = [
                'front-end:aksara::single-'.$data['postType'],
                'front-end:aksara::single'
            ];
        }
        elseif (str_contains($routeName,'archive-taxonomy') ) {

            \Config::set('aksara.post-type.front-end.template.is_archive',true);
            $data['taxonomy'] = get_current_taxonomy_from_route('archive-taxonomy.');

            $viewPriorities = [
                'front-end:aksara::archive-'.$data['taxonomy'] ,
                'front-end:aksara::archive-taxonomy',
                'front-end:aksara::archive'
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

            \Config::set('aksara.post-type.front-end.template.is_archive',true);
            $data['postType'] =  get_current_post_type();
            $viewPriorities = [
                'front-end:aksara::archive-'.$data['postType'],
                'front-end:aksara::archive'
            ];
            $aksaraQueryArgs['post_type'] = $data['postType'];
        }
        elseif (str_contains($routeName,'home') ) {

            \Config::set('aksara.post-type.front-end.template.is_home',true);
            $aksaraQueryArgs['post_type'] = 'post' ;

            $viewPriorities = [
                'front-end:aksara::home'
            ];
        }
        elseif (str_contains($routeName,'search') ) {

            \Config::set('aksara.post-type.front-end.template.is_archive',true);
            \Config::set('aksara.post-type.front-end.template.is_search',true);
            $viewPriorities = [
                'front-end:aksara::search',
                'front-end:aksara::archive'
            ];
        }

        if( is_array($aksaraQueryArgs) ) {

            $aksaraQueryArgs = \Eventy::filter('aksara.post-type.front-end.template.query-args',$aksaraQueryArgs);

            $data['posts'] = new AksaraQuery($aksaraQueryArgs);
            $data['posts'] = $data['posts']->getQuery();
            $data['posts'] = $data['posts']->get();
            $data['post'] = $data['posts']->first();

            if( \Config::get('aksara.post-type.front-end.template.is_single',false) ) {
                if( !$data['post'] )
                    abort(404,'Page Not Found');
            }
        }

        $viewPriorities = \Eventy::filter('aksara.post-type.front-end.template.view',$viewPriorities,$data);

        foreach ( $viewPriorities as $viewPriority ) {
            if( view()->exists($viewPriority) ) {
                return view($viewPriority,compact('data'));
            }
        }

        abort(404,'Page Not Found');
    }
}
