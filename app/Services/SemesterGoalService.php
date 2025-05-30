<?php

namespace App\Services;

use App\Repositories\Interfaces\ISemesterGoalRepository;

class SemesterGoalService
{
    protected ISemesterGoalRepository $repository;

    public function __construct(ISemesterGoalRepository $repository)
    {
        $this->repository = $repository;
    }

    /**
     * Cập nhật hoặc tạo mới các mục tiêu học kỳ của sinh viên
     *
     * @param int $studentId
     * @param int $semesterId
     * @param array $goals Mảng goal, mỗi phần tử có subject_id, course_expected, teacher_expected, themselves_expected
     * @return void
     */
    public function updateGoals(int $studentId, int $semesterId, array $goals): void
    {
        foreach ($goals as $goal) {
            $subjectId = $goal['subject_id'];

            $existingGoal = $this->repository->findGoal($studentId, $semesterId, $subjectId);

            $data = [
                'course_expected' => $goal['course_expected'] ?? '',
                'teacher_expected' => $goal['teacher_expected'] ?? '',
                'themselves_expected' => $goal['themselves_expected'] ?? '',
            ];

            if ($existingGoal && isset($existingGoal->s_goal_id)) {
                $this->repository->update($existingGoal->s_goal_id, $data);
            } else {
                $this->repository->create([
                    'student_id' => $studentId,
                    'semester_id' => $semesterId,
                    'subject_id' => $subjectId,
                ] + $data);
            }
        }
    }

    public function getGoalsBySemester(int $semesterId, ?int $studentId = null)
    {
        return $this->repository->getGoalsBySemester($semesterId, $studentId);
    }
}
