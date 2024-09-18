<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\PostController;
use App\Http\Controllers\LikeController;
use App\Http\Controllers\CommentController;
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

Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});

/// User Routes
Route::prefix('user')->group(function () {
    Route::post('register', [AuthController::class, 'register']);
    Route::post('login', [AuthController::class, 'login']);
    Route::post('update', [AuthController::class, 'update'])->middleware('auth:api');
    Route::delete('delete', [AuthController::class, 'delete'])->middleware('auth:api');
    Route::get('profile', [AuthController::class, 'me'])->middleware('auth:api');
});

// Post Routes
Route::middleware('auth:api')->prefix('post')->group(function () {
    Route::get('index', [PostController::class, 'index'])->middleware('auth:api');
    Route::post('store', [PostController::class, 'store'])->middleware('auth:api');
    Route::post('update/{id}', [PostController::class, 'update'])->middleware('auth:api');
    Route::delete('delete/{id}', [PostController::class, 'destroy'])->middleware('auth:api');
});

// Like Routes
Route::post('like-disLike/{postId}', [LikeController::class, 'likeDisLike'])->middleware('auth:api');
Route::get('user-liked-post/{postId}', [LikeController::class, 'show'])->middleware('auth:api');

// Comment Routes
Route::prefix('comment')->group(function () {
    Route::get('show/{postId}', [CommentController::class, 'show'])->middleware('auth:api');
    Route::post('store', [CommentController::class, 'store'])->middleware('auth:api');
    Route::post('update/{id}', [CommentController::class, 'update'])->middleware('auth:api');
    Route::delete('delete/{id}', [CommentController::class, 'destroy'])->middleware('auth:api');
});
