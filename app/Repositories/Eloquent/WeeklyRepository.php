<?php

namespace App\Repositories\Eloquent;
use App\Repositories\Interfaces\IWeeklyRepository;
use App\Models\WeeklyTracking;
use App\Models\WeeklyGoal;
use App\Models\ClassPlan;
use App\Models\SelfStudyPlan;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Log;

class WeeklyRepository implements IWeeklyRepository
{
    protected $weeklymodel;
    protected $weeklygoalmodel;
    protected $classplanmodel;
    protected $selfstudyplanmodel;
    public function __construct(WeeklyTracking $model, WeeklyGoal $weeklyGoalModel, ClassPlan $classplanmodel, SelfStudyPlan $selfstudyplanmodel)
    {
        $this->weeklymodel = $model;
        $this->weeklygoalmodel = $weeklyGoalModel;
        $this->classplanmodel = $classplanmodel;
        $this->selfstudyplanmodel = $selfstudyplanmodel;
    }

    public function getById(int $id, int $semester_id)
    {
        $cacheKey = "weekly_tracking_user_{$id}_semester_{$semester_id}";
        return Cache::remember($cacheKey, 600, function() use ($id, $semester_id) {
            Log::info("Cache MISS: truy vấn DB cho user_id = $id");
            if (!isset($semester_id)) {
                Log::error("Lỗi: 'semester_id' không tồn tại trong dữ liệu đầu vào");
                return response()->json(['error' => 'semester_id không được cung cấp'], 400);
            }
            return $this->weeklymodel
                ->where('user_id', $id)
                ->where('semester_id', $semester_id)
                ->with('weeklyGoals')
                ->get();
        });
    }


    public function createWeeklyTracking(array $data)
    {
        $user_id = $data['user_id'] ?? null;
        $semester_id = $data['semester_id'] ?? null;
        if (!$user_id || !$semester_id) {
            Log::error("Error: 'user_id' or 'semester_id' dont exist");
            return response()->json(['error' => 'user_id and semester_id must be provide'], 400);
        }
        $cacheKey = "weekly_tracking_user_{$user_id}_semester_{$semester_id}";
        Cache::forget($cacheKey);
        $newRecord = $this->weeklymodel->create($data);
//        Cache::put($cacheKey, $newRecord, 600);
        return $newRecord;
    }


    public function createWeeklyGoal(array $data)
    {
        return $this->weeklygoalmodel->create($data);
    }


    public function getClassPlan(int $id,  int $week_track_id)
    {
        // TODO: Implement getClassPlan() method.
        return $this->classplanmodel->where('user_id',$id)->where('week_track_id',$week_track_id)->get();
    }

    public function getSelfPlan(int $id, int $semesters_id, int $week_track_id)
    {
        // TODO: Implement getSelfPlan() method.
    }

    public function updateWeeklyGoalStatus(int $id)
    {
        $goal = $this->weeklygoalmodel->where('week_goal_id', $id)->first();
        if (!$goal) {
            throw new \Exception('Goal not found');
        }
        $goal->status = $goal->status == 1 ? 0 : 1;
        $goal->save();
        $weeklyGoalId = $goal->week_track_id;
        $weeklyTracking = $this->weeklymodel->where('week_track_id', $weeklyGoalId)->first();
        $user_id = $weeklyTracking->user_id;
        $semester_id = $weeklyTracking->semester_id;
        $cacheKey = "weekly_tracking_user_{$user_id}_semester_{$semester_id}";
        $cachedData = Cache::get($cacheKey);
        if ($cachedData) {
            Log::info("Dữ liệu trong cache:", ['cachedData' => $cachedData]);
        } else {
            Log::info("Cache trống hoặc chưa được lưu.");
        }
        if ($cachedData) {
            foreach ($cachedData as &$week) {
                foreach ($week->weeklyGoals as &$weeklyGoal) {
                    if ($weeklyGoal->week_goal_id == $id) {
                        $weeklyGoal->status = $goal->status;
                        break;
                    }
                }
            }
            Cache::put($cacheKey, $cachedData, 600);
        }
        return response()->json(['message' => 'Status updated', 'status' => $goal->status]);
    }

}
