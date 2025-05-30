<?php
namespace App\Services;
use App\Repositories\Interfaces\IManagerRepository;
class ManagerService
{
    protected $managerRepository;
    public function __construct(IManagerRepository $managerRepository)
    {
        $this->managerRepository = $managerRepository;
    }
    public function countWeekByClass(int $classId)
    {
        return $this->managerRepository->countWeekByClass($classId);
    }
}
