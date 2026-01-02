<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\CommentController;
use App\Http\Controllers\PostController;
use App\Http\Controllers\ReportController;
use App\Http\Controllers\UserController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::post('/register', [AuthController::class, 'register']);
Route::post('/login', [AuthController::class, 'login']);
Route::middleware('auth:sanctum')->post('/logout', [AuthController::class, 'logout']);

// ---
Route::middleware('auth:sanctum')->group(function () {
    Route::get('/user', fn(Request $r) => $r->user());

    Route::get('posts', [PostController::class, 'index']);
    Route::get('posts/{id}', [PostController::class, 'show']);
    Route::post('posts', [PostController::class, 'store']);
    Route::put('posts/{id}', [PostController::class, 'update']);
    Route::delete('posts/{id}', [PostController::class, 'destroy']);
    Route::post('posts/{id}/like', [PostController::class, 'toggleLike']);
    Route::post('posts/{id}/report', [ReportController::class, 'reportPost']);

    Route::get('posts/{postId}/comments', [CommentController::class, 'index']);
    Route::post('posts/{postId}/comments', [CommentController::class, 'store']);
    Route::put('comments/{id}', [CommentController::class, 'update']);
    Route::delete('comments/{id}', [CommentController::class, 'destroy']);

    // Route::get('users', [UserController::class, 'index']);
    // Route::get('users/{id}', [UserController::class, 'show']);
    // Route::post('users/{id}/ban', [UserController::class, 'ban']);
    // Route::post('users/{id}/unban', [UserController::class, 'unban']);
    // Route::post('users/{id}/report', [UserController::class, 'report']);

    // Route::get('reports', [ReportController::class, 'index']);
    // Route::get('reports/{id}', [ReportController::class, 'show']);
    // Route::delete('reports/{id}', [ReportController::class, 'destroy']);
});
