<?php
namespace Plugins\PostType;

use Carbon\Carbon;
use Plugins\PostType\MetaboxRegistry\MetaboxBase;

class PostDateMetaBox extends MetaboxBase
{
    private $postType;

    public function __construct($postType)
    {
        $this->postType = $postType;
    }

    public function getId()
    {
        return 'post-date-metabox';
    }

    public function getLocation()
    {
        return 'metabox-sidebar';
    }

    public function getPostType()
    {
        return $this->postType;
    }

    public function getCallbackRender()
    {
        return function ($post) {
            echo view('post-type::partials.metabox_post_date',
                compact('post'))->render();
        };
    }

    public function getCallbackSave()
    {
        return function ($post, $request) {
            $postDate = Carbon::parse($request->input('post_date'))->format('Y-m-d');
            $post->post_date = $postDate;
            $post->save();
        };
    }
}

