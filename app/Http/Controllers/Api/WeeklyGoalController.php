<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\WeeklyGoal;
use Illuminate\Http\Request;

class WeeklyGoalController extends Controller
{
    public function index()
    {
        $weeklyGoals = WeeklyGoal::with('weekGoals')->get();
        return response()->json($weeklyGoals);
    }
}
