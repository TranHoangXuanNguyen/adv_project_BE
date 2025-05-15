<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class SemesterGoal extends Model
{
    protected $primaryKey = 's_goal_id';

    protected $fillable = [
        'student_id', 'subject_id',
        'course_expected', 'teacher_expected', 'themselves_expected',
    ];

    public function student()
    {
        return $this->belongsTo(User::class, 'student_id');
    }

    public function subject()
    {
        return $this->belongsTo(Subject::class, 'subject_id');
    }
    public function semester()
    {
        return $this->belongsTo(Semester::class, 'semester_id', 'semester_id');
    }
}
