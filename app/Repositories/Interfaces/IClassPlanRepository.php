<?php

namespace App\Repositories\Interfaces;

interface IClassPlanRepository
{
    public function getByStudentWeekSubject($studentId, $weekTrackId, $subjectId);
}
