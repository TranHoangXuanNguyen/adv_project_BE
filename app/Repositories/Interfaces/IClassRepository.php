<?php
namespace App\Repositories\Interfaces;

interface IClassRepository
{

    public function create(array $data);
    public function saveClassPlan(array $data);
}
