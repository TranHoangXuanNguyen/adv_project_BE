<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\{
    AuthController,
    UserController,
    ClassController,
    SubjectController,
    SemesterController,
    WeeklyController,
    SelfStudyPlanController,
    ImageController,
    SemesterGoalController
};
use App\Http\Middleware\CheckAdmin;

/*
|--------------------------------------------------------------------------
| Public Routes (No middleware)
|--------------------------------------------------------------------------
*/

Route::post('/create', [AuthController::class, 'create']); // ch sua
Route::post('/auth/login', [AuthController::class, 'login']); // "/login -> /auth/login"
Route::post('/auth/logout', [AuthController::class, 'logout']); // "/logout -> /auth/logout"
Route::post('/auth/refresh', [AuthController::class, 'refresh']); // "/refresh -> /auth/refresh"
Route::post('/auth/fcm-token', [AuthController::class, 'saveFcmToken']); // "/fcm-token -> /auth/fcm-token"

Route::get('/check-admin', function () {
    return response()->json(['message' => 'Hello from the API!']);
})->middleware(CheckAdmin::class); // "/hello -> /check-admin"

Route::get('/users/{role}', [UserController::class, 'getByRole']); // ko sua
Route::post('/users/new', [UserController::class, 'store']); // "/users -> /users/new"

Route::get('/class', [ClassController::class, 'getAll']); // ko sua
Route::get('/class/current-semester/{id}', [ClassController::class, 'getLastestSemester']); // "/class/lastest-semester/{id} -> /class/current-semester/{id}"
Route::get('/class/{id}', [ClassController::class, 'getClassInfor']); // "/students/{id}/class-info -> /class/{id}"

Route::get('/classplan', [ClassController::class, 'index']); // chua sua
Route::post('/classplan', [ClassController::class, 'storeClassPlan']); // chua sua

Route::get('/week/goals/{id}', [WeeklyController::class, 'getWeeklyByid']); // "/weekly-goals/{id} -> /week/goals/{id}"
Route::get('/week/class-plan', [WeeklyController::class, 'getClassPlan']); // "/weekly/class-plan -> /week/class-plan"

Route::get('self-study-plans', [SelfStudyPlanController::class, 'index']); //  chua
Route::get('self-study-plans/week/{weekTrackId}', [SelfStudyPlanController::class, 'getByWeekTrack']); // chua
Route::post('/week/seft-study', [SelfStudyPlanController::class, 'store']); // "self-study-plans -> /week/seft-study"

/*
|--------------------------------------------------------------------------
| Protected Routes (auth:api middleware)
|--------------------------------------------------------------------------
*/
Route::middleware('auth:api')->group(function () {
    Route::get('/users/me', [AuthController::class, 'me']); // "//me -> /users/me"

    Route::post('/semester-goals', [SemesterGoalController::class, 'store']); // chua
    Route::get('/semester-goals', [SemesterGoalController::class, 'index']); // chua
});

/*
|--------------------------------------------------------------------------
| Admin Routes (CheckAdmin middleware)
|--------------------------------------------------------------------------
*/
Route::middleware(CheckAdmin::class)->group(function () {
    Route::post('/create/class', [ClassController::class, 'create']); // "/class -> /create"
    Route::post('/class/{id}/students', [ClassController::class, 'addStudentToClass']); // da them 

    Route::post('/semesters/{id}/subject', [SubjectController::class, 'storeBySemester']); // da them
});

Route::get('/semesters/{id}/subjects', [SemesterController::class, 'getSubjectsBySemester']); // da sua

/*
|--------------------------------------------------------------------------
| Weekly Routes
|--------------------------------------------------------------------------
*/
Route::post('/weekly-tracking', [WeeklyController::class, 'createWeeklyTracking']);
Route::post('/week/goal', [WeeklyController::class, 'createWeeklyGoal']); // "/weekly-goal -> /week/goal"
Route::put('/week/goal/{id}', [WeeklyController::class, 'updateWeeklyGoalStatus']); // "/weely-goal/{id} -> /week/goal/{id}"

Route::get('/images', [ImageController::class, 'index']);
Route::post('/images', [ImageController::class, 'store']); 
Route::delete('/images/{id}', [ImageController::class, 'destroy']);
