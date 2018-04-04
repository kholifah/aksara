<?php
namespace Plugins\PostType\Providers;

use Aksara\Providers\AbstractModuleProvider;

class PostTypeServiceProvider extends AbstractModuleProvider
{
    /**
     * Boot application services
     *
     * e.g, route, anything needs to be preload
     */
    public function safeBoot()
    {
        \PostType::boot();

        \Eventy::addAction('aksara.init', function () {

            // Register Post
            $argsPost = [
                'label' => [
                    'name' => __('post-type::default.post')
                ],
                'route' => 'post',
                'icon' => 'ti-write'
            ];

            \PostType::registerPostType('post', $argsPost);

            // Register Page
            $argsPage = [
                'label' => [
                    'name' => __('post-type::default.page')
                ],
                'has_archive'=>false,
                'route' => 'page',
                'icon' => 'ti-book'
            ];

            \PostType::registerPostType('page', $argsPage);

            // Register Taxonomy
            $argsCategory = [
                'label' => [
                    'name' => __('post-type::default.category')
                ],
            ];

            \PostType::registerTaxonomy('category', ['post'], $argsCategory);

            $argsTag = [
                'label' => [
                    'name' => __('post-type::default.tag')
                ],
            ];

            \PostType::registerTaxonomy('tag', ['post'], $argsTag);

            register_image_size('thumbnail',500,500,true,false);
            register_image_size('small',0,300);
            register_image_size('medium',0,500);
            register_image_size('large',0,900);

        });

        \Plugins\PostType\Model\Post::observe(new \Plugins\PostType\Model\PostSlugObserver());
        \Plugins\PostType\Model\Term::observe(new \Plugins\PostType\Model\TermSlugObserver());

        \Media::boot();

        // Init metabox action handler
        \Metabox::boot();

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
    public function safeRegister()
    {
        $this->app->singleton(
            \Plugins\PostType\Post\PostInterface::class,
            \Plugins\PostType\Post\Interactor::class
        );

        $this->app->bind('post', \Plugins\PostType\Post\PostInterface::class);

        $this->app->singleton(
            \Plugins\PostType\MetaboxRegistry\MetaboxRegistryInterface::class,
            \Plugins\PostType\MetaboxRegistry\Interactor::class
        );

        $this->app->bind(
            'metabox',
            \Plugins\PostType\MetaboxRegistry\MetaboxRegistryInterface::class
        );

        $this->app->singleton(
            \Plugins\PostType\Media\MediaInterface::class,
            \Plugins\PostType\Media\Interactor::class
        );

        $this->app->bind(
            'media',
            \Plugins\PostType\Media\MediaInterface::class
        );

        $this->app->bind(
            \Plugins\PostType\Repository\PostRepositoryInterface::class,
            \Plugins\PostType\Repository\PostRepository::class
        );

        $this->app->bind(
            Plugins\PostType\Repository\TaxonomyRepositoryInterface::class,
            Plugins\PostType\Repository\TaxonomyRepository::class
        );

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

