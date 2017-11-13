<?php
namespace App\Repositories;

/*
repository ini untuk repository pattern yang memiliki kesemua kebutuhan akan data yang akan digunakan
*/
interface RestFullRepositoryInterface
{
    public function selectAll();
    public function find($id);
}
