<?php

namespace App\Services;

use App\Repositories\Interfaces\ISemesterGoalRepository;

class SemesterGoalService
{
    protected $repository;

    public function __construct(ISemesterGoalRepository $repository)
    {
        $this->repository = $repository;
    }

    public function createGoals(int $studentId, array $goals): void
    {
        foreach ($goals as $goal) {
            if (!isset($goal['subject_id'], $goal['semester_id'], $goal['course_expected'], $goal['teacher_expected'], $goal['themselves_expected'])) {
                continue;
            }

            $this->repository->create([
                'student_id'          => $studentId,
                'subject_id'          => $goal['subject_id'],
                'semester_id'         => $goal['semester_id'],
                'course_expected'     => $goal['course_expected'],
                'teacher_expected'    => $goal['teacher_expected'],
                'themselves_expected' => $goal['themselves_expected'],
            ]);
        }
    }

    public function getGoalsBySemester(int $semesterId, int $perPage = 10)
    {
        return $this->repository->getGoalsBySemester($semesterId, $perPage);
    }
}
