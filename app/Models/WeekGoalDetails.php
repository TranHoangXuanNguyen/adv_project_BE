<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class WeekGoalDetails extends Model
{
    protected $table = 'weekly_goals';
    protected $primaryKey = 'week_goal_id';

    protected $fillable = ['week_track_id', 'task_des', 'status', 'start_day', 'end_day'];

    public $timestamps = true;
}
