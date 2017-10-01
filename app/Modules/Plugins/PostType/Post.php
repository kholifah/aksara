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
        aksara_admin_enqueue_script(url('assets/modules/Plugins/PostType/js/post-type.js'),'aksara-post-type',5,true);
    }

    public function registerAdminRoutes()
    {
        $postTypes = \Config::get('aksara.post_type');

        foreach ($postTypes as $postType => $postTypeArgs) {
            \Route::resource($postTypeArgs['route'], '\App\Modules\Plugins\PostType\Http\PostController', [
              'names' => [
                      'index' => 'admin.'.$postTypeArgs['route'].'.index',
                      'create' => 'admin.'.$postTypeArgs['route'].'.create',
                      'store' => 'admin.'.$postTypeArgs['route'].'.store',
                      'edit' => 'admin.'.$postTypeArgs['route'].'.edit',
                      'update' => 'admin.'.$postTypeArgs['route'].'.update',
                      'destroy' => 'admin.'.$postTypeArgs['route'].'.destroy'
                  ],
              'except' => [
                      'show'
                  ]
              ]);

            // \Route::get($postType['route'].'/{id}/destroy', ['as' => 'admin.'.$postType['route'].'.destroy', 'uses' =>'\App\Modules\Plugins\PostType\Http\PostController@destroy']);
            // \Route::get($postType['route'].'/{id}/delete_img', ['as' => 'admin.'.$postType['route'].'.delete_img', 'uses' =>'\App\Modules\Plugins\PostType\Http\PostController@delete_img']);
            \Route::get($postTypeArgs['route'].'/{id}/restore', ['as' => 'admin.'.$postTypeArgs['route'].'.restore', 'uses' =>'\App\Modules\Plugins\PostType\Http\PostController@restore']);
            \Route::get($postTypeArgs['route'].'/{id}/trash', ['as' => 'admin.'.$postTypeArgs['route'].'.trash', 'uses' =>'\App\Modules\Plugins\PostType\Http\PostController@trash']);

            $registeredTaxonomies = \Config::get('aksara.taxonomies');

            foreach ($registeredTaxonomies as $taxonomy => $taxonomyArgs) {
                if (in_array($postType, $taxonomyArgs['post_type'])) {
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

        $registeredPostType = \Config::get('aksara.post_type');

        if (!$registeredPostType) {
            $registeredPostType = [];
        }

        $args = $this->parseDefaultArgs($postType, $args);

        $registeredPostType[$postType] = $args ;

        \Config::set('aksara.post_type', $registeredPostType);
        // string $pageTitle, string $menuTitle ,string  $routeName, $position = 0, string $icon = 'ti-pin-alt',  , string $capability ='
        $menu->addMenuPage($args['label']['name'], $args['label']['name'], 'admin.'.$args['route'].'.index', $args['priority'], $args['icon'], $args['route']);

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

        if (!isset($args['has_archive'])) {
            $args['has_archive'] = true;
        }

        if (!isset($args['supports']) || !is_array($args['supports'])) {
            $args['supports'] = ['editor','thumbnail','title'];
        }

        if (!isset($args['priority']) || !is_int($args['priority'])) {
            $args['priority'] = 10;
        }

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

        $registeredTaxonomy = \Config::get('aksara.taxonomies', []);

        if (!isset($registeredTaxonomy[$taxonomy])) {
            $registeredTaxonomy[$taxonomy] = [];
        }

        $registeredTaxonomy[$taxonomy] = $args;

        if (!isset($registeredTaxonomy[$taxonomy]['post_type'])) {
            $registeredTaxonomy[$taxonomy]['post_type'] = [];
        }

        if (!isset($registeredTaxonomy[$taxonomy]['slug'])) {
            $registeredTaxonomy[$taxonomy]['slug'] = $taxonomy;
        }

        $registeredTaxonomy[$taxonomy]['id'] = $taxonomy;

        // register post type to taxonomy
        foreach ($postTypes as $postType) {
            array_push($registeredTaxonomy[$taxonomy]['post_type'], $postType);
        }

        \Config::set('aksara.taxonomies', $registeredTaxonomy);

        // Add For Index and Add New
        foreach ($postTypes as $postType) {
            $menu->addSubMenuPage('admin.'.$postType.'.index', $args['label']['name'], $args['label']['name'], 'admin.'.$postType.'.'.$taxonomy.'.index');
        }
    }

    public function addPostTypeToTaxonomy($taxonomy, $postType)
    {
        $registeredTaxonomy = \Config::get('aksara.taxonomies', []);

        if (!\Config::get('aksara.post_type.'.$postType, false)) {
            throw new \Exception('Post Type '.$postType.' not registered');
        }

        $registeredTaxonomy = \Config::get('aksara.taxonomies');

        if (isset($registeredTaxonomy,$taxonomy)) {
            // add new post type to existing taxonomy
            array_push($registeredTaxonomy[$taxonomy]['post_type'], $postType);
            // menu
            $menu = new Menu();
            $menu->addSubMenuPage('admin.'.$postType.'.index', $registeredTaxonomy[$taxonomy]['label']['name'], $registeredTaxonomy[$taxonomy]['label']['name'], 'admin.'.$postType.'.'.$taxonomy.'.index');

            \Config::set('aksara.taxonomies', $registeredTaxonomy);
        } else {
            throw new \Exception('Taxonomy '.$taxonomy.' is not registered yet');
        }
    }

    public function getCurrentPostType()
    {
        $segments = \Request::segments();

        if (!isset($segments[0])) {
            return false;
        }

        if ($segments[0] == 'admin' && isset($segments[1])) {
            return $this->getPostTypeFromSlug($segments[1]);
        } elseif (isset($segments[0])) {
            return $this->getPostTypeFromSlug($segments[0]);
        }

        return false;
    }

    // return post type from slug
    public function getPostTypeFromSlug($slug)
    {
        $registeredPostType = \Config::get('aksara.post_type');

        foreach ($registeredPostType as $post_type => $args) {
            if ($slug == $args['route']) {
                return $post_type;
            }
        }

        return false;
    }

    public function getCurrentPostTypeSlug()
    {
        $currentPostType = $this->getCurrentPostType();
        $registeredPostType = \Config::get('aksara.post_type');

        if (array_key_exists($currentPostType, $registeredPostType)) {
            return $registeredPostType[$currentPostType]['route'];
        }

        return false;
    }

    public function getPostTypeArgs($key = false)
    {
        if (!$key) {
            return false;
        }

        $registeredPostType = \Config::get('aksara.post_type');

        if (isset($registeredPostType[$key])) {
            return $registeredPostType[$key];
        }

        return false;
    }

    public function getCurrentTaxonomy()
    {
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
        $registeredTaxonomy = \Config::get('aksara.taxonomies');

        if (isset($registeredTaxonomy[$taxonomy])) {
            return $taxonomy;
        }

        return false;
    }

    public function getTaxonomyArgs($key = false)
    {
        if (!$key) {
            return false;
        }

        $currentTaxonomy = $this->getCurrentTaxonomy();
        $registerTaxonomies = \Config::get('aksara.taxonomies');

        if (!isset($registerTaxonomies[$key])) {
            return false;
        }

        return $registerTaxonomies[$key];
    }
}
