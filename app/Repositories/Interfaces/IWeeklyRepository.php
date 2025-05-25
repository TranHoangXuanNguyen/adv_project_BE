<?php

namespace App\Repositories\Interfaces;

interface IWeeklyRepository
{
    public function getByid(int $id);
    public function createWeeklyTracking(array $data);
    public function getClassPlan(int $id,int $week_track_id);
    public function getSelfPlan(int $id,int $semesters_id,int $week_track_id);
    public function updateWeeklyGoalStatus(int $id);

}
