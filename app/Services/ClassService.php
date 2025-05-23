<?php
namespace App\Services;
use App\Repositories\Interfaces\IClassRepository;
use App\Repositories\Interfaces\ISemesterRepository;
use http\Env\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;
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



    public function getAll() {
        return $this->classRepository->getAll();
    }

    public function getClassByStudents($id) {
        return $this->classRepository->getById($id);
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

    public function getAllClasses(){
        return $this->classRepository->getAllClasses();
    }


    public function createNewSemester(int $id , string $semesterName)
    {
        return $this->semesterRepository->create([
            'class_id' => $id,
            'semester_name' => $semesterName,
            'start_date' =>now(),
        ]);
    }

    public function getClassById($id)
    {
        return $this->classRepository->getClassById($id);
    }



    public function getLastestSemester(int $classId)
    {
        return $this->semesterRepository->getLastestSemester($classId);
    }



    public function addStudentToClass(int $id,array $data)
    {
        try {
            $this->validateClassDataToAdd($data,$id);
            $this->classRepository->addStudentToClass($id,$data);
        }catch (\Throwable $e){
            throw $e;
        }
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
            'user_id' => 'nullable|integer',
            'subject_id' => 'required|integer',
            'week_track_id' => 'required|integer',
            'lesson_learn' => 'required|string',
            'self_assessment' => 'required',
            'difficult' => 'nullable|string',
            'plan_to_improve' => 'nullable|string',
            'in_solve' => 'nullable|integer',
            'date' => 'required|date',
        ]);
        return $this->classRepository->saveClassPlan($validator->validated());
    }

    function validateClassDataToAdd(array $data,int $id): void
    {
        $validator = Validator::make($data, [
            'student_ids' => 'required|array',
            'student_ids.*' => [
                'distinct',
                'exists:users,user_id',
                Rule::unique('student_in_class', 'user_id'),
            ],
        ]);

        if ($validator->fails()) {
            throw new ValidationException($validator);
        }
    }

    public function getClassInfor($userId){
        return $this->classRepository->getClassInfor($userId);
    }

}
