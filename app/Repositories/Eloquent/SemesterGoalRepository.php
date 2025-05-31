<?php

namespace App\Repositories\Eloquent;

use App\Models\SemesterGoal;
use App\Repositories\Interfaces\ISemesterGoalRepository;

class SemesterGoalRepository implements ISemesterGoalRepository
{
    public function findGoal(int $studentId, int $semesterId, int $subjectId)
    {
        return SemesterGoal::where('student_id', $studentId)
            ->where('semester_id', $semesterId)
            ->where('subject_id', $subjectId)
            ->first();
    }

    public function create(array $data)
    {
        return SemesterGoal::create($data);
    }

    public function update(int $id, array $data)
    {
        $goal = SemesterGoal::find($id);
        if ($goal) {
            $goal->update($data);
        }
        return $goal;
    }

    public function getGoalsBySemester(int $semesterId, ?int $studentId = null)
    {
        $query = SemesterGoal::where('semester_id', $semesterId);
        if ($studentId) {
            $query->where('student_id', $studentId);
        }
        return $query->get();
    }
}
