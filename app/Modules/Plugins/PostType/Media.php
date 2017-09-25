<?php
namespace App\Modules\Plugins\PostType;

class Media
{
    public function __construct()
    {
    }

    public function init()
    {
        \Eventy::addAction('aksara.init', [$this,'registerPostType'], 20);
        // add route
        \Eventy::addAction('aksara.routes.admin', function () {
            \Route::post('media-ajax-upload', ['as'=>'media-ajax-upload','uses'=>'\App\Modules\Plugins\PostType\Http\MediaAjaxUpload@handle']);
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

        aksara_admin_enqueue_script(url("assets/modules/Plugins/PostType/assets/js/media-upload.js"));
    }
}
