<?php

namespace App\Repositories\Eloquent;
use App\Repositories\Interfaces\IWeeklyRepository;
use App\Models\WeeklyTracking;
use App\Models\WeeklyGoal;
use App\Models\ClassPlan;
use App\Models\SelfStudyPlan;
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

    public function getById(int $id)
    {
        try {
            return $this->weeklymodel
                ->where('user_id', $id)
                ->with('weeklyGoals')
                ->get();
        } catch (\Exception $e) {
            return $e;
        }
    }

    public function createWeeklyTracking(array $data)
    {
        return  $this->weeklymodel->create($data);
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
        if(!$goal){
            throw new \Exception('Goal not found');
        }
        $goal->status = $goal->status == 1 ? 0 : 1;
        $goal->save();

        return response()->json(['message' => 'Status updated', 'status' => $goal->status]);
    }
}
