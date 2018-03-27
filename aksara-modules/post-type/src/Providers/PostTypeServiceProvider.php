<?php
namespace Plugins\PostType\Providers;

use Illuminate\Support\ServiceProvider;

class PostTypeServiceProvider extends ServiceProvider
{
    /**
     * Boot application services
     *
     * e.g, route, anything needs to be preload
     */
    public function boot()
    {
        \Eventy::addAction('aksara.init', function () {
            $post = \App::make('post');

            // Register Post
            $argsPost = [
                'label' => [
                    'name' => __('post-type::default.post')
                ],
                'route' => 'post',
                'icon' => 'ti-write'
            ];

            $post->registerPostType('post', $argsPost);

            // Register Page
            $argsPage = [
                'label' => [
                    'name' => __('post-type::default.page')
                ],
                'has_archive'=>false,
                'route' => 'page',
                'icon' => 'ti-book'
            ];

            $post->registerPostType('page', $argsPage);

            // Register Taxonomy
            $argsCategory = [
                'label' => [
                    'name' => __('post-type::default.category')
                ],
            ];

            $post->registerTaxonomy('category', ['post'], $argsCategory);

            $argsTag = [
                'label' => [
                    'name' => __('post-type::default.tag')
                ],
            ];

            $post->registerTaxonomy('tag', ['post'], $argsTag);

            register_image_size('thumbnail',500,500,true,false);
            register_image_size('small',0,300);
            register_image_size('medium',0,500);
            register_image_size('large',0,900);

        });


        \Plugins\PostType\Model\Post::observe(new \Plugins\PostType\Model\PostSlugObserver());
        \Plugins\PostType\Model\Term::observe(new \Plugins\PostType\Model\TermSlugObserver());

        $media = \App::make('Plugins\PostType\Media');
        $media->init();

        // Init metabox action handler
        $metabox = \App::make('Plugins\PostType\MetaBox');
        $metabox->init();

        \PostTypeFrontEnd::boot();

        //
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
                'page_title' => __('post-type::default.web-option'),
                'menu_title' => __('post-type::default.web-option'),
                'icon'       => 'ti-brush-alt',
                'capability' => '',
                'route'      => [
                    'slug' => '/aksara-post-type-option',
                    'args' => [
                        'as' => 'aksara-post-type-option',
                        'uses' => '\Plugins\PostType\Http\OptionController@index',
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
                    'uses' => '\Plugins\PostType\Http\OptionController@save',
                ],
            ];

            $route->addRoute($optionSave);
        });

        \Eventy::addAction('aksara.routes.before',function(){
            \Permalink::boot();
        });

    }

    /**
     * Register bindings in the container.
     *
     * @return void
     */
    public function register()
    {
        \App::singleton('post', function () {
            $post =  new \Plugins\PostType\Post();
            $post->enqueueAsset();
            return $post;
        });

        \App::singleton('Plugins\PostType\MetaBox', function () {
            return new \Plugins\PostType\MetaBox();
        });

        \App::singleton('Plugins\PostType\Media');

        \App::bind('Plugins\PostType\Repository\PostRepositoryInterface',
            'Plugins\PostType\Repository\PostRepository');

        \App::bind('Plugins\PostType\Repository\TaxonomyRepositoryInterface',
            'Plugins\PostType\Repository\TaxonomyRepository');

        $this->app->bind(
            \Plugins\PostType\MediaUpload\MediaUploadInterface::class,
            \Plugins\PostType\MediaUpload\Interactor::class
        );

        $this->app->bind(
            \Plugins\PostType\Permalink\PermalinkInterface::class,
            \Plugins\PostType\Permalink\Interactor::class
        );

        $this->app->bind(
            'permalink',
            \Plugins\PostType\Permalink\PermalinkInterface::class
        );

        $this->app->bind(
            \Plugins\PostType\FrontEnd\FrontEndInterface::class,
            \Plugins\PostType\FrontEnd\Interactor::class
        );

        $this->app->bind(
            'posttype_frontend',
            \Plugins\PostType\FrontEnd\FrontEndInterface::class
        );

    }
}

