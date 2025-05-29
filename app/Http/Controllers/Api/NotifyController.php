<?php

namespace App\Http\Controllers\Api;
use App\Http\Controllers\Controller;
use App\Services\NotifyService;
class NotifyController extends Controller
{
    protected $notifyService;

    public function __construct(NotifyService $notifyService){
        $this->notifyService = $notifyService;
    }

    public function getNotifyById(int $id){
        try {
            $data = $this->notifyService->getNotifyById($id);
            return response()->json($data);
        }catch (\Throwable $th) {
            return response()->json(['message' => 'Server error'], 500);
        }

    }

}
