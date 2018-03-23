<?php
namespace Plugins\PostType\Repository;

use Plugins\PostType\Model\posts;

class PostRepository implements PostRepositoryInterface
{
    protected $post_type;

    public function get_total($posts=false, $postType = false)
    {
        $posts = clone $posts;

        if (!$postType) {
            $postType  = get_current_post_type();
        }

        if (!$posts) {
            throw new \Exception('posts object not set');
        }

        $posts = $posts->where('post_status', '<>', 'trash');

        if ($postType) {
            $posts->where('post_type', $postType);
        }

        return $posts->count();
    }

    public function get_total_publish($posts=false, $postType = false)
    {
        $posts = clone $posts;

        if (!$postType) {
            $postType  = get_current_post_type();
        }

        if (!$posts) {
            throw new \Exception('posts object not set');
        }

        $posts = $posts->where('post_status', 'publish');
        if ($postType) {
            $posts->where('post_type', $postType);
        }
        return $posts->count();
    }

    public function get_total_draft($posts=false, $postType = false)
    {
        $posts = clone $posts;
        if (!$postType) {
            $postType  = get_current_post_type();
        }

        if (!$posts) {
            throw new \Exception('posts object not set');
        }

        $posts = $posts->where('post_status', 'draft');
        if ($postType) {
            $posts->where('post_type', $postType);
        }

        return $posts->count();
    }

    public function get_total_pending($posts=false, $postType = false)
    {
        $posts = clone $posts;
        if (!$postType) {
            $postType  = get_current_post_type();
        }

        if (!$posts) {
            throw new \Exception('posts object not set');
        }

        $posts = $posts->where('post_status', 'pending');
        if ($postType) {
            $posts->where('post_type', $postType);
        }

        return $posts->count();
    }

    public function get_total_trash($posts=false, $postType = false)
    {
        $posts = clone $posts;

        if (!$postType) {
            $postType  = get_current_post_type();
        }

        if (!$posts) {
            throw new \Exception('posts object not set');
        }

        $posts = $posts->where('post_status', 'trash');
        if ($postType) {
            $posts->where('post_type', $postType);
        }

        return $posts->count();
    }
}
