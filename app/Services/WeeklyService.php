<?php

namespace App\Services;
use App\Repositories\Interfaces\IWeeklyRepository;
class WeeklyService
{
    public $weeklyRepository;
    public function __construct(IWeeklyRepository $weeklyRepository )
    {
        $this->weeklyRepository = $weeklyRepository;
    }
    public function getAll(int $id)
    {
        return $this->weeklyRepository->getByid($id);
    }

    public function createWeeklyTracking(array $data)
    {
        return $this->weeklyRepository->createWeeklyTracking($data);
    }

    public function createWeeklyGoal(array $data)
    {
        return $this->weeklyRepository->createWeeklyGoal($data);
    }

    public function getAllWeeklyTracking(int $id,int $week_track_id )
    {
        return $this->weeklyRepository->getClassPlan($id,$week_track_id);
    }

    public function updateWeeklyGoalStatus(int $id)
    {
        return $this->weeklyRepository->updateWeeklyGoalStatus($id);
    }


}
