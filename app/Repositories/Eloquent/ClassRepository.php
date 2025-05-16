<?php

namespace App\Repositories\Eloquent;

use App\Models\ClassMate;
use App\Repositories\Interfaces\IClassRepository;
use App\Models\ClassPlan;

class ClassRepository implements IClassRepository
{
    protected $classmodel;
    public function __construct(ClassMate $model)
    {
        $this->classmodel = $model;
    }
    public function getAll()
    {
        return $this->classmodel->all();
    }
    public function getById($id)
    {
        return $this->classmodel->findOrFail($id);
    }

    public function create(array $data)
    {
        return $this->classmodel->create($data);
    }
    public function update($id, array $data)
    {
        $record = $this->classmodel->findOrFail($id);
        $record->update($data);
        return $record;
    }
    public function delete($id)
    {
        $record = $this->classmodel->findOrFail($id);
        $record->delete();
    }
    public function saveClassPlan(array $data)
    {
        return ClassPlan::create($data);
    }
}

