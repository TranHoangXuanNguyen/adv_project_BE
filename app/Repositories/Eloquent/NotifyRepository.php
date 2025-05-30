<?php

namespace App\Repositories\Eloquent;
use App\Repositories\Interfaces\INotifyRepository;
use App\Models\Notification;
class NotifyRepository implements INotifyRepository
{

    protected $notifyModel;

    public function __construct(Notification $notifyModel)
    {
        $this->notifyModel = $notifyModel;
    }
    public function getNotifyById(int $id)
    {
        return $this->notifyModel->where('user_id', $id)->get();
    }
}
