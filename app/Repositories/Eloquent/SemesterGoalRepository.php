<?php

namespace App\Repositories\Eloquent;
use App\Repositories\Interfaces\ISemesterGoalRepository;

use App\Models\SemesterGoal;

class SemesterGoalRepository implements ISemesterGoalRepository
{
    public function create(array $data)
    {
        // Dùng Eloquent để tạo bản ghi
        return SemesterGoal::create([
            'student_id'   => $data['student_id'],
            'subject_id'   => $data['subject_id'],
            'semester_id'  => $data['semester_id'],
            'course_expected'  => $data['course_expected'],
            'teacher_expected' => $data['teacher_expected'],
            'themselves_expected'    => $data['themselves_expected'],
        ]);
    }

public function getGoalsBySemester($semesterId, $perPage = 10)
    {
        return SemesterGoal::with(['subject', 'student'])
            ->where('semester_id', $semesterId)
            ->paginate($perPage);
    }

}
