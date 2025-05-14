<?php
namespace App\Repositories\Interfaces;

interface IClassRepository {
    public function getAll();
    public function getById($id);
}