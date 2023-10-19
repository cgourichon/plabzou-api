<?php

use App\Http\Controllers\API\Auth\AuthController;
use App\Http\Controllers\API\Category\CategoryController;
use App\Http\Controllers\API\Conversation\ConversationController;
use App\Http\Controllers\API\City\CityController;
use App\Http\Controllers\API\Course\CourseController;
use App\Http\Controllers\API\Learner\LearnerController;
use App\Http\Controllers\API\Message\MessageController;
use App\Http\Controllers\API\Mode\ModeController;
use App\Http\Controllers\API\Promotion\PromotionController;
use App\Http\Controllers\API\Request\RequestController;
use App\Http\Controllers\API\Room\RoomController;
use App\Http\Controllers\API\Status\StatusController;
use App\Http\Controllers\API\Teacher\TeacherController;
use App\Http\Controllers\API\Timeslot\TimeslotController;
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
Route::apiResource('requests', RequestController::class);


Route::prefix('auth')->group(static function () {
    Route::post('login', [AuthController::class, 'login']);
    Route::middleware('auth:sanctum')->post('logout', [AuthController::class, 'logout']);
    Route::middleware('auth:sanctum')->get('me', [AuthController::class, 'getAuthenticatedUser']);
});

Route::middleware('auth:sanctum')->group(static function () {
    Route::patch('/users/me', [UserController::class, 'updateCurrent']);
    Route::apiResource('users', UserController::class);
    Route::apiResource('promotions', PromotionController::class);
    Route::apiResource('messages', MessageController::class);
    Route::get('statuses', [StatusController::class, 'index']);
    Route::get('modes', [ModeController::class, 'index']);
    Route::apiResource('categories', CategoryController::class);
    Route::apiResource('courses', CourseController::class);
    Route::apiResource('trainings', TrainingController::class);
    Route::apiResource('timeslots', TimeslotController::class);
    Route::get('/rooms', [RoomController::class, 'index']);
    Route::get('/learners', [LearnerController::class, 'index']);
    Route::get('/teachers', [TeacherController::class, 'index']);
    Route::get('/cities', [CityController::class, 'index']);
});
