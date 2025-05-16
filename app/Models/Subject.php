<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Subject extends Model
{
    protected $primaryKey = 'subject_id';

    protected $fillable = ['semester_id', 'subject_name'];

    public function semester()
    {
        return $this->belongsTo(Semester::class, 'semester_id');
    }

    public function semesterGoals()
    {
        return $this->hasMany(SemesterGoal::class, 'subject_id');
    }

    public function classPlans()
    {
        return $this->hasMany(ClassPlan::class, 'subject_id');
    }

    public function selfStudyPlans()
    {
        return $this->hasMany(SelfStudyPlan::class, 'subject_id');
    }
}
