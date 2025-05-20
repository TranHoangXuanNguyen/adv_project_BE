<?php
namespace App\Repositories\Eloquent;

use App\Models\SelfStudyPlan;
use App\Repositories\Interfaces\ISelfPlanRepository;

class SelfPlanRepository implements ISelfPlanRepository
{
    protected $model;

    public function __construct(SelfStudyPlan $model)
    {
        $this->model = $model;
    }

    public function getByStudentWeekSubject($studentId, $weekTrackId, $subjectId)
    {
        return $this->model->where('user_id', $studentId)
            ->where('week_track_id', $weekTrackId)
            ->where('subject_id', $subjectId)
            ->get();
    }
}
