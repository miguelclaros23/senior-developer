<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\AuthController;
use App\Http\Controllers\Api\TaskController;

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:api');


Route::prefix('auth')->middleware('auth:api')->group(function () {
    Route::post('logout',    [AuthController::class, 'logout']);
    Route::post('refresh',   [AuthController::class, 'refresh']);
    Route::post('me',        [AuthController::class, 'me']);
    Route::apiResource('tasks', TaskController::class);
});
Route::get('subtask/{id}',    [TaskController::class, 'subtask']);
Route::post('auth/login', [AuthController::class, 'login']);
Route::post('register',   [AuthController::class, 'register']);

