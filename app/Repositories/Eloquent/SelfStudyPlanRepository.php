<?php
namespace App\Repositories\Eloquent;

use App\Models\SelfStudyPlan;
use App\Repositories\Interfaces\ISelfStudyPlanRepository;

class SelfStudyPlanRepository implements ISelfStudyPlanRepository
{
    public function create(array $data)
    {
//        dd($data);
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
    public function getByStudentWeekSubject($studentId, $weekTrackId)
    {
        return SelfStudyPlan::where('user_id', $studentId)
            ->where('week_track_id', $weekTrackId)
            ->with(['subject', 'week'])
            ->get();
    }
}
