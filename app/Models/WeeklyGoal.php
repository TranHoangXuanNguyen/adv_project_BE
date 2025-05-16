<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class WeeklyGoal extends Model
{
    protected $table = 'weekly_tracking';

    protected $primaryKey = 'week_track_id';

    protected $fillable = [
        'week_name',
        'semester_id',
        'start_day',
        'end_day'
    ];

    public $timestamps = true;

    public function weekGoals()
    {
        return $this->hasMany(WeekGoalDetails::class, 'week_track_id', 'week_track_id');
    }
}
