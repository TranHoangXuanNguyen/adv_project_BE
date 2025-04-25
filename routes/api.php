<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\AuthController;
use App\Http\Middleware\CheckAdmin;
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
Route::post('/register', [AuthController::class, 'register']);
Route::post('/login', [AuthController::class, 'login']);
Route::post('/logout', [AuthController::class, 'logout']);
Route::post('/refresh', [AuthController::class, 'refresh']);
Route::get('/me', [AuthController::class, 'me'])->middleware('auth:api');

Route::get('/hello', function () {
    return response()->json(['message' => 'Hello from the API! (Authenticated access might be needed for some routes)']);
});

Route::get('/hello', function () {
    return response()->json(['message' => 'Hello from the API!']);
})->middleware(CheckAdmin::class);;

// Add other API routes that might require authentication here,
// using the 'auth:api' middleware.
Route::get('/protected', function () {
    return response()->json(['message' => 'This route is protected by JWT!']);
})->middleware('auth:api');
