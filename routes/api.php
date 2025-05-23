<?php

use App\Http\Controllers\Api\LearningPlanController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\{
    AuthController,
    UserController,
    ClassController,
    SubjectController,
    SemesterController,
    WeeklyController,
    SelfStudyPlanController,
    SemesterGoalController,
    HelpRequestController,  
};
use App\Http\Middleware\CheckAdmin;

/*
|--------------------------------------------------------------------------
| Public Routes (No middleware)
|--------------------------------------------------------------------------
*/

Route::post('/create', [AuthController::class, 'create']);
Route::post('/login', [AuthController::class, 'login']);
Route::post('/logout', [AuthController::class, 'logout']);
Route::post('/refresh', [AuthController::class, 'refresh']);
Route::post('/fcm-token', [AuthController::class, 'saveFcmToken'])->middleware('auth:api');
Route::post('/send-notification', [AuthController::class, 'sendNotification']);
Route::get('/hello', function () {
    return response()->json(['message' => 'Hello from the API!']);
})->middleware(CheckAdmin::class);

Route::get('/users/{role}', [UserController::class, 'getByRole']);
Route::post('/users', [UserController::class, 'store']);

Route::get('/class', [ClassController::class, 'getAll']);
Route::get('/class/{id}', [ClassController::class, 'getClassById']);
Route::get('/class/lastest-semester/{id}', [ClassController::class, 'getLastestSemester']);
Route::get('/students/{id}/class-info', [ClassController::class, 'getClassInfor']);

//Route::get('/classplan', [ClassController::class, 'index']);
Route::post('/classplan', [ClassController::class, 'storeClassPlan']);

Route::get('/weekly-goals/{id}', [WeeklyController::class, 'getWeeklyByid']);
Route::get('/weekly/class-plan', [WeeklyController::class, 'getClassPlan']);

Route::get('self-study-plans', [SelfStudyPlanController::class, 'index']);
Route::get('self-study-plans/week/{weekTrackId}', [SelfStudyPlanController::class, 'getByWeekTrack']);
Route::post('self-study-plans', [SelfStudyPlanController::class, 'store']);

/*
|--------------------------------------------------------------------------
| Protected Routes (auth:api middleware)
|--------------------------------------------------------------------------
*/
Route::middleware('auth:api')->group(function () {
    Route::get('/me', [AuthController::class, 'me']);

    Route::post('/semester-goals', [SemesterGoalController::class, 'store']);
    Route::get('/semester-goals', [SemesterGoalController::class, 'index']);

    Route::get('/show-classplan', [LearningPlanController::class, 'getClassPlans']);
    Route::get('/show-selfstudyplan', [LearningPlanController::class, 'getSelfStudyPlans']);
});

/*
|--------------------------------------------------------------------------
| Admin Routes (CheckAdmin middleware)
|--------------------------------------------------------------------------
*/
Route::middleware(CheckAdmin::class)->group(function () {
    Route::post('/class', [ClassController::class, 'create']);
    Route::post('/class/{id}/students', [ClassController::class, 'addStudentToClass']);
    Route::post('/semesters/{id}/subject', [SubjectController::class, 'storeBySemester']);
});

Route::get('/semesters/{id}/subjects', [SemesterController::class, 'getSubjectsBySemester']);

/*
|--------------------------------------------------------------------------
| Weekly Routes
|--------------------------------------------------------------------------
*/
Route::post('/weekly-tracking', [WeeklyController::class, 'createWeeklyTracking']);
Route::post('/weekly-goal', [WeeklyController::class, 'createWeeklyGoal']);
Route::put('/weekly-goal/{id}', [WeeklyController::class, 'updateWeeklyGoalStatus']);

/*
|--------------------------------------------------------------------------
| Help Request Routes
|--------------------------------------------------------------------------
*/

// Route POST để tạo mới help request
Route::post('/help-requests', [HelpRequestController::class, 'store']);

// Thêm route GET nếu bạn cần lấy danh sách
Route::get('/help-requests', [HelpRequestController::class, 'index']);
