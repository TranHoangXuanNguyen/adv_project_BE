<?php

namespace App\Http\Controllers\Api;
use App\Http\Controllers\Controller;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Validation\ValidationException;
use App\Services\WeeklyService;
class WeeklyController extends Controller
{
    protected $weeklyService;
    public function __construct(WeeklyService $weeklyService)
    {
        $this->weeklyService = $weeklyService;
    }
    public function create(Request $request): JsonResponse{
        $result = $this->weeklyService->create($request->all());
        return response()->json($result);
    }

    public function getWeeklyByid(int $id): JsonResponse{
        $result = $this->weeklyService->getAll($id);
        return response()->json($result);
    }

    public function createWeeklyTracking(Request $request)
    {
        $data = $request->validate([
            'semester_id' => 'required|exists:semesters,semester_id',
            'user_id' => 'required|exists:users,user_id',
            'week_name' => 'required|string|max:255',
            'start_day' => 'required|date',
            'end_day' => 'required|date',
        ]);

        $weeklyTracking = $this->weeklyService->createWeeklyTracking($data);

        return response()->json([
            'success' => true,
            'data' => $weeklyTracking
        ]);
    }

    public function createWeeklyGoal(Request $request)
    {
        $data = $request->validate([
            'week_track_id' => 'required|exists:weekly_tracking,week_track_id',
            'task_des' => 'required|string',
            'start_day' => 'required|date',
            'end_day' => 'required|date',
            'status' => 'boolean',
        ]);

        $weeklyGoal = $this->weeklyService->createWeeklyGoal($data);

        return response()->json([
            'success' => true,
            'data' => $weeklyGoal
        ]);
    }

    public function getClassPlan(Request $request)
    {
        $user_id = $request->input('user_id');
        $week_track_id = $request->input('week_track_id');

        if (!$user_id || !$week_track_id) {
            return response()->json([
                'success' => false,
                'message' => 'Missing required parameters: user_id, week_track_id'
            ], 400);
        }

        $weeklyTracking = $this->weeklyService->getAllWeeklyTracking(
            (int) $user_id,
            (int) $week_track_id
        );

        return response()->json([
            'success' => true,
            'data' => $weeklyTracking
        ]);
    }


    public function updateWeeklyGoalStatus(int $id){
        try {
            $result = $this->weeklyService->updateWeeklyGoalStatus($id);
            return response()->json($result);
        }catch (\Throwable $th) {
            return response()->json($th->getMessage());
        }
    }


}
