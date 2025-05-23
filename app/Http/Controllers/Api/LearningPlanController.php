<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Services\ClassPlanService;
use App\Services\SelfPlanService;
use Illuminate\Http\Request;

class LearningPlanController extends Controller
{
    protected $classPlanService;
    protected $selfStudyPlanService;

    public function __construct(ClassPlanService $classPlanService, SelfPlanService $selfStudyPlanService)
    {
        $this->classPlanService = $classPlanService;
        $this->selfStudyPlanService = $selfStudyPlanService;
    }

    public function getClassPlans(Request $request)
    {
        $studentId = $request->query('user_id');
        $weekTrackId = $request->query('week_track_id');
        $subjectId = $request->query('subject_id');

        $plans = $this->classPlanService->getPlans($studentId, $weekTrackId, $subjectId);

        return response()->json(['class_plans' => $plans]);
    }

    public function getSelfStudyPlans(Request $request)
    {
        $studentId = $request->query('user_id');
        $weekTrackId = $request->query('week_track_id');

        $plans = $this->selfStudyPlanService->getPlans($studentId, $weekTrackId);

        return response()->json(['self_study_plans' => $plans]);
    }
}
