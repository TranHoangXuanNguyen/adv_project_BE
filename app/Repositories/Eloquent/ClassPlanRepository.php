<?php

namespace App\Repositories\Eloquent;

use App\Models\ClassPlan;
use App\Repositories\Interfaces\IClassPlanRepository;

class ClassPlanRepository implements IClassPlanRepository
{
    protected $model;

    public function __construct(ClassPlan $model)
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
