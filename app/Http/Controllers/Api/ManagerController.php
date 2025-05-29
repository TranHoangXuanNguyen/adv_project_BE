<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Services\ManagerService;

class ManagerController extends Controller
{
    protected $managerService;

    public function __construct(ManagerService $managerService)
    {
        $this->managerService = $managerService;
    }

    public function countWeekByClass(int $classId)
    {

        return 1;
    }
}
