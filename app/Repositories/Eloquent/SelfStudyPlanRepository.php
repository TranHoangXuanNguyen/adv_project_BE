<?php
namespace App\Repositories\Eloquent;

use App\Models\SelfStudyPlan;
use App\Repositories\Interfaces\ISelfStudyPlanRepository;

class SelfStudyPlanRepository implements ISelfStudyPlanRepository
{
    public function create(array $data)
    {
        return SelfStudyPlan::create($data);
    }

    public function getByWeekTrackId(int $weekTrackId)
    {
        return SelfStudyPlan::with(['subject', 'week'])
            ->where('week_track_id', $weekTrackId)
            ->get();
    }

    public function getAll()
    {
        return SelfStudyPlan::with(['subject', 'week'])->get();
    }
}