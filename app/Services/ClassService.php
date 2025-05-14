<?php
namespace App\Services;

use App\Repositories\Interfaces\IClassRepository;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\ValidationException;


class ClassService {
    protected $classRepository;

    public function __construct(IClassRepository $classRepository) {
        $this->classRepository = $classRepository;
    }

    public function getAll() {
        return $this->classRepository->getAll();
    }

    public function getClassByStudents($id) {
        return $this->classRepository->getById($id);
    }
}