<?php
namespace Plugins\PostType\Providers;

use Aksara\Providers\AbstractModuleProvider;

class ActionFilterServiceProvider extends AbstractModuleProvider
{
    /**
     * Boot application services
     *
     * e.g, route, anything needs to be preload
     */
    public function safeBoot()
    {
        /**
         * post-index-list
         */
        \Eventy::addAction('aksara.init-completed', function () {
            $postTypes = \Config::get('aksara.post-type.post-types');
            $postTypes = array_keys($postTypes);

            foreach ($postTypes as $postType) {
                \Eventy::addfilter('aksara.post-type.'.$postType.'.index.query', 'post_type_index_filter_ordering');
                \Eventy::addfilter('aksara.post-type.'.$postType.'.index.query', 'post_type_index_filter_search');
                \Eventy::addfilter('aksara.post-type.'.$postType.'.index.query', 'post_type_index_filter_filter_taxonomy');
                \Eventy::addfilter('aksara.post-type.'.$postType.'.index.query', 'post_type_index_filter_post_status', 1, 80);
                \Eventy::addfilter('aksara.post-type.'.$postType.'.index.query-args', 'post_type_index_filter_args_post_status', 1, 80);
                \Eventy::addfilter('aksara.post-type.'.$postType.'.index.data', 'post_type_index_custom_view_dat', 1, 90);
            }
        }, 90);

        /**
         * set-post-terms
         */
        \Eventy::addAction('aksara.init-completed', function () {
            $postTypes = \Config::get('aksara.post-type.post-types');
            $postTypes = array_keys($postTypes);

            foreach ($postTypes as $postType) {
                \Eventy::addAction('aksara.post-type.'.$postType.'.create', 'post_type_set_post_terms', 20, 2);
                \Eventy::addAction('aksara.post-type.'.$postType.'.update', 'post_type_set_post_terms', 20, 2);
            }
        }, 90);

        /**
         * base-metabox
         */
        \Eventy::addAction('aksara.init-completed', function () {
            $postTypes = \Config::get('aksara.post-type.post-types');

            foreach ($postTypes as $postType => $args) {
                $supports = $args['supports'];

                if (in_array('title', $supports)) {
                    add_meta_box('title', $postType, 'render_metabox_title', false, 'metabox', 10);
                }

                if (in_array('editor', $supports)) {
                    add_meta_box('editor', $postType, 'render_metabox_editor', false, 'metabox', 10);
                }

                add_meta_box('save-post', $postType, 'render_metabox_save_post', false, 'metabox-sidebar', 10);
                \Metabox::addClass(new \Plugins\PostType\PostDateMetaBox($postType));

                if (in_array('thumbnail', $supports)) {
                    add_meta_box('thumbnail', $postType, 'render_metabox_thumbnail', 'save_metabox_thumbnail', 'metabox-sidebar', 10);
                }

                add_meta_box('taxonomy', $postType, 'render_metabox_taxonomy', false, 'metabox-sidebar', 10);
            }

            add_meta_box('media', 'media', 'render_metabox_media', false, 'metabox', 10);
            add_meta_box('page-template', 'page', 'render_metabox_page_template', 'save_metabox_page_template', 'metabox-sidebar', 10);
        });

        /**
         * base-table
         */
        \Eventy::addAction('aksara.init-completed', function () {
            $postTypes = \Config::get('aksara.post-type.post-types');

            foreach ($postTypes as $postType => $args) {
                \Eventy::addFilter('aksara.post-type.'.$postType.'.index.table.column', 'post_type_base_column', 1, 2);
                \Eventy::addAction('aksara.post-type.'.$postType.'.index.table.row', 'post_type_base_row', 1, 2);
            }
        });

        \Eventy::addFilter('aksara.post-type.media.index.table.column',
            'post_type_image_column', 20, 2);

        \Eventy::addAction('aksara.post-type.media.index.table.row', 'post_type_image_row', 1, 2);

        \Eventy::addFilter('aksara.post-type.post.index.table.column', 'post_type_tag_category_column', 20, 2);
        \Eventy::addAction('aksara.post-type.post.index.table.row', 'post_type_tag_category_row', 1, 2);

        /**
         * add-capabilities
         */
        \Eventy::addAction('aksara.init-completed', function () {
            $postTypes = \Config::get('aksara.post-type.post-types');

            foreach ($postTypes as $postType => $args) {
                $name = array_get($args, 'label.name');
                $slug = aksara_slugify($name);

                add_capability($name, $slug);
                add_capability("Add ".$name, "add-".$slug, $slug);
                add_capability("Edit ".$name, "edit-".$slug, $slug);
                add_capability("Delete ".$name, "delete-".$slug, $slug);
            }
        });

        /**
         * post-filter
         */
        \Eventy::addFilter('aksara.post-type.front-end.post-excerpt',function($content){

            $maxLength = 250;
            $startPos = 0;

            $content = strip_tags($content);

            if(strlen($content) > $maxLength) {
                $excerpt   = substr($content, $startPos, $maxLength-3);
                $lastSpace = strrpos($excerpt, ' ');
                $excerpt   = substr($excerpt, 0, $lastSpace);
                $excerpt  .= ' [...]';
            } else {
                $excerpt = $content;
            }

            return $excerpt;
        });

        /**
         * page-template
         */
        \Eventy::addFilter('aksara.post-type.front-end.template.view', function($viewPriorities,$data) {
            if( is_single() && isset($data['post']) && $data['post']->post_type == 'page' ) {
                $pageTemplate = get_page_template($data['post']);

                if($pageTemplate != 'default')
                    return [$pageTemplate];
            }
            return $viewPriorities;
        },20,2);

        // Set Homepage Template
        \Eventy::addFilter('aksara.post-type.front-end.template.view', function($viewPriorities,$data) {

            $options = get_options('website_options', []);

            if( is_home() && isset($options['front_page']) && $options['front_page'] != 'default' ) {

                $post = \Plugins\PostType\Model\Post::find($options['front_page']);
                $pageTemplate = get_page_template($post);
                if($pageTemplate != 'default') {
                    return [$pageTemplate];
                }
                // Return default single page priority
                else {
                    return [
                        'front-end:aksara::single-'.$data['postType'],
                        'front-end:aksara::single'
                    ];
                }
            }

            return $viewPriorities;
        },20,2);

        // Set post data
        \Eventy::addFilter('aksara.post-type.front-end.template.query-args', function($args) {

            $options = get_options('website_options', []);

            if( is_home() && isset($options['front_page']) && $options['front_page'] != 'default' ) {

                // $post = \Plugins\PostType\Model\Post::find($options['front_page']);
                // $data['post'] = $post;
                // Query default aksara loop dengan jenis post
                $args['post_type'] = 'page';
                $args['id'] = $options['front_page'];

                // set_current_post($data['post']);
                \Config::set('aksara.post-type.front-end.template.is-single',true);
            }

            return $args;
        },20,2);

        /**
         * header-meta-tag
         */
        \Eventy::addAction('aksara.front-end.head',function(){

            $options = get_options('website_options', []);
            $post = get_current_post();

            // Add Custom <title>
            if( is_single() ) {
                \Eventy::addFilter('aksara.site-title',function($title){
                    $post = get_current_aksara_query();
                    return $title.' - '.$post[0]->post_title;
                });
            }

            // Add Custom <meta name="description">
            if( is_single() ) {
                \Eventy::addFilter('aksara.site-description',function() use ($post) {
                    return get_post_excerpt($post);
                });
            }
            else {
                if( isset($options['default_site_description']) ) {
                    \Eventy::addFilter('aksara.site-description',function() use ($options) {
                        return $options['default_site_description'];
                    });
                }
            }

            // Open Graph
            $ogUrl = \Request::url();
            $ogTitle = is_single() ? get_post_title($post) : \Eventy::filter('aksara.site-title','Aksara');
            $ogDescription =  is_single() ? get_post_excerpt($post) : \Eventy::filter('aksara.site-description','Site Description');

            // get Image
            if( is_single() ) {
                $ogImage =  get_post_featured_image($post->id,'small') ;
                echo '<meta property="og:type" content="'.\Eventy::filter('aksara.post-type.og-site-type','article').'" />'."\n";
            }
            else {
                $ogImage = "";
            }

            echo view('post-type::partials.header-meta',compact('options','ogUrl','ogTitle','ogDescription','ogImage'))->render();
        });

        /**
         * custom-script-css
         */
        \Eventy::addAction('aksara.front-end.head',function(){

            $options = get_options('website_options', []);

            echo @$options['header_script'];
            echo @$options['header_css'];
        });

        \Eventy::addAction('aksara.front-end.footer',function(){

            $options = get_options('website_options', []);

            echo @$options['footer_script'];
            echo @$options['footer_css'];
        });

        /**
         * front-end-admin-toolbar
         */
        \Eventy::addAction('aksara.front-end.head',function(){
            if( !is_admin() && \Auth::check()) {
                aksara_enqueue_style(url("assets/modules-v2/post-type/css/admin-toolbar.min.css"));
            }
        });
        \Eventy::addAction('aksara.front-end.footer',function(){
            if( !is_admin() && \Auth::check()) {
                $adminMenus = \Config::get('aksara.admin-menu.toolbar-dropdown-menu',[]);

                $posts = get_current_aksara_query();
                $post = count($posts) != 0 ?  $posts[0] : false ;

                echo view('post-type::partials.header-admin-toolbar',compact('adminMenus','post'))->render();
            }
        });

        /**
         * query-filter
         */
        \Eventy::addFilter('aksara.post-type.front-end.template.query-args',function($args){

            if( \Auth::check() ) {
                $args['post_status'] = ['publish','draft'];
            }

            return $args;
        });

        /**
         * robots
         */
        \Eventy::addAction('aksara.routes.front_end',function(){
            \Route::get('robots.txt',function(){
                $options = get_options('website_options', []);

                $options['robots_txt'] = isset($options['robots_txt']) ? $options['robots_txt'] : false ;
                header('Content-Type: text/plain');
                if( $options['robots_txt'] ) {
                    echo "User-agent: *";
                    echo PHP_EOL ;
                    echo "Disallow: /admin/";
                }
                else {
                    echo "User-agent: *";
                    echo PHP_EOL ;
                    echo "\nDisallow: /";
                }

                die();
            });
        });

    }
}

