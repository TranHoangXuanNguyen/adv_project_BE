<?php


namespace App\Services;


use App\Repositories\Interfaces\ISemesterGoalRepository;


use App\Repositories\ISemesterGoalRepository as RepositoriesISemesterGoalRepository;


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
        $this->repository->create([
            'semester_id' => $goal['semester_id'],
            'student_id' => $studentId,
            'subject_id' => $goal['subject_id'],
            'course_expected' => $goal['course_expected'],
            'teacher_expected' => $goal['teacher_expected'],
            'themselves_expected' => $goal['themselves_expected'],
        ]);
    }
}
 public function getGoalsBySemester($semesterId, $studentId = null)
{
    return $this->repository->getGoalsBySemester($semesterId, $studentId);
}




}


