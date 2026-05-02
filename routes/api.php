<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\ChatController;
use App\Http\Controllers\QuizController;
use Illuminate\Support\Facades\Route;

Route::post('/plan', [QuizController::class, 'generatePlan']);

//guest 
Route::post('/guest/generate', [QuizController::class, 'generateGuest']);

// Auth routes
Route::post('/register', [AuthController::class, 'register']);
Route::post('/login', [AuthController::class, 'login']);

// Protected routes
Route::middleware('auth:sanctum')->group(function () {
    Route::get('/user', [AuthController::class, 'user']);
    Route::post('/logout', [AuthController::class, 'logout']);

    Route::get('/chats', [ChatController::class, 'index']);
    Route::post('/chats', [ChatController::class, 'store']);
    Route::get('/chats/{id}', [ChatController::class, 'show']);
    Route::delete('/chats/{id}', [ChatController::class, 'destroy']);
    Route::post('/chats/{id}/generate', [QuizController::class, 'generate']);
    Route::get('/plans', [QuizController::class, 'getPlans']);
});