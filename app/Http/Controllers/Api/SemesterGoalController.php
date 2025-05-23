<?php


namespace App\Http\Controllers\Api;


use App\Services\SemesterGoalService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Tymon\JWTAuth\Facades\JWTAuth;
use App\Http\Controllers\Controller;


class SemesterGoalController extends Controller
{
    protected $service;


    public function __construct(SemesterGoalService $service)
    {
        $this->service = $service;
    }


  public function index(Request $request)
{
    $semesterId = $request->query('semester_id');
    $studentId = $request->query('student_id');


    if (!$semesterId) {
        return response()->json(['message' => 'semester_id is required'], 422);
    }


    $goals = $this->service->getGoalsBySemester($semesterId, $studentId);
    return response()->json(['data' => $goals]);
}




    public function store(Request $request): JsonResponse
    {
        // Lấy dữ liệu goals từ JSON body
        $data = $request->json()->all();


        if (!isset($data['goals']) || !is_array($data['goals'])) {
            return response()->json(['message' => 'Invalid goals data'], 422);
        }


        // Validate mảng goals
        $validatedData = validator($data['goals'], [
            '*.semester_id' => 'required|integer|exists:semesters,semester_id',
            '*.student_id' => 'required|integer|exists:users,user_id',
            '*.subject_id' => 'required|integer|exists:subjects,subject_id',
            '*.course_expected' => 'required|string|max:500',
            '*.teacher_expected' => 'required|string|max:500',
            '*.themselves_expected' => 'required|string|max:500',
        ])->validate();


        // Lấy user id từ JWT token
        $user = JWTAuth::parseToken()->authenticate();


        // Gọi service tạo goals
        $this->service->createGoals($user->user_id, $validatedData);


        return response()->json(['message' => 'Saved successfully'], 201);
    }
}

