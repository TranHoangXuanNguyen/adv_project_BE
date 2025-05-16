<?php
namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Validation\ValidationException;
use App\Services\SubjectService;
class SubjectController extends Controller
{
    protected $subjectService;

    public function __construct(SubjectService $subjectService)
    {
        $this->subjectService = $subjectService;
    }
    public function create(Request $request): JsonResponse{
        $result = $this->subjectService->create($request->all());
        return response()->json($result);
    }

    public function getAll() : JsonResponse{
        try {
            return response()->json($this->subjectService->getAllSubjects());
        }catch (\Throwable $th){
            return response()->json($th->getMessage());
        }
    }

    public function storeBySemester(int $id,Request $request): JsonResponse
    {
        try {
            $result = $this->subjectService->storeBySemester($id,$request->all());
            return response()->json($result);
        } catch (\Throwable $th) {
            return response()->json($th->getMessage());
        }
    }
}
