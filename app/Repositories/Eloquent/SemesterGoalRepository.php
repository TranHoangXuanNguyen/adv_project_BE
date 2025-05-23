<?php

namespace App\Repositories\Eloquent;

use App\Repositories\Interfaces\ISemesterGoalRepository;
use App\Models\SemesterGoal;

class SemesterGoalRepository implements ISemesterGoalRepository
{
    public function create(array $attributes)
    {
        return SemesterGoal::create($attributes);
    }

    public function getGoalsBySemester($semesterId, $perPage = 10)
    {
        return SemesterGoal::with(['subject', 'student'])
            ->where('semester_id', $semesterId)
            ->paginate($perPage);
    }
}
