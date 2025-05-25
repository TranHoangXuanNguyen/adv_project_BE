<?php

namespace App\Services;
use App\Repositories\Interfaces\ISemesterRepository;
use http\Env\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;
use Illuminate\Validation\ValidationException;
use App\Repositories\Interfaces\ISubjectRepository;
use App\Repositories\Interfaces\IClassRepository;

class SubjectService
{
    protected $subjectRepository;
    public function __construct(ISemesterRepository $semesterRepository)
    {
        $this->semesterRepository = $semesterRepository;
    }
    public function create(array $data): array
    {
        return $this->semesterRepository->create($data);
    }
    public function storeBySemester(int $id,array $data): array
    {
        $this->validateSubjectDataToAdd($data);
        return $this->semesterRepository->storeBySemester($id,$data);
    }
    public function getSubjectsBySemester(int $id): array
    {
        return $this->semesterRepository->getSubjectsBySemester($id);
    }

    public function validateSubjectDataToAdd(array $data): void
    {
        $validator = Validator::make($data,[
            'subject_name' => ['required','string','max:255'],
        ]);
        if($validator->fails()){
            throw new ValidationException($validator);
        }
    }
}
