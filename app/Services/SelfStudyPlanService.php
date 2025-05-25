<?php
namespace App\Services;

use App\Repositories\Interfaces\ISelfStudyPlanRepository;

class SelfStudyPlanService
{
    protected $repository; // Đảm bảo property này tồn tại

    public function __construct(ISelfStudyPlanRepository $repository)
    {
        $this->repository = $repository; // Đảm bảo gán repository
    }

    public function getAllPlans()
    {
        return $this->repository->getAll();
    }

    public function createSelfStudyPlan(array $data)
    {
        $required = ['user_id', 'subject_id', 'week_track_id', 'lesson_learn', 'time_spend', 'date'];
        
        foreach ($required as $field) {
            if (!isset($data[$field])) {
                throw new \InvalidArgumentException("Thiếu trường bắt buộc: {$field}");
            }
        }

        return $this->repository->create($data);
    }

    public function getPlansByWeekTrack($weekTrackId)
    {
        return $this->repository->getByWeekTrackId($weekTrackId);
    }
}