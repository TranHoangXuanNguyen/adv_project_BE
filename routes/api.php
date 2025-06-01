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
    ImageController,
    SemesterGoalController,
    RequestHelpController,
    HelpRequestController,
    NotifyController,
    ManagerController,
    ManagerClassController
};
use App\Http\Middleware\CheckAdmin;
use App\Http\Controllers\Api\ClassMateController;



/*
|--------------------------------------------------------------------------
| Manager Routes
|--------------------------------------------------------------------------
*/
Route::get('/quantity/{id}', [ManagerClassController::class, 'countWeekByClass']);





/*
|--------------------------------------------------------------------------
| Public Routes (No middleware)
|--------------------------------------------------------------------------
*/

//Route::post('/create', [AuthController::class, 'create']); // ch sua
//Route::post('/auth/login', [AuthController::class, 'login']); // "/login -> /auth/login"
//Route::post('/auth/logout', [AuthController::class, 'logout']); // "/logout -> /auth/logout"
//Route::post('/auth/refresh', [AuthController::class, 'refresh']); // "/refresh -> /auth/refresh"
//Route::post('/auth/fcm-token', [AuthController::class, 'saveFcmToken']); // "/fcm-token -> /auth/fcm-token"
//Route::get('/check-admin', function () {
Route::post('/create', [AuthController::class, 'create']);
Route::post('/login', [AuthController::class, 'login']);
Route::post('/logout', [AuthController::class, 'logout']);
Route::post('/refresh', [AuthController::class, 'refresh']);
Route::post('/fcm-token', [AuthController::class, 'saveFcmToken'])->middleware('auth:api');
Route::post('/send-notification', [AuthController::class, 'sendNotification']);
Route::get('/hello', function () {
    return response()->json(['message' => 'Hello from the API!']);
})->middleware(CheckAdmin::class); // "/hello -> /check-admin"

//Route::get('/users/{role}', [UserController::class, 'getByRole']); // ko sua
//Route::post('/users/new', [UserController::class, 'store']); // "/users -> /users/new"
//Route::get('/class', [ClassController::class, 'getAll']); // ko sua
//Route::get('/class/current-semester/{id}', [ClassController::class, 'getLastestSemester']); // "/class/lastest-semester/{id} -> /class/current-semester/{id}"
//Route::get('/class/{id}', [ClassController::class, 'getClassInfor']); // "/students/{id}/class-info -> /class/{id}"

//Route::get('/classplan', [ClassController::class, 'index']); // chua sua
//Route::post('/classplan', [ClassController::class, 'storeClassPlan']); // chua sua

//Route::get('/week/goals/{id}', [WeeklyController::class, 'getWeeklyByid']); // "/weekly-goals/{id} -> /week/goals/{id}"
//Route::get('/week/class-plan', [WeeklyController::class, 'getClassPlan']); // "/weekly/class-plan -> /week/class-plan"

//Route::get('self-study-plans', [SelfStudyPlanController::class, 'index']); //  chua
//Route::get('self-study-plans/week/{weekTrackId}', [SelfStudyPlanController::class, 'getByWeekTrack']); // chua
//Route::post('/week/seft-study', [SelfStudyPlanController::class, 'store']); // "self-study-plans -> /week/seft-study"
Route::get('/users/{role}', [UserController::class, 'getByRole']);
Route::post('/users', [UserController::class, 'store']);
Route::post('/class/{id}/semester', [SemesterController::class, 'createNewSemester']);
Route::delete('/users/{is}',[UserController::class,'destroy']);
Route::get('/users/{role}/paginate', [UserController::class, 'getPaginatedByRole']);


Route::get('/class', [ClassController::class, 'getAll']);
Route::get('/class/{id}/students', [ClassController::class, 'getStudentInClass']);
Route::get('/class/lastest-semester/{id}', [ClassController::class, 'getLastestSemester']);
Route::get('/students/{id}/class-info', [ClassController::class, 'getClassInfor']);

