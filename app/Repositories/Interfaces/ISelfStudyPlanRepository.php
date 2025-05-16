<?php
namespace App\Repositories\Interfaces;

interface ISelfStudyPlanRepository
{
    public function create(array $data);
    public function getByWeekTrackId(int $weekTrackId);
    public function getAll();
}