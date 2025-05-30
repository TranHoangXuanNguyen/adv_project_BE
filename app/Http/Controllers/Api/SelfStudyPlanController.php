<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Services\SelfStudyPlanService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class SelfStudyPlanController extends Controller
{
    protected $service;

    public function __construct(SelfStudyPlanService $service)
    {
        $this->service = $service;
    }

    /**
     * Lấy danh sách tất cả kế hoạch tự học (GET)
     */
     public function index(Request $request)
    {
        $user_id = $request->input('user_id');
        $week_track_id = $request->input('week_track_id');
        if (!$user_id || !$week_track_id) {
            return response()->json([
                'success' => false,
                'message' => 'Missing required parameters: user_id, week_track_id'
            ], 400);
        }
        $weeklyTracking = $this->service->getPlans($user_id,$week_track_id);
        return response()->json([
            'success' => true,
            'data' => $weeklyTracking
        ]);
    }

    /**
     * Tạo mới kế hoạch tự học (POST)
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'user_id' => 'required',
            'subject_id' => 'required|integer|exists:subjects,subject_id',
            'week_track_id' => 'required|integer|exists:weekly_tracking,week_track_id',
            'lesson_learn' => 'required|string|max:500',
            'time_spend' => 'required|string|max:100',
            'learning_resource' => 'nullable|string|max:500',
            'learning_activities' => 'nullable|string|max:500',
            'in_solve' => 'nullable',
            'concentration' => 'nullable|integer|between:1,5',
            'date' => 'required|date'
        ]);

        try {
            $plan = $this->service->createSelfStudyPlan($validated);
            return response()->json([
                'success' => true,
                'data' => $plan,
                'message' => 'Tạo kế hoạch thành công'
            ], 201);

        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Lỗi khi tạo kế hoạch: ' . $e->getMessage()
            ], 400);
        }
    }

    /**
     * Lấy kế hoạch theo week_track_id (GET)
     */
    public function getByWeekTrack($weekTrackId)
    {
        try {
            $plans = $this->service->getPlansByWeekTrack($weekTrackId);

            return response()->json([
                'success' => true,
                'data' => $plans,
                'message' => 'Lấy kế hoạch theo tuần thành công'
            ]);

        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Lỗi khi lấy kế hoạch: ' . $e->getMessage()
            ], 500);
        }
    }
}
