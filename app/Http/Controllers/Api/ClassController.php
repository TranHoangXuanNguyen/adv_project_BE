<?php

namespace App\Http\Controllers\Api;
use App\Http\Controllers\Controller;
use App\Services\ClassService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Validation\ValidationException;
class ClassController extends Controller
{
    protected $classService;
    public function __construct(ClassService $classService)
    {
        $this->classService = $classService;
    }
    public function create(Request $request): JsonResponse{
        $result = $this->classService->createWithSemester($request->all());
        return response()->json($result);
    }

    public function getLastestSemester(int $classId) : JsonResponse{
        try {
            return response()->json($this->classService->getLastestSemester($classId));
        } catch (\Throwable $th) {
            return response()->json($th->getMessage());
        }
    }

    public function addStudentToClass(int $id, Request $req): JsonResponse
    {
        try {
            $result = $this->classService->addStudentToClass($id, $req->all());

            return response()->json([
                'success' => true,
                'message' => 'Students added successfully',
                'data' => $result,
            ], 200);

        } catch (\Illuminate\Validation\ValidationException $e) {
            return response()->json([
                'success' => false,
                'message' => 'Validation error',
                'errors' => $e->errors(),
            ], 422);

        } catch (\Throwable $e) {
            return response()->json([
                'success' => false,
                'message' => $e->getMessage(),
            ], 500);
        }
    }

    public function storeClassPlan(Request $request)
    {

        $classPlan = $this->classService->saveClassPlan($request->all());

        return response()->json([
            'success' => true,
            'data' => $classPlan,
        ], 201);
    }

  public function getAll() {
        $classes = $this->classService->getAll();
        return response()->json([
            'success' => true,
            'data' => $classes
        ]);
    }
}
