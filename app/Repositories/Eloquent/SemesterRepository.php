<?php

namespace App\Repositories\Eloquent;

use App\Repositories\Interfaces\ISemesterRepository;
use App\Models\Semester;

class SemesterRepository implements ISemesterRepository
{
    protected $model;

    public function __construct(Semester $model)
    {
        $this->model = $model;
    }
    public function getAll()
    {
        // TODO: Implement getAll() method.
    }

    public function getById($id)
    {
        // TODO: Implement getById() method.
    }

    public function create(array $data)
    {
        // TODO: Implement create() method.
        return $this->model->create($data);
    }

    public function update($id, array $data)
    {
        // TODO: Implement update() method.
    }

    public function delete($id)
    {
        // TODO: Implement delete() method.
    }

    public function getLastestSemester($classId)
    {
        return $this->model
            ->where('class_id', $classId)
            ->latest()
            ->first();
    }

}
