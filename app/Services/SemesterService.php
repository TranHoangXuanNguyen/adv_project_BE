<?php

namespace App\Services;
use App\Repositories\Interfaces\ISemesterRepository;
class SemesterService
{
    protected $semesterRepository;

    public function __construct(ISemesterRepository $semesterRepository)
    {
        $this->semesterRepository = $semesterRepository;
    }
    public function getSubjectsBySemester(int $id): array{
        $result = $this->semesterRepository->getSubjectsBySemester($id);
        return $result->toArray();
    }

}
