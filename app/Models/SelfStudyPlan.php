<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class SelfStudyPlan extends Model
{
    protected $primaryKey = 'self_plan_id';

    protected $fillable = [
        'user_id', 'subject_id', 'week_track_id',
        'lesson_learn', 'time_spend', 'learning_resource', 'learning_activities',
        'in_solve', 'concentration', 'date',
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
