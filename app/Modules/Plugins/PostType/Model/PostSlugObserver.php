<?php
namespace App\Modules\Plugins\PostType\Model;

use App\Modules\Plugins\PostType\Model\Post;

class PostSlugObserver
{
    function saving($post)
    {
        $this->updateSlug($post);
    }

    function updating($post)
    {
        $this->updateSlug($post);
    }

    function updateSlug($post)
    {
        if( $post['post_slug'] !== null && $post['post_slug'] != '' )
        {
            $post['post_slug'] = str_slug($post['post_slug']);
        }
        else if( $post['post_title'] !== null && $post['post_title'] != '' )
        {
            $post['post_slug'] = str_slug($post['post_title']);
        }

        // No slug no post title, bail out
        if( $post['post_slug'] == '' )
            return;

        $counter = 0;
        $exist = true;

        while( $exist )
        {
            if( $counter != 0 )
            {
                $post['post_slug'] = $post['post_slug'].'-'.$counter;
            }

            $find = Post::where([
              'post_slug' => $post['post_slug'],
              'post_type' => $post['post_type']
            ])->first();

            //@TODO kalau sifatnya copy (autosave) perlu ditangani
            if( !$find || $find->id == $post['id'] )
                $exist = false;
            else
                $counter++;

        }
    }
}
