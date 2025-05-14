<?php
namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Services\ClassService;


class ClassController extends Controller {
    protected $classService;

    public function __construct(ClassService $classService) {
        $this->classService = $classService;
    }

    // Lấy tất cả lớp
    public function getAll() {
        $classes = $this->classService->getAll();
        return response()->json([
            'success' => true,
            'data' => $classes
        ]);
    }
}