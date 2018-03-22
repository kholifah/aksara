<?php

namespace Plugins\AksaraMultiBas\Providers;

use Illuminate\Support\ServiceProvider;

class MultiBasServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap the application services.
     *
     * @return void
     */
    public function boot()
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
                        'uses' => '\Plugins\AksaraMultiBas\Http\OptionController@index',
                    ],
                ]
            ];

            add_admin_sub_menu_route('aksara-menu-options',$optionIndex);

            \App::singleton('Plugins\AksaraMultiBas\LocaleSwitcher', function(){
                $LocaleSwitcher = new \Plugins\AksaraMultiBas\LocaleSwitcher();
                $LocaleSwitcher->setCurrentLanguangeFromParam();
                return $LocaleSwitcher;
            });
        },200);

        /*
         * Set correct language for front-end controller
         */
        \Eventy::addAction('aksara.post-type.front-end.before-query', function() {

            $languageSwitcher = \App::make('Plugins\AksaraMultiBas\LocaleSwitcher');
            $languageSwitcher->setCurrentLanguange();
        });


        \Eventy::addAction('aksara.routes.admin',function(){

            \Route::post('/aksara-multibas-option',[
                'as' => 'aksara-multibas-option-save',
                'uses' => '\Plugins\AksaraMultiBas\Http\OptionController@save',
            ]);

            \Route::get('/aksara-generate-translation/{postId}/{lang}',[
                'as' => 'aksara-multibas-generate-translation',
                'uses' => '\Plugins\AksaraMultiBas\Http\TranslationController@generate',
            ]);

        });

        \Eventy::addAction('aksara.post-type.post-controller.construct',function(){
            aksara_admin_enqueue_module_style('aksara-multi-bas',
                "css/flag-icon.min.css", "flag-icon" , 25, true);
            aksara_admin_enqueue_module_style('aksara-multi-bas',
                "css/style.css", "multibas" , 25, true);
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
