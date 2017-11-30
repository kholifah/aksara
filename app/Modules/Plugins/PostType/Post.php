<?php
namespace App\Modules\Plugins\PostType;

use \App\Aksara\Core\AdminMenu\AdminMenu as Menu;
use App\Modules\Plugins\PostType\Model\Taxonomy;

class Post
{
    public function __construct()
    {
        \Eventy::addAction('aksara.routes.admin', 'App\Modules\Plugins\PostType\Post@registerAdminRoutes');
    }

    public function enqueueAsset()
    {
        aksara_admin_enqueue_script(url('assets/modules/Plugins/PostType/js/post-type.js'), 'aksara-post-type', 20, true);
    }

    public function registerAdminRoutes()
    {
        $postTypes = \Config::get('aksara.post-type.post-types');

        foreach ($postTypes as $postType => $postTypeArgs) {
            \Route::resource($postTypeArgs['route'], '\App\Modules\Plugins\PostType\Http\PostController', [
              'names' => [
                      'index' => 'admin.'.$postTypeArgs['route'].'.index',
                      'create' => 'admin.'.$postTypeArgs['route'].'.create',
                      'store' => 'admin.'.$postTypeArgs['route'].'.store',
                      'edit' => 'admin.'.$postTypeArgs['route'].'.edit',
                      'update' => 'admin.'.$postTypeArgs['route'].'.update',
                  ],
              'except' => [
                      'show', 'destroy'
                  ]
              ]);            

            // @TODO rename route to post-type.admin.[$post-type].action
            \Route::get($postTypeArgs['route'].'/{id}/destroy', ['as' => 'admin.'.$postTypeArgs['route'].'.destroy', 'uses' =>'\App\Modules\Plugins\PostType\Http\PostController@destroy']);
            \Route::get($postTypeArgs['slug'].'/{id}/restore', ['as' => 'admin.'.$postTypeArgs['slug'].'.restore', 'uses' =>'\App\Modules\Plugins\PostType\Http\PostController@restore']);
            \Route::get($postTypeArgs['slug'].'/{id}/trash', ['as' => 'admin.'.$postTypeArgs['slug'].'.trash', 'uses' =>'\App\Modules\Plugins\PostType\Http\PostController@trash']);

            $registeredTaxonomies = \Config::get('aksara.post-type.taxonomies');

            foreach ($registeredTaxonomies as $taxonomy => $taxonomyArgs) {
                if (in_array($postType, $taxonomyArgs['post_type'])) {
                    // @TODO rename route to post-type.admin.[$post-type].[$taxonomy].action
                    \Route::get($postTypeArgs['route'].'/'.$taxonomy.'/index', ['as' => 'admin.'.$postTypeArgs['route'].'.'.$taxonomy.'.index', 'uses' =>'\App\Modules\Plugins\PostType\Http\TaxonomyController@index']);
                    \Route::get($postTypeArgs['route'].'/'.$taxonomy.'/create', ['as' => 'admin.'.$postTypeArgs['route'].'.'.$taxonomy.'.create', 'uses' =>'\App\Modules\Plugins\PostType\Http\TaxonomyController@create']);
                    \Route::post($postTypeArgs['route'].'/'.$taxonomy.'/store', ['as' => 'admin.'.$postTypeArgs['route'].'.'.$taxonomy.'.store', 'uses' =>'\App\Modules\Plugins\PostType\Http\TaxonomyController@store']);
                    \Route::get($postTypeArgs['route'].'/'.$taxonomy.'/{id}/edit', ['as' => 'admin.'.$postTypeArgs['route'].'.'.$taxonomy.'.edit', 'uses' =>'\App\Modules\Plugins\PostType\Http\TaxonomyController@edit']);
                    \Route::post($postTypeArgs['route'].'/'.$taxonomy.'/{id}/update', ['as' => 'admin.'.$postTypeArgs['route'].'.'.$taxonomy.'.update', 'uses' =>'\App\Modules\Plugins\PostType\Http\TaxonomyController@update']);
                    \Route::get($postTypeArgs['route'].'/'.$taxonomy.'/{id}/destroy', ['as' => 'admin.'.$postTypeArgs['route'].'.'.$taxonomy.'.destroy', 'uses' =>'\App\Modules\Plugins\PostType\Http\TaxonomyController@destroy']);
                }
            }
        }
    }

