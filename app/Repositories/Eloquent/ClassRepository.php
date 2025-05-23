<?php

namespace App\Repositories\Eloquent;

use App\Models\ClassMate;
use App\Repositories\Interfaces\IClassRepository;
use App\Models\ClassPlan;
use Illuminate\Support\Facades\DB;
use App\Models\User;

class ClassRepository implements IClassRepository
{
    protected $classmodel;
    protected $usermodel;
    public function __construct(ClassMate $model, User $usermodel)
    {
        $this->classmodel = $model;
        $this->usermodel = $usermodel;
    }
    public function getAll()
    {
        return $this->classmodel->all();
    }
    public function getClassById($id)
    {
        $class = $this->classmodel->findOrFail($id);
        $students = $class->students()->get();
        return [
            'class' => $class,
            'students' => $students
        ];
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

    public function getAllClasses()
    {
        $classes = $this->classmodel::withCount('students')
            ->with('latestSemester')
            ->get()
            ->map(function ($class) {
                return [
                    'class_id' => $class->class_id,
                    'name' => $class->name,
                    'student_count' => $class->students_count,
                    'current_semester' => $class->latestSemester ? [
                        'semester_id' => $class->latestSemester->semester_id,
                        'semester_name' => $class->latestSemester->semester_name,
                        'start_date' => $class->latestSemester->start_date,
                        'end_date' => $class->latestSemester->end_date,
                    ] : null,
                    'created_at' => $class->created_at,
                    'updated_at' => $class->updated_at,
                ];
            });

        return $classes;

    }

    public function addStudentToClass(int $id, array $data)
    {
        $class = $this->classmodel::findOrFail($id);
        if (!isset($data['student_ids']) || !is_array($data['student_ids'])) {
            throw new \InvalidArgumentException("student_ids need to be an array");
        }
        try {
            $class->students()->attach($data['student_ids']);
            return [
                'message' => 'Students added to class successfully.',
                'class_id' => $id,
                'students_added' => $data['student_ids'],
            ];
        }catch (\Exception $e) {
            throw $e;
        }
    }
    public function saveClassPlan(array $data)
    {
        return ClassPlan::create($data);
    }

    public function getClassInfor(int $id)
    {
        try {
            $classInfo = DB::table('student_in_class')
                ->join('class_mates', 'student_in_class.class_id', '=', 'class_mates.class_id')
                ->where('student_in_class.user_id', $id)
                ->select('class_mates.class_id as class_id', 'class_mates.name as class_name')
                ->first();

            if (!$classInfo) {
                return response()->json(['message' => 'Student is not assigned to any class'], 404);
            }

            $semester = DB::table('semesters')
                ->where('class_id', $classInfo->class_id)
                ->orderByDesc('start_date')
                ->select('semester_id', 'semester_name', 'start_date')
                ->first();

            if (!$semester) {
                return response()->json(['message' => 'No semester found for this class'], 404);
            }

            return response()->json([
                'class' => $classInfo,
                'semester' => $semester
            ]);
        } catch (\Exception $e) {
            return response()->json(['message' => 'Server error', 'error' => $e->getMessage()], 500);
        }
    }

}

