<?php
namespace Plugins\PostType;

use Carbon\Carbon;

class PostDateMetaBox
{
    public function render($post)
    {
        echo view('post-type::partials.metabox_post_date',
            compact('post'))->render();
    }

    public function save($post, $request)
    {
        $postDate = Carbon::parse($request->input('post_date'))->format('Y-m-d');
        $post->post_date = $postDate;
        $post->save();
    }
}

