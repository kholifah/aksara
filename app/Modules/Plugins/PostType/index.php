<?php
require __DIR__.'/action-filter/post-index-list.php';
require __DIR__.'/action-filter/set-post-terms.php';
require __DIR__.'/action-filter/base-metabox.php';
require __DIR__.'/action-filter/base-table.php';
require __DIR__.'/action-filter/add-capabilities.php';
require __DIR__.'/action-filter/post-filter.php';
require __DIR__.'/action-filter/page-template.php';
require __DIR__.'/action-filter/header-meta-tag.php';
require __DIR__.'/action-filter/custom-script-css.php';
require __DIR__.'/action-filter/front-end-admin-toolbar.php';
require __DIR__.'/action-filter/query-filter.php';
require __DIR__.'/action-filter/robots.php';
// return;
\App::singleton('post', function () {
    $post =  new \App\Modules\Plugins\PostType\Post();
    $post->enqueueAsset();
    return $post;
});
\App::singleton('App\Modules\Plugins\PostType\MetaBox', function () {
    return new \App\Modules\Plugins\PostType\MetaBox();
});
\App::singleton('App\Modules\Plugins\PostType\Media');
\App::singleton('App\Modules\Plugins\PostType\FrontEnd', function () {
    return new \App\Modules\Plugins\PostType\FrontEnd();
});
\App::singleton('App\Modules\Plugins\PostType\Permalink', function () {
    return new \App\Modules\Plugins\PostType\Permalink();
});
\App::bind('App\Modules\Plugins\PostType\Repository\PostRepositoryInterface', 'App\Modules\Plugins\PostType\Repository\PostRepository');
\App::bind('App\Modules\Plugins\PostType\Repository\TaxonomyRepositoryInterface', 'App\Modules\Plugins\PostType\Repository\TaxonomyRepository');
\App\Modules\Plugins\PostType\Model\Post::observe(new \App\Modules\Plugins\PostType\Model\PostSlugObserver());
\App\Modules\Plugins\PostType\Model\Term::observe(new \App\Modules\Plugins\PostType\Model\TermSlugObserver());
\Eventy::addAction('aksara.init', function () {
    $post = \App::make('post');
    // Register Post
    $argsPost = [
        'label' => [
            'name' => trans('menu.post')
        ],
        'route' => 'post',
        'icon' => 'ti-write'
    ];
    $post->registerPostType('post', $argsPost);
    // Register Page
    $argsPage = [
        'label' => [
            'name' => trans('menu.page')
        ],
        'has_archive'=>false,
        'route' => 'page',
        'icon' => 'ti-book'
    ];
    $post->registerPostType('page', $argsPage);
    // Register Taxonomy
    $argsCategory = [
        'label' => [
            'name' => trans('menu.category')
        ],
    ];
    $post->registerTaxonomy('category', ['post'], $argsCategory);
    $argsTag = [
        'label' => [
            'name' => trans('menu.tag')
        ],
    ];
    $post->registerTaxonomy('tag', ['post'], $argsTag);
    register_image_size('thumbnail',500,500,true,false);
    register_image_size('small',0,300);
    register_image_size('medium',0,500);
    register_image_size('large',0,900);
});
$media = \App::make('App\Modules\Plugins\PostType\Media');
$media->init();
// Init metabox action handler
$metabox = \App::make('App\Modules\Plugins\PostType\MetaBox');
$metabox->init();
$postTypeFrontEnd = \App::make('App\Modules\Plugins\PostType\FrontEnd');
$postTypeFrontEnd->init();
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
\Eventy::addAction('aksara.init-completed', function () {
    $optionIndex = [
        'page_title' => 'Website Option',
        'menu_title' => 'Website Option',
        'icon'       => 'ti-brush-alt',
        'capability' => '',
        'route'      => [
            'slug' => '/aksara-post-type-option',
            'args' => [
                'as' => 'aksara-post-type-option',
                'uses' => '\App\Modules\Plugins\PostType\Http\OptionController@index',
            ],
        ]
    ];
    add_admin_sub_menu_route('aksara-menu-options',$optionIndex);
    $route = \App::make('route');
    $optionSave = [
        'slug' => '/aksara-post-type-option-save',
        'method' => 'POST',
        'args' => [
            'as' => 'aksara-post-type-option-save',
            'uses' => '\App\Modules\Plugins\PostType\Http\OptionController@save',
        ],
    ];
    $route->addRoute($optionSave);
});
\Eventy::addAction('aksara.routes.before',function(){
    $permalink = \App::make('App\Modules\Plugins\PostType\Permalink');
    $permalink->init();
});