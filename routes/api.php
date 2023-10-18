<?php

use App\Http\Controllers\API\Auth\AuthController;
use App\Http\Controllers\API\Category\CategoryController;
use App\Http\Controllers\API\Course\CourseController;
use App\Http\Controllers\API\Mode\ModeController;
use App\Http\Controllers\API\Status\StatusController;
use App\Http\Controllers\API\Training\TrainingController;
use App\Http\Controllers\API\User\UserController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

Route::prefix('auth')->group(static function () {
    Route::post('login', [AuthController::class, 'login']);
    Route::middleware('auth:sanctum')->post('logout', [AuthController::class, 'logout']);
    Route::middleware('auth:sanctum')->get('me', [AuthController::class, 'getAuthenticatedUser']);
});

Route::middleware('auth:sanctum')->group(static function () {
    Route::apiResource('users', UserController::class);
    Route::get('statuses', [StatusController::class, 'index']);
    Route::get('modes', [ModeController::class, 'index']);
    Route::apiResource('categories', CategoryController::class);
    Route::apiResource('courses', CourseController::class);
    Route::apiResource('trainings', TrainingController::class);
});
