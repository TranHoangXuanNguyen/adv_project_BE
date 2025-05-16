<?php

namespace App\Services;
use App\Repositories\Interfaces\IClassRepository;
use App\Repositories\Interfaces\ISemesterRepository;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\ValidationException;

class ClassService
{
    protected IClassRepository $classRepository;
    protected ISemesterRepository $semesterRepository;

    public function __construct(IClassRepository $classRepository , ISemesterRepository $semesterRepository)
    {
        $this->classRepository = $classRepository;
        $this->semesterRepository = $semesterRepository;
    }


    public function createWithSemester(array $data)
    {
        DB::beginTransaction();
        try {
            $this->validateClassData($data);
            $class = $this->classRepository->create([
                'name' => $data['name']
            ]);

            $semester = $this->semesterRepository->create([
                'class_id' => $class->class_id,
                'semester_name' => "Semester 1",
                'start_date' =>now(),
            ]);
            DB::commit();
            return $semester;

        } catch (\Throwable $e) {
            DB::rollBack();
            throw $e;
        }
    }

    public function createNewSemester(int $id , string $semesterName)
    {
        return $this->semesterRepository->create([
            'class_id' => $id,
            'semester_name' => $semesterName,
            'start_date' =>now(),
        ]);
    }


    public function getLastestSemester(int $classId)
    {
        return $this->semesterRepository->getLastestSemester($classId);
    }

    protected function validateClassData(array $data): void
    {
        $validator = Validator::make($data, [
            'name' => 'required|string|unique:class_mates,name',
        ]);
        if ($validator->fails()) {
            throw new ValidationException($validator);
        }
    }
    
    public function saveClassPlan(array $data)
    {
        $validator = Validator::make($data, [
            'user_id' => 'required',
            'subject_id' => 'required',
            'week_track_id' => 'required',
            'lesson_learn' => 'required|string',
            'self_assessment' => 'required',
            'difficult' => 'nullable|string',
            'plan_to_improve' => 'nullable|string',
            'in_solve' => 'nullable|integer',
            'date' => 'required|date',
        ]);

        // Nếu pass validate thì lưu data
        return $this->classRepository->saveClassPlan($validator->validated());
    }
}