//Route::get('/classplan', [ClassController::class, 'index']);
Route::post('/classplan', [ClassController::class, 'storeClassPlan']);
Route::get('/weekly-goals/{user_id}/{semester_id}', [WeeklyController::class, 'getWeeklyById']);
Route::get('/weekly-info/{user_id}/', [WeeklyController::class, 'getWeeklyName']);
Route::get('/weekly/class-plan', [WeeklyController::class, 'getClassPlan']);
Route::get('/weekly/self-plan', [SelfStudyPlanController::class, 'index']);
Route::get('self-study-plans/week/{weekTrackId}', [SelfStudyPlanController::class, 'getByWeekTrack']);
Route::post('/weekly/self-plan', [SelfStudyPlanController::class, 'store']);

/*
|--------------------------------------------------------------------------
| Protected Routes (auth:api middleware)
|--------------------------------------------------------------------------
*/
Route::middleware('auth:api')->group(function () {
   // Route::get('/users/me', [AuthController::class, 'me']); // "//me -> /users/me"
//
   // Route::post('/semester-goals', [SemesterGoalController::class, 'store']); // chua
   // Route::get('/semester-goals', [SemesterGoalController::class, 'index']); // chua
    Route::get('/me', [AuthController::class, 'me']);
    Route::put('/semester-goals', [SemesterGoalController::class, 'store']);
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
   // Route::post('/create/class', [ClassController::class, 'create']); // "/class -> /create"
   // Route::post('/class/{id}/students', [ClassController::class, 'addStudentToClass']); // da them

   // Route::post('/semesters/{id}/subject', [SubjectController::class, 'storeBySemester']); // da them
    Route::post('/class', [ClassController::class, 'create']);
    Route::post('/class/{id}/students', [ClassController::class, 'addStudentToClass']);
    Route::post('/semesters/{id}/subject', [SubjectController::class, 'storeBySemester']);
});

Route::get('/semesters/{id}/subjects', [SemesterController::class, 'getSubjectsBySemester']); // da sua

/*
|--------------------------------------------------------------------------
| Weekly Routes
|--------------------------------------------------------------------------
*/
Route::post('/weekly-tracking', [WeeklyController::class, 'createWeeklyTracking']);
//Route::post('/week/goal', [WeeklyController::class, 'createWeeklyGoal']); // "/weekly-goal -> /week/goal"
//Route::put('/week/goal/{id}', [WeeklyController::class, 'updateWeeklyGoalStatus']); // "/weely-goal/{id} -> /week/goal/{id}"

Route::get('/images', [ImageController::class, 'index']);
Route::post('/images', [ImageController::class, 'store']);
Route::delete('/images/{id}', [ImageController::class, 'destroy']);
Route::post('/weekly-goal', [WeeklyController::class, 'createWeeklyGoal']);
Route::put('/weekly-goal/{id}', [WeeklyController::class, 'updateWeeklyGoalStatus']);
Route::get('/requesthelp',[RequestHelpController::class,'getRequest']);
Route::post('/requesthelp',[RequestHelpController::class,'saveRequestHelp']);
Route::delete('/requesthelp/{id}', [RequestHelpController::class, 'deleteRequestHelp']);
Route::get('/requesthelp/paginate', [RequestHelpController::class, 'paginate']);
/*
|--------------------------------------------------------------------------
| Help Request Routes
|--------------------------------------------------------------------------
*/

// Route POST để tạo mới help request
Route::post('/help-requests', [HelpRequestController::class, 'store']);
Route::post('/users',[UserController::class,'store']);
Route::get('/class/student/{id}', [ClassMateController::class, 'getStudents']);
Route::get('/students', [ClassMateController::class, 'getAllStudents']);
Route::get('/help-requests', [HelpRequestController::class, 'index']);


/*
|--------------------------------------------------------------------------
| Notification Routes
|--------------------------------------------------------------------------
*/

Route::get('/notification/{id}', [NotifyController::class, 'getNotifyById']);
Route::post('/remind', [NotifyController::class, 'remindDeadline']);



