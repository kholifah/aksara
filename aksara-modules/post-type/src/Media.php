<?php
namespace Plugins\PostType;

class Media
{
    public function init()
    {
        \Eventy::addAction('aksara.init', [$this,'registerPostType'], 20);
        // add route
        \Eventy::addAction('aksara.routes.admin', function () {
            \Route::get('media/upload', ['as'=>'admin.media.upload-view','uses'=>'\Plugins\PostType\Http\MediaController@mediaManager']);
            \Route::post('media/upload', ['as'=>'admin.media.upload','uses'=>'\Plugins\PostType\Http\MediaController@upload']);
        });
    }

    public function registerPostType()
    {
        $post = \App::make('post');

        // Register Post
        $argsPost = [
            'label' => [
                'name' => __('post-type::default.media')
            ],
            'priority'=>20,
            'icon' => 'ti-gallery',
            'publicly_queryable'=>false,
            'supports' => []
        ];

        $post->registerPostType('media', $argsPost);
        remove_admin_sub_menu('admin.media.create');
    }

    public function enqueueScript()
    {
        // only embed one times
        if (\Config::get('aksara_media_uploader', false)) {
            return;
        }
        \Config::set('aksara_media_uploader', true);

        aksara_admin_enqueue_script(url('assets/modules-v2/post-type/js/media-uploader.js'), 'aksara-media-uploader', 20, true);
    }
}
