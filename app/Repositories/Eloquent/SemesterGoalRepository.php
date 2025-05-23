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
            'semester_id'  => $data['semester_id'],
            'student_id'   => $data['student_id'],
            'subject_id'   => $data['subject_id'],
            'course_expected'  => $data['course_expected'],
            'teacher_expected' => $data['teacher_expected'],
            'themselves_expected'    => $data['themselves_expected'],
        ]);
    }


public function getGoalsBySemester($semesterId, $studentId = null)
{
    $query = SemesterGoal::with('subject')
        ->where('semester_id', $semesterId);


    if ($studentId) {
        $query->where('student_id', $studentId);
    }


    return $query->get();

}




}


