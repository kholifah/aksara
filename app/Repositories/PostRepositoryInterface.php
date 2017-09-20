<?php

namespace App\Repositories;

interface PostRepositoryInterface 
{
    public function get_total();

    public function get_total_publish();

    public function get_total_draft();

    public function get_total_pending();

    public function get_total_trash();

    public function get_slug($data, $id);

    public function set_slug($data);
}
