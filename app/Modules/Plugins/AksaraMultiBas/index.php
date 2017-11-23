<?php
require __DIR__.'/action-filter/table.php';
require __DIR__.'/action-filter/query-filter.php';
require __DIR__.'/action-filter/metabox.php';
require __DIR__.'/action-filter/route.php';
require __DIR__.'/action-filter/permalink.php';


\Eventy::addAction('aksara.init', function () {
    $optionIndex = [
                    'page_title' => 'Multi Bahasa',
                    'menu_title' => 'Multi Bahasa',
                    'icon'       => 'ti-brush-alt',
                    'capability' => '',
                    'route'      => [
                                       'slug' => '/aksara-multibas-option',
                                       'args' => [
                                                    'as' => 'aksara-multibas-option',
                                                    'uses' => '\App\Modules\Plugins\AksaraMultiBas\Http\OptionController@index',
                                                  ],
                                       ]
                    ];

    add_admin_sub_menu_route('aksara-menu-options',$optionIndex);

    \App::singleton('App\Modules\Plugins\AksaraMultiBas\LocaleSwitcher', function(){
        $LocaleSwitcher = new \App\Modules\Plugins\AksaraMultiBas\LocaleSwitcher();
        $LocaleSwitcher->setCurrentLanguangeFromParam();
        return $LocaleSwitcher;
    });
},200);

/*
 * Set correct language for front-end controller
 */
\Eventy::addAction('aksara.post-type.front-end.before-query', function() {
    
    $languageSwitcher = \App::make('App\Modules\Plugins\AksaraMultiBas\LocaleSwitcher');
    $languageSwitcher->setCurrentLanguange();
});


\Eventy::addAction('aksara.routes.admin',function(){

    \Route::post('/aksara-multibas-option',[
                 'as' => 'aksara-multibas-option-save',
                 'uses' => '\App\Modules\Plugins\AksaraMultiBas\Http\OptionController@save',
               ]);

    \Route::get('/aksara-generate-translation/{postId}/{lang}',[
                 'as' => 'aksara-multibas-generate-translation',
                 'uses' => '\App\Modules\Plugins\AksaraMultiBas\Http\TranslationController@generate',
               ]);

});

\Eventy::addAction('aksara.post-type.post-controller.construct',function(){
        aksara_admin_enqueue_style(url("assets/modules/Plugins/AksaraMultiBas/css/flag-icon.min.css"), "flag-icon" , 25, true);
        aksara_admin_enqueue_style(url("assets/modules/Plugins/AksaraMultiBas/css/style.css"), "multibas" , 25, true);
});
