<?php
namespace App\Modules\Plugins\PostType;
use \App\Aksara\Core\AdminMenu\AdminMenu as Menu;
use App\Modules\Plugins\PostType\Model\Taxonomy;

class Post
{

  function __construct()
  {
      \Eventy::addAction('aksara.routes.admin' , 'App\Modules\Plugins\PostType\Post@registerAdminRoutes');
  }

  function registerAdminRoutes()
  {
      $postTypes = \Config::get('aksara.post_type');

      foreach ( $postTypes as $postType)
      {
          \Route::resource($postType['route'], '\App\Modules\Plugins\PostType\Http\PostController',[
              'names' => [
                      'index' => 'admin.'.$postType['route'].'.index',
                      'create' => 'admin.'.$postType['route'].'.create',
                      'store' => 'admin.'.$postType['route'].'.store',
                      'edit' => 'admin.'.$postType['route'].'.edit',
                      'update' => 'admin.'.$postType['route'].'.update',
                      'destroy' => 'admin.'.$postType['route'].'.destroy'
                  ],
              'except' => [
                      'show'
                  ]
              ]);

          // \Route::get($postType['route'].'/{id}/destroy', ['as' => 'admin.'.$postType['route'].'.destroy', 'uses' =>'\App\Modules\Plugins\PostType\Http\PostController@destroy']);
          // \Route::get($postType['route'].'/{id}/delete_img', ['as' => 'admin.'.$postType['route'].'.delete_img', 'uses' =>'\App\Modules\Plugins\PostType\Http\PostController@delete_img']);
          \Route::get($postType['route'].'/{id}/restore', ['as' => 'admin.'.$postType['route'].'.restore', 'uses' =>'\App\Modules\Plugins\PostType\Http\PostController@restore']);
          \Route::get($postType['route'].'/{id}/trash', ['as' => 'admin.'.$postType['route'].'.trash', 'uses' =>'\App\Modules\Plugins\PostType\Http\PostController@trash']);

          $registeredTaxonomy = \Config::get('aksara.taxonomies');
        //   dd($registeredTaxonomy);
          if( isset($registeredTaxonomy[$postType['route']]))
          {
              foreach ($registeredTaxonomy[$postType['route']] as $taxonomy => $arg) {
                  \Route::get($postType['route'].'/'.$taxonomy.'/index', ['as' => 'admin.'.$postType['route'].'.'.$taxonomy.'.index', 'uses' =>'\App\Modules\Plugins\PostType\Http\TaxonomyController@index']);
                  \Route::get($postType['route'].'/'.$taxonomy.'/create', ['as' => 'admin.'.$postType['route'].'.'.$taxonomy.'.create', 'uses' =>'\App\Modules\Plugins\PostType\Http\TaxonomyController@create']);
                  \Route::post($postType['route'].'/'.$taxonomy.'/store', ['as' => 'admin.'.$postType['route'].'.'.$taxonomy.'.store', 'uses' =>'\App\Modules\Plugins\PostType\Http\TaxonomyController@store']);
                  \Route::get($postType['route'].'/'.$taxonomy.'/{id}/edit', ['as' => 'admin.'.$postType['route'].'.'.$taxonomy.'.edit', 'uses' =>'\App\Modules\Plugins\PostType\Http\TaxonomyController@edit']);
                  \Route::post($postType['route'].'/'.$taxonomy.'/{id}/update', ['as' => 'admin.'.$postType['route'].'.'.$taxonomy.'.update', 'uses' =>'\App\Modules\Plugins\PostType\Http\TaxonomyController@update']);
                  \Route::get($postType['route'].'/'.$taxonomy.'/{id}/destroy', ['as' => 'admin.'.$postType['route'].'.'.$taxonomy.'.destroy', 'uses' =>'\App\Modules\Plugins\PostType\Http\TaxonomyController@destroy']);
              }
          }
      }
  }

