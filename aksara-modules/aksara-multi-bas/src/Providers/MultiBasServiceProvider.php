<?php

namespace Plugins\AksaraMultiBas\Providers;

use Aksara\Providers\AbstractModuleProvider;

class MultiBasServiceProvider extends AbstractModuleProvider
{
    /**
     * Bootstrap the application services.
     *
     * @return void
     */
    protected function safeBoot()
    {
        \Eventy::addAction('aksara.init', function () {
            $optionIndex = [
                'page_title' => __('aksara-multi-bas::default.multi-lang'),
                'menu_title' => __('aksara-multi-bas::default.multi-lang'),
                'icon'       => 'ti-brush-alt',
                'capability' => '',
                'route'      => [
                    'slug' => '/aksara-multibas-option',
                    'args' => [
                        'as' => 'aksara-multibas-option',
                        'uses' => '\Plugins\AksaraMultiBas\Http\Controllers\OptionController@index',
                    ],
                ]
            ];

            add_admin_sub_menu_route('aksara-menu-options',$optionIndex);

            \LanguageSwitcher::boot();

        },200);

        /*
         * Set correct language for front-end controller
         */
        //TODO
        //middleware?
        \Eventy::addAction('aksara.post-type.front-end.before-query', function() {
            \LanguageSwitcher::setCurrentLanguange();
        });

        \Eventy::addAction('aksara.routes.admin',function(){

            \Route::post('/aksara-multibas-option',[
                'as' => 'aksara-multibas-option-save',
                'uses' => '\Plugins\AksaraMultiBas\Http\Controllers\OptionController@save',
            ]);

            \Route::get('/aksara-generate-translation/{postId}/{lang}',[
                'as' => 'aksara-multibas-generate-translation',
                'uses' => '\Plugins\AksaraMultiBas\Http\Controllers\TranslationController@generate',
            ]);

        });

        \Eventy::addAction('aksara.post-type.post-controller.construct',function(){
            multibas_admin_enqueue_style('css/flag-icon.min.css', 'flag-icon', 25, true);
            multibas_admin_enqueue_style('css/style.css', 'multibas', 25, true);
        });
    }

    /**
     * Register the application services.
     *
     * @return void
     */
    protected function safeRegister()
    {
        $this->app->bind(
            \Plugins\AksaraMultiBas\LocaleSwitcher\LocaleSwitcherInterface::class,
            \Plugins\AksaraMultiBas\LocaleSwitcher\Interactor::class
        );

        $this->app->bind(
            'locale_switcher',
            \Plugins\AksaraMultiBas\LocaleSwitcher\LocaleSwitcherInterface::class
        );

        $this->app->singleton(
            \Plugins\AksaraMultiBas\LanguageSwitcher\LanguageSwitcherInterface::class,
            \Plugins\AksaraMultiBas\LanguageSwitcher\Interactor::class
        );

        $this->app->bind(
            'language_switcher',
            \Plugins\AksaraMultiBas\LanguageSwitcher\LanguageSwitcherInterface::class
        );

        $this->app->bind(
            \Plugins\AksaraMultiBas\TranslationEngine\TranslationEngineInterface::class,
            \Plugins\AksaraMultiBas\TranslationEngine\Interactor::class
        );

        $this->app->bind(
            'translation_engine',
            \Plugins\AksaraMultiBas\TranslationEngine\TranslationEngineInterface::class
        );
    }
}
