<?php
// app/Http/Controllers/Api/UserController.php
namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Validation\ValidationException;
use App\Services\SemesterService;
class SemesterController extends Controller
{
    protected $semesterService;
    public function __construct(SemesterService $semesterService){
        $this->semesterService = $semesterService;
    }

    public function getSubjectsBySemester(int $id): JsonResponse
    {
        $result = $this->semesterService->getSubjectsBySemester($id);
        return response()->json($result);
    }




}