  // $labels = array(
  //       'name'                  => _x( 'Books', 'Post type general name', 'textdomain' ), --> done
  //       'singular_name'         => _x( 'Book', 'Post type singular name', 'textdomain' ),
  //       'menu_name'             => _x( 'Books', 'Admin Menu text', 'textdomain' ),
  //       'name_admin_bar'        => _x( 'Book', 'Add New on Toolbar', 'textdomain' ),
  //       'add_new'               => __( 'Add New', 'textdomain' ),
  //       'add_new_item'          => __( 'Add New Book', 'textdomain' ),
  //       'new_item'              => __( 'New Book', 'textdomain' ),
  //       'edit_item'             => __( 'Edit Book', 'textdomain' ),
  //       'view_item'             => __( 'View Book', 'textdomain' ),
  //       'all_items'             => __( 'All Books', 'textdomain' ),
  //       'search_items'          => __( 'Search Books', 'textdomain' ),
  //       'parent_item_colon'     => __( 'Parent Books:', 'textdomain' ),
  //       'not_found'             => __( 'No books found.', 'textdomain' ),
  //       'not_found_in_trash'    => __( 'No books found in Trash.', 'textdomain' ),
  //       'featured_image'        => _x( 'Book Cover Image', 'Overrides the “Featured Image” phrase for this post type. Added in 4.3', 'textdomain' ),
  //       'set_featured_image'    => _x( 'Set cover image', 'Overrides the “Set featured image” phrase for this post type. Added in 4.3', 'textdomain' ),
  //       'remove_featured_image' => _x( 'Remove cover image', 'Overrides the “Remove featured image” phrase for this post type. Added in 4.3', 'textdomain' ),
  //       'use_featured_image'    => _x( 'Use as cover image', 'Overrides the “Use as featured image” phrase for this post type. Added in 4.3', 'textdomain' ),
  //       'archives'              => _x( 'Book archives', 'The post type archive label used in nav menus. Default “Post Archives”. Added in 4.4', 'textdomain' ),
  //       'insert_into_item'      => _x( 'Insert into book', 'Overrides the “Insert into post”/”Insert into page” phrase (used when inserting media into a post). Added in 4.4', 'textdomain' ),
  //       'uploaded_to_this_item' => _x( 'Uploaded to this book', 'Overrides the “Uploaded to this post”/”Uploaded to this page” phrase (used when viewing media attached to a post). Added in 4.4', 'textdomain' ),
  //       'filter_items_list'     => _x( 'Filter books list', 'Screen reader text for the filter links heading on the post type listing screen. Default “Filter posts list”/”Filter pages list”. Added in 4.4', 'textdomain' ),
  //       'items_list_navigation' => _x( 'Books list navigation', 'Screen reader text for the pagination heading on the post type listing screen. Default “Posts list navigation”/”Pages list navigation”. Added in 4.4', 'textdomain' ),
  //       'items_list'            => _x( 'Books list', 'Screen reader text for the items list heading on the post type listing screen. Default “Posts list”/”Pages list”. Added in 4.4', 'textdomain' ),
  //   );
  //
  //   $args = array(
  //       'labels'             => $labels, --> done
  //       'public'             => true, @TODO
  //       'publicly_queryable' => true, @TODO
  //       'show_ui'            => true,
  //       'show_in_menu'       => true,
  //       'query_var'          => true,
  //       'route'               => 'book', -->done
  //       'capability_type'    => 'post',
  //       'has_archive'        => true, @TODO
  //       'hierarchical'       => false,
  //       'menu_position'      => null,
  //       'supports'           => array( 'title', 'editor', 'author', 'thumbnail', 'excerpt', 'comments' ),
  //   );
  //
    function registerPostType( $postType, $args)
    {
        $menu = new Menu();

        $registeredPostType = \Config::get('aksara.post_type');

        if( !$registeredPostType )
          $registeredPostType = [];

        $args = $this->parseDefaultArgs($postType, $args);

        $registeredPostType[$postType] = $args ;

        \Config::set( 'aksara.post_type', $registeredPostType);
        // string $pageTitle, string $menuTitle ,string  $routeName, $position = 0, string $icon = 'ti-pin-alt',  , string $capability ='
        $menu->addMenuPage($args['label']['name'], $args['label']['name'], 'admin.'.$args['route'].'.index' , 10, $args['icon'], $args['route'] );

        // Add For Index and Add New
        $menu->addSubMenuPage( 'admin.'.$args['route'].'.index', "Semua ".$args['label']['name'],"Semua ".$args['label']['name'],'admin.'.$args['route'].'.index');
        $menu->addSubMenuPage( 'admin.'.$args['route'].'.index', "Tambah ".$args['label']['name'],"Tambah ".$args['label']['name'],'admin.'.$args['route'].'.create');
    }

