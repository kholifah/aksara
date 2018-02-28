<?php
namespace App\Modules\Plugins\PostType;

class Media
{
    public function init()
    {
        \Eventy::addAction('aksara.init', [$this,'registerPostType'], 20);
        // add route
        \Eventy::addAction('aksara.routes.admin', function () {
            \Route::get('media/upload', ['as'=>'admin.media.upload-view','uses'=>'\App\Modules\Plugins\PostType\Http\MediaController@mediaManager']);
            \Route::post('media/upload', ['as'=>'admin.media.upload','uses'=>'\App\Modules\Plugins\PostType\Http\MediaController@upload']);
        });
    }

    public function registerPostType()
    {
        $post = \App::make('post');

        // Register Post
        $argsPost = [
            'label' => [
                'name' => 'Media'
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

        aksara_admin_enqueue_script(url('assets/modules/Plugins/PostType/js/media-uploader.js'), 'aksara-media-uploader', 20, true);
    }
}