    // $labels = array(
    //       'name'                  => _x( 'Books', 'Post type general name', 'textdomain' ), --> done
    //   );
    //
    //   $args = array(
    //       'labels'             => $labels, --> done
    //       'public'             => true, @TODO
    //       'route'               => 'book', -->don
    //       'has_archive'        => true, @TODO
    //       'public'             => false, @TODO
    //       'publicly_queryable' => false, @TODO
    //       'ui'                 => true, @TODO
    //       'supports'           => ['editor','thumbnail','title'], --> done
    //       'priority'           => 20, --> done
    //   );
    //
    public function registerPostType($postType, $args)
    {
        $menu = new Menu();

        $registeredPostType = \Config::get('aksara.post-type.post-types');

        if (!$registeredPostType) {
            $registeredPostType = [];
        }

        $args = $this->parseDefaultArgs($postType, $args);

        $registeredPostType[$postType] = $args ;

        \Config::set('aksara.post-type.post-types', $registeredPostType);
        // string $pageTitle, string $menuTitle ,string  $routeName, $position = 0, string $icon = 'ti-pin-alt',  , string $capability ='
        $menu->addMenuPage($args['label']['name'], $args['label']['name'], 'admin.'.$args['route'].'.index', $args['priority'], $args['icon'], $args['capability']);

        // Add For Index and Add New
        $menu->addSubMenuPage('admin.'.$args['route'].'.index', "Semua ".$args['label']['name'], "Semua ".$args['label']['name'], 'admin.'.$args['route'].'.index');
        $menu->addSubMenuPage('admin.'.$args['route'].'.index', "Tambah ".$args['label']['name'], "Tambah ".$args['label']['name'], 'admin.'.$args['route'].'.create');
    }

    public function parseDefaultArgs($postType, $args)
    {
        if (!isset($args['label'])) {
            throw new Exception('Missing label argument for registering post type '.$postType);
        }

        if (!isset($args['public'])) {
            $args['public'] = true;
        }

        if (!isset($args['publicly_queryable'])) {
            $args['publicly_queryable'] = true;
        }

        if (!isset($args['route'])) {
            $args['route'] = \aksara_slugify($postType);
        }

        if (!isset($args['capability'])) {
            $args['capability'] = '';
        }
        //@TODO rename route to slug

        if (!isset($args['has_archive'])) {
            $args['has_archive'] = true;
        }

        if (!isset($args['supports']) || !is_array($args['supports'])) {
            $args['supports'] = ['editor','thumbnail','title'];
        }

        if (!isset($args['priority']) || !is_int($args['priority'])) {
            $args['priority'] = 20;
        }

        $args['slug'] = $args['route'];
        $args['slug_plural'] = $args['slug'].'s';
        $args['id'] = $postType;

        return $args;
    }

    /*
     *
     * $argsCategory = [
     *    'label' => [
     *      'name' => 'Category'
     *    ],
     *  ];
     *
     */
    public function registerTaxonomy($taxonomy, $postTypes = [], $args)
    {

        //@TODO convert default args

        if (!is_array($postTypes)) {
            $postTypes[] = $postTypes;
        }

        if (!$taxonomy) {
            return;
        }

        $menu = new Menu();

        // check_taxonomy($postTypes, $taxonomy);
        Taxonomy::persistTaxonomy($taxonomy);

        $registeredTaxonomy = \Config::get('aksara.post-type.taxonomies', []);

        if (!isset($registeredTaxonomy[$taxonomy])) {
            $registeredTaxonomy[$taxonomy] = [];
        }

        $args = $this->parseTaxonomyDefaultArgs($taxonomy, $args);

        $registeredTaxonomy[$taxonomy] = $args;

        // register post type to taxonomy
        foreach ($postTypes as $postType) {
            array_push($registeredTaxonomy[$taxonomy]['post_type'], $postType);
        }

        \Config::set('aksara.post-type.taxonomies', $registeredTaxonomy);

        // Add For Index and Add New
        foreach ($postTypes as $postType) {
            $menu->addSubMenuPage('admin.'.$postType.'.index', $args['label']['name'], $args['label']['name'], 'admin.'.$postType.'.'.$taxonomy.'.index');
        }
    }


    public function parseTaxonomyDefaultArgs($taxonomy, $args)
    {
        if (!isset($args['label'])) {
            throw new Exception('Missing label argument for registering taxonomy '.$taxonomy);
        }

        if (!isset($args['capability'])) {
            $args['capability'] = '';
        }
        //@TODO rename route to slug

        if (!isset($args['has_archive'])) {
            $args['has_archive'] = true;
        }

        if (!isset($args['priority']) || !is_int($args['priority'])) {
            $args['priority'] = 20;
        }

        if (!isset($args['slug']) ) {
            $args['slug'] = $taxonomy;
        }

        if (!isset($args['post_type'])) {
            $args['post_type'] = [];
        }

        $args['id'] = $taxonomy;

        return $args;
    }

    public function addPostTypeToTaxonomy($taxonomy, $postType)
    {
        $registeredTaxonomy = \Config::get('aksara.post-type.taxonomies', []);

        if (!\Config::get('aksara.post-type.post-types.'.$postType, false)) {
            throw new \Exception('Post Type '.$postType.' not registered');
        }

        $registeredTaxonomy = \Config::get('aksara.post-type.taxonomies');


        if (isset($registeredTaxonomy[$taxonomy])) {
            // add new post type to existing taxonomy


            array_push($registeredTaxonomy[$taxonomy]['post_type'], $postType);
            // menu
            $menu = new Menu();
            $menu->addSubMenuPage('admin.'.$postType.'.index', $registeredTaxonomy[$taxonomy]['label']['name'], $registeredTaxonomy[$taxonomy]['label']['name'], 'admin.'.$postType.'.'.$taxonomy.'.index');

            \Config::set('aksara.post-type.taxonomies', $registeredTaxonomy);
        } else {
            throw new \Exception('Taxonomy '.$taxonomy.' is not registered yet');
        }
    }

