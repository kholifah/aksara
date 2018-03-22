<?php

namespace Plugins\AksaraMultiBas\Providers;

use Illuminate\Support\ServiceProvider;

class MultiBasActionFilterServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap the application services.
     *
     * @return void
     */
    public function boot()
    {
        /**
         * table.php
         */

        // modify post ordering
        \Eventy::addAction('aksara.admin.init-completed', function () {
            $postTypes = \Config::get('aksara.post-type.post-types');
            $languages = get_registered_locales();

            foreach ($postTypes as $postType => $args) {
                \Eventy::addFilter('aksara.post-type.'.$postType.'.index.table.column', 'multibas_column', 1, 2);
                \Eventy::addAction('aksara.post-type.'.$postType.'.index.table.row', 'multibas_row', 1, 2);
            }
        });

        /**
         * query-filter.php
         */

        /*
         * Prevent translated content from showing up in post type table
         */
        \Eventy::addAction('aksara.admin.init-completed', function () {
            $postTypes = \Config::get('aksara.post-type.post-types');
            foreach ($postTypes as $postType => $args) {
                \Eventy::addFilter( 'aksara.post-type.'.$postType.'.index.query', 'multibas_table_index_exclude_translation', 1, 2);
            }
        });

        /*
         * Return all post only on the current language
         */
        \Eventy::addFilter('aksara.post-type.front-end.template.query', 'multibas_get_translated_post_frontpage');

        /*
         * Get post translation for homepage
         */
        \Eventy::addFilter('aksara.post-type.front-end.template.query-args', function($args) {

            // Return original post if the current locale is default OR there is no language defined
            if(is_default_multibas_locale() || !get_multibas_default_locale()) {
                return $args;
            }


            if( is_home() && isset($args['id']) ) {

                $locale = get_current_multibas_locale();
                $post = \App\Modules\Plugins\PostType\Model\Post::find($args['id']);
                $postTranslated = get_translated_post($post, $locale);

                if($postTranslated) {
                    $args['id'] = $postTranslated->id;
                }
            }

            return $args;
        },100,1);


        /*
         * Load pages only on default language on website options pages
         */
        \Eventy::addFilter('aksara.post-type.front-end.option.pages-query', 'multibas_table_index_exclude_option_pages');

        /**
         * metabox.php
         */
        \Eventy::addAction('aksara.init-completed', function () {
            $postTypes = \Config::get('aksara.post-type.post-types');

            foreach ($postTypes as $postType => $args) {
                add_meta_box('multibas', $postType, 'render_metabox_multibas', false, 'metabox-sidebar', 5);
            }
        });

        /**
         * route.php
         */
        \Eventy::addAction('aksara.init', function () {
            $countries = get_registered_locales();

            foreach ($countries as $country) {

                if($country['default']) {
                    continue;
                }

                \Eventy::addAction('aksara.post-type.permalink.search',
                    function($route, $routeName) use ($country) {
                        \Route::get( $country['language_code'].'/'.$route,
                            ['as' => $routeName.'.multibas-locale-'.$country['language_code'],
                            'uses' =>'\App\Modules\Plugins\PostType\Http\FrontEndController@serve']);
                }, 10, 2);
                \Eventy::addAction('aksara.post-type.permalink.home',
                    function($route, $routeName) use ($country) {
                        \Route::get( $country['language_code'].'/'.$route,
                            ['as' => $routeName.'.multibas-locale-'.$country['language_code'],
                            'uses' =>'\App\Modules\Plugins\PostType\Http\FrontEndController@serve']);
                }, 10, 2);
                \Eventy::addAction('aksara.post-type.permalink.archive-post-type',
                    function($route, $routeName) use ($country) {
                        \Route::get( $country['language_code'].'/'.$route,
                            ['as' => $routeName.'.multibas-locale-'.$country['language_code'],
                            'uses' =>'\App\Modules\Plugins\PostType\Http\FrontEndController@serve']);
                }, 10, 2);
                \Eventy::addAction('aksara.post-type.permalink.single',
                    function($route, $routeName) use ($country) {
                        \Route::get( $country['language_code'].'/'.$route,
                            ['as' => $routeName.'.multibas-locale-'.$country['language_code'], 'uses' =>'\App\Modules\Plugins\PostType\Http\FrontEndController@serve']);
                }, 10, 2);
                \Eventy::addAction('aksara.post-type.permalink.archive-taxonomy',
                    function($route, $routeName) use ($country) {
                        \Route::get( $country['language_code'].'/'.$route,
                            ['as' => $routeName.'.multibas-locale-'.$country['language_code'], 'uses' =>'\App\Modules\Plugins\PostType\Http\FrontEndController@serve']);
                }, 10, 2);
                \Eventy::addAction('aksara.post-type.permalink.archive-taxonomy-terms',
                    function($route, $routeName) use ($country) {
                        \Route::get( $country['language_code'].'/'.$route,
                            ['as' => $routeName.'.multibas-locale-'.$country['language_code'], 'uses' =>'\App\Modules\Plugins\PostType\Http\FrontEndController@serve']);
                }, 10, 2);
                \Eventy::addAction('aksara.post-type.permalink.catch-all',
                    function($route, $routeParamsFrontEnd) use ($country) {

                    $routeParamsFrontEnd['as'] = $routeParamsFrontEnd['as'].'.multibas-locale-'.$country['language_code'];
                    \Route::get( $country['language_code'].'/'.$route, $routeParamsFrontEnd);
                }, 10, 2);

            }

        });

        /**
         * permalink.php
         */
        \Eventy::addFilter('aksara.post-type.front-end.post-permalink.before',
            function($permalink, $post) {
            $translationLang = get_post_meta($post->id,'is_translation');

            if( $translationLang ) {
                return get_post_language($post).'/'.$permalink;
            }

            return $permalink;
        },100,2);

        /**
         * header-meta.php
         */
        /*
         * Add locale header tag
         */
        \Eventy::addAction('aksara.front-end.head',function(){
            $locales = get_registered_locales();

            if(sizeof($locales)==0) {
                return;
            }

            if(is_default_multibas_locale()) {
                echo '<link rel="canonical" href="'.url('/').'"/>'."\n";
            }
            else {
                echo '<link rel="canonical" href="'.url('/').get_current_multibas_locale().'"/>'."\n";
            }

            foreach ($locales as $locale) {

                if(is_default_multibas_locale($locale['language_code'])) {
                    echo '<link rel="alternate" hrefLang="'.$locale['language_code'].'" href="'.url('/').'"/>'."\n";
                }
                else {
                    echo '<link rel="alternate" hrefLang="'.$locale['language_code'].'" href="'.url('/'.$locale['language_code']).'"/>'."\n";
                }
            }
        });

    }

    /**
     * Register the application services.
     *
     * @return void
     */
    public function register()
    {
        //
    }
}
