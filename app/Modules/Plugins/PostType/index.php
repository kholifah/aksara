<?php
require __DIR__.'/action-filter/post-index-list.php';
require __DIR__.'/action-filter//set-post-terms.php';
require __DIR__.'/action-filter/base-metabox.php';
require __DIR__.'/action-filter/base-table.php';
require __DIR__.'/action-filter/add-capabilities.php';
require __DIR__.'/vendor/autoload.php';

// return;
\App::singleton('post', function () {
    $post =  new \App\Modules\Plugins\PostType\Post();
    $post->enqueueAsset();
    return $post;
});

\App::singleton('App\Modules\Plugins\PostType\MetaBox', function () {
    return new \App\Modules\Plugins\PostType\MetaBox();
});

\App::singleton('App\Modules\Plugins\PostType\Media', function () {
    return new \App\Modules\Plugins\PostType\Media();
});

\App::bind('App\Modules\Plugins\PostType\Repository\PostRepositoryInterface', 'App\Modules\Plugins\PostType\Repository\PostRepository');
\App::bind('App\Modules\Plugins\PostType\Repository\TaxonomyRepositoryInterface', 'App\Modules\Plugins\PostType\Repository\TaxonomyRepository');

\App\Modules\Plugins\PostType\Model\Post::observe(new \App\Modules\Plugins\PostType\Model\PostSlugObserver());
\App\Modules\Plugins\PostType\Model\Term::observe(new \App\Modules\Plugins\PostType\Model\TermSlugObserver());

// Init media post type and all its glory
$media = \App::make('App\Modules\Plugins\PostType\Media');
$media->init();

// Init metabox action handler
$metabox = \App::make('App\Modules\Plugins\PostType\MetaBox');
$metabox->init();

\Eventy::addAction('aksara.init', function () {
    $post = \App::make('post');

    // Register Post
    $argsPost = [
    'label' => [
      'name' => 'Post'
    ],
    'route' => 'post',
    'icon' => 'ti-write'
  ];

    $post->registerPostType('post', $argsPost);

    // Register Page
    $argsPage = [
    'label' => [
      'name' => 'Page'
    ],
    'route' => 'page',
    'icon' => 'ti-book'
  ];

    $post->registerPostType('page', $argsPage);

    // Register Taxonomy
    $argsCategory = [
    'label' => [
      'name' => 'Category'
    ],
  ];

    $post->registerTaxonomy('category', ['post'], $argsCategory);

    $argsTag = [
    'label' => [
      'name' => 'Tag'
    ],
  ];

    $post->registerTaxonomy('tag', ['post'], $argsTag);

    register_image_size('thumbnail',500,500,true,false);
    register_image_size('small',0,500);
    register_image_size('medium',0,900);
    register_image_size('large',0,1400);
});

//@TODO pindah ke aksara_admin)enqueue
\Eventy::addAction('aksara.admin_head', function () {
    echo '<link href='.url("assets/admin/assets/plugins/datatables/jquery.dataTables.min.css").' rel="stylesheet" type="text/css"/>';
    echo '<link href='.url("assets/admin/assets/plugins/datatables/responsive.bootstrap.min.css").' rel="stylesheet" type="text/css"/>';
});

//@TODO pindah ke aksara_admin)enqueue
\Eventy::addAction('aksara.admin.footer', function () {
    // File JS / CSS masuk sini
    // @nanti dipindah ke resource

});
