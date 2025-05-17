<?php

namespace App\Models;
use Illuminate\Database\Eloquent\Model;


class WeeklyGoal extends Model
{
    protected $primaryKey = 'week_goal_id';

    protected $fillable = ['week_track_id', 'start_day', 'end_day', 'task_des', 'status'];

    public function tracking()
    {
        return $this->belongsTo(WeeklyTracking::class, 'week_track_id');
    }
}
