<?php

namespace App\Repositories;

use App\Modules\Plugins\PostType\Model\Post;

class PostRepository implements PostRepositoryInterface {

    protected $post_type;

    public function __construct() {
        $this->post_type = get_current_post_type();
    }

    public function get_total()
    {
        $post = Post::where('post_status', '<>', 'trash');

        if( $this->post_type )
          $post->where('post_type', $this->post_type);

        return $post->count();;
    }

    public function get_total_publish()
    {
        $post = Post::where('post_status', 'publish');
        if( $this->post_type )
          $post->where('post_type', $this->post_type);
        return $post->count();
    }

    public function get_total_draft()
    {
        $post = Post::where('post_status', 'draft');
        if( $this->post_type )
          $post->where('post_type', $this->post_type);

        return $post->count();
    }

    public function get_total_pending()
    {
        $post = Post::where('post_status', 'pending');
        if( $this->post_type )
          $post->where('post_type', $this->post_type);
        return $post->count();
    }

    public function get_total_trash()
    {
        $post = Post::where('post_status', 'trash');
        if( $this->post_type )
          $post->where('post_type', $this->post_type);
        return $post->count();
    }

    public function get_slug($data, $id = FALSE)
    {
        $post = Post::where('post_slug', $data);
        if( $this->post_type )
            $post->where('post_type', $this->post_type);
        if( $id )
            $post->where('id', '<>', $id);
        if($post->count())
        {
            $slug = $this->set_slug($data);
            $data = $this->get_slug($slug, $id);
        } else {
            $data = $data;
        }
        return $data;
    }

    public function set_slug($data)
    {
        if (strpos($data, '-') !== false)
            $s = explode('-', $data);
        else
            $s = [$data];
        $last = (int)$s[(count($s) - 1)];
        if($last)
        {
            $slug = '';
            for($i = 0; $i < count($s); $i++)
            {
                if($i == 0)
                    $slug = $s[$i];
                else if($i == (count($s)-1))
                    $slug = $slug.'-'.($last + 1);
                else
                    $slug = $slug.'-'.$s[$i];
            }
        } else {
            $slug = $data.'-1';
        }
        return $slug;
    }

}
