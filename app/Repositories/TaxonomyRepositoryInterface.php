<?php

namespace App\Repositories;

interface TaxonomyRepositoryInterface  
{
    public function get_slug($data, $id);

    public function set_slug($data);
}
