<?php
namespace App\Modules\Plugins\PostType\Repository;

interface PostRepositoryInterface
{
    public function get_total( $post );

    public function get_total_publish( $post );

    public function get_total_draft( $post );

    public function get_total_pending(  $post );

    public function get_total_trash( $post );

}
