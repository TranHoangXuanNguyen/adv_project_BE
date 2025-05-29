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

    public function storeBySemester(int $id,array $data)
    {
        $semester = Semester::findOrFail($id);
        $subject =  $semester->subjects()->create([
            'subject_name' => $data['subject_name'],
        ]);
        return $subject->toArray();
    }

    public function getSubjectsBySemester(int $id)
    {
        $semester = Semester::findOrFail($id);
        return $semester->subjects()->get();
    }


    public function createNewSemester(int $id, array $data)
    {
        try {
            $result = $this->model->insert([
                'class_id' => $id,
                'semester_name' => $data['semester_name'],
                'created_at' => date('Y-m-d H:i:s'),
                'start_date' => date('Y-m-d H:i:s')
            ]);

            return $result;
        }catch (\Throwable $th) {
            return $th;
        }
    }
}
