<?php


namespace App\Repositories\Interfaces;


interface ISemesterGoalRepository
{
    /**
     * Tạo một bản ghi mục tiêu học tập.
     *
     * @param array $data
     * @return \App\Models\SemesterGoal
     */
    public function create(array $data);
    public function getGoalsBySemester($semesterId, $studentId = null);


}
