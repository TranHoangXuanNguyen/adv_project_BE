<?php
namespace App\Services;

use App\Repositories\Interfaces\ISelfStudyPlanRepository;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\ValidationException;

class SelfStudyPlanService
{
    protected $repository;

    public function __construct(ISelfStudyPlanRepository $repository)
    {
        $this->repository = $repository; // Đảm bảo gán repository
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

    public function createSelfStudyPlan(array $data)
    {
        return $this->repository->create($data);
    }

    public function getPlansByWeekTrack($weekTrackId)
    {
        return $this->repository->getByWeekTrackId($weekTrackId);
    }
}