    // public function getPermalink($post)
    // {
    //     if(!$post) {
    //         return false;
    //     }
    //     $postPermalink = $this->getPermalinkStructure($post).'/'.$post->post_slug;
    //     return \Eventy::filter('aksara.post-type.front-end.post-permalink',$postPermalink,$post);
    // }
    //
    // public function getPermalinkStructure($post)
    // {
    //     if(!$post)
    //         return false;
    //
    //     if( $post->post_type == 'post' || $post->post_type == 'page' ) {
    //         $permalinkStructure =  url('');
    //     }
    //     else {
    //         $postTypeSlug = get_post_type_args('slug',$post->post_type);
    //
    //         $permalinkStructure =  url('/'.$postTypeSlug);
    //     }
    //
    //     return \Eventy::filter('aksara.post-type.front-end.post-permalink-structure',$permalinkStructure,$post);
    // }

    public function getCurrentPostType()
    {
        $post = get_current_post();

        if( @$post->id ) {
            return $post->post_type;
        }

        $routeName = \Request::route()->getName();
        // dd(strpos($routeName, 'admin.'));

        if ( $this->getPostTypeFromRoute('admin.') ) {
            return $this->getPostTypeFromRoute('admin.');
        }
        elseif( $this->getPostTypeFromRoute('aksara.post-type.front-end.single.') ) {
            return $this->getPostTypeFromRoute('aksara.post-type.front-end.single.');
        }
        elseif( $this->getPostTypeFromRoute('aksara.post-type.front-end.archive-post-type.') ) {
            return $this->getPostTypeFromRoute('aksara.post-type.front-end.archive-post-type.');
        }

        return false;
    }

    // return post type from slug
    public function getPostTypeFromRoute($delimiter = false)
    {
        if( !$delimiter )
            return $this->getCurrentPostType();

        $routeName = \Request::route()->getName();
        $postType = substr($routeName, strpos($routeName, $delimiter) + strlen($delimiter));


        if( strpos($postType, ".") !== false )
            $postType = substr($postType, 0, strpos($postType, "."));

        $postTypes = \Config::get('aksara.post-type.post-types',[]);


        $slugs = array_pluck($postTypes,'slug');
        $slugPlurals = array_pluck($postTypes,'slug_plural');


        if( array_search($postType,$slugs) !== false ) {
            return array_keys($postTypes)[array_search($postType,$slugs)];
        }
        if( array_search($postType,$slugPlurals) !== false) {
            return array_keys($postTypes)[array_search($postType,$slugPlurals)];
        }

        return false;


    }

    // return taxonomy from route
    public function getTaxonomyFromRoute($delimiter = false)
    {
        if( !$delimiter )
            return $this->getCurrentTaxonomy();

        $routeName = \Request::route()->getName();
        $taxonomy = substr($routeName, strpos($routeName, $delimiter) + strlen($delimiter));

        if( strpos($taxonomy, ".") !== false )
            $taxonomy = substr($taxonomy, 0, strpos($taxonomy, "."));

        $taxonomies = \Config::get('aksara.post-type.taxonomies',[]);

        if( !isset($taxonomies[$taxonomy]) )
            return false;

        return $taxonomy;
    }

    public function getPostTypeArgs($key = false)
    {
        if (!$key) {
            return false;
        }

        $registeredPostType = \Config::get('aksara.post-type.post-types');

        if (isset($registeredPostType[$key])) {
            return $registeredPostType[$key];
        }

        return false;
    }

    public function getCurrentTaxonomy()
    {

        $routeName = \Request::route()->getName();
        // dd(strpos($routeName, 'admin.'));

        if ( $this->getTaxonomyFromRoute('archive-taxonomy.') ) {
            return $this->getTaxonomyFromRoute('archive-taxonomy.');
        }

        $segments = \Request::segments();

        if (!isset($segments[0])) {
            return false;
        }

        if ($segments[0] == 'admin' && isset($segments[1]) && isset($segments[2])) {
            return $this->getTaxonomyFromSlug($segments[2]);
        }

        return false;
    }

    public function getTaxonomyFromSlug($taxonomy)
    {
        $registeredTaxonomy = \Config::get('aksara.post-type.taxonomies');

        if (isset($registeredTaxonomy[$taxonomy])) {
            return $taxonomy;
        }

        return false;
    }

    public function getTaxonomyArgs($taxonomy = false)
    {
        if (!$taxonomy) {
            return false;
        }

        $registerTaxonomies = \Config::get('aksara.post-type.taxonomies');


        if (!isset($registerTaxonomies[$taxonomy])) {
            return false;
        }

        return $registerTaxonomies[$taxonomy];
    }
}
