<?php

namespace App\Repositories\Interfaces;

interface ISelfPlanRepository
{
    public function getByStudentWeekSubject($studentId, $weekTrackId, $subjectId);
}