<?php
use App\Http\Controllers\Api\SemesterGoalController;
use App\Http\Controllers\Api\UserController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\AuthController;
use App\Http\Controllers\Api\ClassController;
use App\Http\Controllers\Api\SelfStudyPlanController;
use App\Http\Middleware\CheckAdmin;
use App\Http\Controllers\Api\SubjectController;
/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the app.php in bootstrap folder within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/
// Add more API routes here
Route::post('/create', [AuthController::class, 'create']);
Route::post('/login', [AuthController::class, 'login']);
Route::post('/logout', [AuthController::class, 'logout']);
Route::post('/refresh', [AuthController::class, 'refresh']);
Route::get('/me', [AuthController::class, 'me'])->middleware('auth:api');
Route::get('/hello', function () {
    return response()->json(['message' => 'Hello from the API!']);
})->middleware(CheckAdmin::class);;
Route::get('/protected', function () {
    return response()->json(['message' => 'This route is protected by JWT!']);
})->middleware('auth:api');
Route::post('/users',[UserController::class,'store']);
Route::get('/class',[ClassController::class,'getAll']);
Route::post('/class',[ClassController::class,'create'])->middleware(CheckAdmin::class);
Route::get('/class',[ClassController::class,'getAll']);
Route::get('/class/lastest-semester/{id}', [ClassController::class, 'getLastestSemester']);
Route::get('/class',[ClassController::class,'getAll']);
// GET danh sách
Route::get('self-study-plans', [SelfStudyPlanController::class, 'index']);
// POST tạo mới
Route::post('self-study-plans', [SelfStudyPlanController::class, 'store']);
// GET theo week_track_id
Route::get('self-study-plans/week/{weekTrackId}', [SelfStudyPlanController::class, 'getByWeekTrack']);
Route::get('/users/{role}', [UserController::class, 'getByRole']);
Route::post('/class/{id}/students',[ClassController::class,'addStudentToClass'])->middleware(CheckAdmin::class);
Route::post('/semesters/{id}/subject',[SubjectController::class,'storeBySemester'])->middleware(CheckAdmin::class);
Route::middleware('auth:api')->group(function () {
    // Route::get('/week/class-plan', [WeekPlanController::class, 'getClassPlanByWeek']);
    // Route::get('/week/self-study', [WeekPlanController::class, 'getSelfStudyByWeek']);
    Route::post('/semester-goals', [SemesterGoalController::class, 'store']);
    Route::get('/semester-goals', [SemesterGoalController::class, 'index']);
});
Route::post('/classplan',[ClassController::class,'storeClassPlan']);
Route::get('/classplan', [ClassController::class, 'index']);
