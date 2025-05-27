<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Services\SemesterGoalService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Tymon\JWTAuth\Facades\JWTAuth;

class SemesterGoalController extends Controller
{
    protected SemesterGoalService $service;

    public function __construct(SemesterGoalService $service)
    {
        $this->service = $service;
    }

    public function index(Request $request): JsonResponse
    {
        $semesterId = $request->query('semester_id');
        $studentId = $request->query('student_id');

        if (!$semesterId) {
            return response()->json(['message' => 'semester_id is required'], 422);
        }

        $goals = $this->service->getGoalsBySemester($semesterId, $studentId);

        return response()->json(['data' => $goals]);
    }

    public function store(Request $request): JsonResponse
{
    $data = $request->json()->all();

    if (!isset($data['goals']) || !is_array($data['goals']) || count($data['goals']) === 0) {
        return response()->json(['message' => 'Invalid or empty goals data'], 422);
    }

    $goals = $data['goals'];
    $semesterId = $goals[0]['semester_id'] ?? null;

    if (!$semesterId) {
        return response()->json(['message' => 'semester_id is required in each goal'], 422);
    }

    try {
        $user = JWTAuth::parseToken()->authenticate();

        $this->service->updateGoals($user->user_id, $semesterId, $goals);

        return response()->json(['message' => 'Saved successfully'], 201);
    } catch (\Throwable $e) {
        \Log::error('SemesterGoal store failed: ' . $e->getMessage(), [
            'trace' => $e->getTraceAsString()
        ]);

        return response()->json(['message' => 'Server error', 'error' => $e->getMessage()], 500);
    }
}}
