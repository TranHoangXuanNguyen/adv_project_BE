<?php

namespace App\Repositories\Interfaces;

interface ISemesterGoalRepository
{
    public function create(array $attributes);
    public function getGoalsBySemester($semesterId, $perPage = 10);
}
