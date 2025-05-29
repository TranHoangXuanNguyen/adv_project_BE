<?php
namespace App\Services;
use App\Repositories\Interfaces\INotifyRepository;
class NotifyService
{

    protected $notifyRepository;

    public function __construct(INotifyRepository $notifyRepository)
    {
        $this->notifyRepository = $notifyRepository;
    }

    public function getNotifyById(int $id)
    {
        return $this->notifyRepository->getNotifyById($id);
    }

}
