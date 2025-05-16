<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ClassPlan extends Model
{
    protected $primaryKey = 'class_plan_id';

    protected $fillable = [
        'user_id', 'subject_id', 'week_track_id',
        'lesson_learn', 'self_assessment', 'difficult', 'plan_to_improve', 'in_solve', 'date',
    ];

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function subject()
    {
        return $this->belongsTo(Subject::class, 'subject_id');
    }

    public function week()
    {
        return $this->belongsTo(WeeklyTracking::class, 'week_track_id');
    }
}
