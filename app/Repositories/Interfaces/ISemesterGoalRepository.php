<?php

namespace App\Repositories\Interfaces;

interface ISemesterGoalRepository
{
    public function findGoal(int $studentId, int $semesterId, int $subjectId);

    public function create(array $data);

    public function update(int $id, array $data);

    public function getGoalsBySemester(int $semesterId, ?int $studentId = null);
}
