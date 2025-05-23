<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class WeeklyTracking extends Model
{
    protected $table = 'weekly_tracking';
    protected $primaryKey = 'week_track_id';

    protected $fillable = [
        'week_name',
        'semester_id',
        'user_id',
        'start_day',
        'end_day'
    ];

    public function semester()
    {
        return $this->belongsTo(Semester::class, 'semester_id');
    }

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function weeklyGoals()
    {
        return $this->hasMany(WeeklyGoal::class, 'week_track_id');
    }

    public function classPlans()
    {
        return $this->hasMany(ClassPlan::class, 'week_track_id');
    }

    public function selfStudyPlans()
    {
        return $this->hasMany(SelfStudyPlan::class, 'week_track_id');
    }
}