    function registerTaxonomy( $taxonomy, $postTypes = [], $args)
    {
        if( !is_array($postTypes) )
            $postTypes[] = $postTypes;

        if(!$taxonomy)
            return;

        $menu = new Menu();

        // check_taxonomy($postTypes, $taxonomy);
        Taxonomy::persistTaxonomy($taxonomy);

        $registeredTaxonomy = \Config::get('aksara.taxonomies',[]);

        // register post type to taxonomy
        foreach ($postTypes as $postType)
        {
            $registeredTaxonomy[$postType][$taxonomy] = $args ;
        }

        \Config::set( 'aksara.taxonomies', $registeredTaxonomy);

        // Add For Index and Add New
        foreach ($postTypes as $postType)
        {
            $menu->addSubMenuPage( 'admin.'.$postType.'.index', $args['label']['name'], $args['label']['name'], 'admin.'.$postType.'.'.$taxonomy.'.index');
        }

    }

  function getCurrentPostType()
  {
    $segments = \Request::segments();

    if( !isset( $segments[0] ))
      return false;

    if( $segments[0] == 'admin' && isset( $segments[1] ) )
    {
      return $this->getPostTypeFromSlug($segments[1]);
    }
    else if( isset( $segments[0] ) )
    {
      return $this->getPostTypeFromSlug($segments[0]);
    }

    return false;
  }

  // return post type from slug
  function getPostTypeFromSlug($slug)
  {
    $registeredPostType = \Config::get('aksara.post_type');

    foreach ( $registeredPostType as $post_type => $args )
    {
      if( $slug == $args['route'] )
        return $post_type;
    }

    return false;
  }

  function getCurrentPostTypeSlug()
  {
    $currentPostType = $this->getCurrentPostType();
    $registeredPostType = \Config::get('aksara.post_type');

    if( array_key_exists( $currentPostType, $registeredPostType ) )
    {
      return $registeredPostType[$currentPostType]['route'];
    }

    return false;

  }

  function getPostTypeArgs(  $key = false )
  {
    if( !$key )
      return false;

    $currentPostType = $this->getCurrentPostType();
    $registeredPostType = \Config::get('aksara.post_type');

    if( array_key_exists( $currentPostType, $registeredPostType ) )
    {
      $currentPostType = $registeredPostType[$currentPostType];

      return array_pull($currentPostType,$key);

    }

    return false;

  }

  function getCurrentTaxonomy()
  {
    $segments = \Request::segments();

    if( !isset( $segments[0] ))
      return false;

    if( $segments[0] == 'admin' && isset( $segments[1] ) && isset( $segments[2] ) )
    {
      return $this->getTaxonomyFromSlug($segments[1], $segments[2]);
    }

    return false;
  }

  function getTaxonomyFromSlug($postType, $taxo)
  {
    $registeredTaxonomy = \Config::get('aksara.taxonomy');

    foreach ( $registeredTaxonomy as $taxonomy => $args )
    {
        if($postType == $taxonomy)
        {
            foreach ($args as $key => $value) {
                if( $taxo == $key )
                return $key;
            }
        }
    }
    return false;
  }

  function getTaxonomyArgs(  $key = false )
  {
    if( !$key )
      return false;
    $currentPostType = $this->getCurrentPostType();
    $currentTaxonomy = $this->getCurrentTaxonomy();
    $registeredTaxonomy = \Config::get('aksara.taxonomy');

    if( isset($registeredTaxonomy[$currentPostType] ) )
    {

        if( isset($registeredTaxonomy[$currentPostType][$currentTaxonomy] ) )
        {
            $currentTaxonomyArg = $registeredTaxonomy[$currentPostType][$currentTaxonomy];
            return array_pull($currentTaxonomyArg, $key);

        }


    }

    return false;

  }

  function parseDefaultArgs($postType, $args)
  {
      if( !isset($args['label']) )
          throw new Exception('Missing label argument for registering post type '.$postType);

      if( !isset($args['public']) )
          $args['public'] = true;

      if( !isset($args['publicly_queryable']) )
          $args['publicly_queryable'] = true;

      if( !isset($args['route']) )
          $args['route'] = \aksara_slugify($postType);

      if( !isset($args['has_archive']) )
          $args['has_archive'] = true;

      if( !isset($args['supports']) || !is_array($args['supports']) )
          $args['supports'] = ['editor','thumbnail','title'];

      return $args;
  }

}
