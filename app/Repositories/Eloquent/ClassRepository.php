<?php
namespace App\Repositories\Eloquent;

use App\Models\ClassMate;
use App\Repositories\Interfaces\IClassRepository;

class ClassRepository implements IClassRepository {
    
    protected $model;

    public function __construct(ClassMate $classMate)
    {
        $this->model = $classMate;
    }

    public function getAll()
    {
        return $this->model->all();
    }
    public function getById($id)
    {
        return $this->model->findOrFail($id);
    }
}