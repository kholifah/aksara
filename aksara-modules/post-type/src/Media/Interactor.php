<?php
namespace Plugins\PostType\Media;

class Interactor implements MediaInterface
{
    public function boot()
    {
        \Eventy::addAction('aksara.init', function () {
            $this->registerPostType();
        }, 20);
        // add route
        \Eventy::addAction('aksara.routes.admin', function () {
            \Route::get('media/upload', ['as'=>'admin.media.upload-view','uses'=>'\Plugins\PostType\Http\MediaController@mediaManager']);
            \Route::post('media/upload', ['as'=>'admin.media.upload','uses'=>'\Plugins\PostType\Http\MediaController@upload']);
        });
    }

    private function registerPostType()
    {
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

        \PostType::registerPostType('media', $argsPost);
        remove_admin_sub_menu('admin.media.create');
    }

    public function enqueueScript()
    {
        // only embed one times
        if (\Config::get('aksara_media_uploader', false)) {
            return;
        }
        \Config::set('aksara_media_uploader', true);

        aksara_admin_enqueue_module_script('post-type', '/js/media-uploader.js', 'aksara-media-uploader', 20, true);
    }
}
