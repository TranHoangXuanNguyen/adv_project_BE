<?php

namespace App\Repositories\Eloquent;

use App\Models\ClassMate;
use App\Repositories\Interfaces\IClassRepository;

class ClassRepository implements IClassRepository
{
    protected $classmodel;
    public function __construct(ClassMate $model)
    {
        $this->classmodel = $model;
    }
    public function getAll()
    {
        return $this->model->all();
    }
    public function getById($id)
    {
        return $this->model->findOrFail($id);
    }
    public function create(array $data)
    {
        return $this->classmodel->create($data);
    }
    public function update($id, array $data)
    {
        $record = $this->model->findOrFail($id);
        $record->update($data);
        return $record;
    }
    public function delete($id)
    {
        $record = $this->model->findOrFail($id);
        $record->delete();
    }
}

