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

    // $languageSwitcher = new \App\Modules\Plugins\AksaraMultiBas\LanguageSwitcher();
    // $languageSwitcher->setLanguageFromParam();
    // \App::singleton('App\Modules\Plugins\AksaraMultiBas\LanguageSwitcher', $languageSwitcher);


},200);

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
