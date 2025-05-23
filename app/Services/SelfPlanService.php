<?php
namespace App\Services;

use App\Repositories\Interfaces\ISelfPlanRepository;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\ValidationException;

class SelfPlanService
{
    protected $repository;

    public function __construct(ISelfPlanRepository $repository)
    {
        $this->repository = $repository;
    }

    public function getPlans($studentId, $weekTrackId)
    {
        $validator = Validator::make([
            'user_id' => $studentId,
            'week_track_id' => $weekTrackId,
        ], [
            'user_id' => 'required|integer|exists:users,user_id',
            'week_track_id' => 'required|integer|exists:weekly_tracking,week_track_id',
            ]);

        if ($validator->fails()) {
            throw new ValidationException($validator);
        }

        return $this->repository->getByStudentWeekSubject($studentId, $weekTrackId);
    }
}
