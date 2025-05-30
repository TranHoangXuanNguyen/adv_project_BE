<?php

namespace App\Http\Controllers\Api;
use App\Http\Controllers\Controller;
use App\Services\NotifyService;
use App\Services\AuthService;
class NotifyController extends Controller
{
    protected $notifyService;
    protected $authService;
    public function __construct(NotifyService $notifyService, AuthService $authService){
        $this->notifyService =  $notifyService;
        $this->authService =  $authService;
    }

    public function getNotifyById(int $id){
        try {
            $data = $this->notifyService->getNotifyById($id);
            return response()->json($data);
        }catch (\Throwable $th) {
            return response()->json(['message' => 'Server error'], 500);
        }
    }

    public function remindDeadline()
    {
        $data = $this->authService->remindDeadline();
        return response()->json($data);
    }

}
