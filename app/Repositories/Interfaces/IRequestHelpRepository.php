<?php
namespace App\Repositories\Interfaces;

interface IRequestHelpRepository
{
    public function getAll();
     public function saveRequestHelp(array $data);
     
     public function deleteRequestHelp($id);
     public function paginate($perpage);
}