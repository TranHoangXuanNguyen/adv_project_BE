<?php

namespace App\Http\Controllers\Api;

use App\Services\SemesterGoalService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Tymon\JWTAuth\Facades\JWTAuth;
use App\Http\Controllers\Controller;

class SemesterGoalController extends Controller
{
    protected $service;

    public function __construct(SemesterGoalService $service)
    {
        $this->service = $service;
    }
    
    public function index(Request $request)
    {
        $semesterId = $request->query('semester_id');
        $perPage = $request->query('per_page', 10);

        if (!$semesterId) {
            return response()->json(['message' => 'semester_id is required'], 422);
        }

        $goals = $this->service->getGoalsBySemester($semesterId, $perPage);
        return response()->json($goals);
    }

    public function store(Request $request): JsonResponse
{
    $validatedData = $request->validate([
        'goals' => 'required|array',
        'goals.*.subject_id'    => 'integer|exists:subjects,subject_id',
        'goals.*.semester_id'   => 'integer|exists:semesters,semester_id',
        'goals.*.course_expected'    => 'required|string|max:500',
        'goals.*.teacher_expected'   => 'required|string|max:500',
        'goals.*.themselves_expected' => 'required|string|max:500',
    ]);

    $user = JWTAuth::parseToken()->authenticate();
    $this->service->createGoals($user->user_id, $validatedData['goals']);

    return response()->json(['message' => 'Saved successfully'], 201);
}


}
