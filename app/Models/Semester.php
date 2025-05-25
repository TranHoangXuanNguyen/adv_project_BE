<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Semester extends Model
{
    protected $primaryKey = 'semester_id';

    protected $fillable = ['class_id', 'semester_name', 'start_date'];

    public function classMate()
    {
        return $this->belongsTo(ClassMate::class, 'class_id');
    }

    public function subjects()
    {
        return $this->hasMany(Subject::class, 'semester_id');
    }

    public function weeklyTracking()
    {
        return $this->hasMany(WeeklyTracking::class, 'semester_id');
    }

    public function goals()
    {
        return $this->hasMany(SemesterGoal::class, 'semester_id', 'semester_id');
    }
}
