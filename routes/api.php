<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\CommentController;
use App\Http\Controllers\PostController;
use App\Http\Controllers\UploadImageController;
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


Route::post('register', [AuthController::class, 'register']);

Route::middleware(['checkBlockedUser'])->group(function () {

    Route::post('login', [AuthController::class, 'login']);

    Route::middleware('auth:api')->group(function () {
        Route::put('/change-password', [AuthController::class, 'changePassword']);
        Route::apiResources(['/posts' => PostController::class]);

        // Create Comment for a Post
        Route::post('/comments', [CommentController::class, 'store']);

        // Reply to a Comment
        Route::post('/reply', [CommentController::class, 'reply']);
    });

    Route::middleware(['auth:api', 'admin'])->group(function () {
        Route::put('/change-role', [AuthController::class, 'changeRole']);
        Route::put('/block-user/{user}', [AuthController::class, 'blockUser']);
    });


});

Route::post('/upload-image', [UploadImageController::class, 'uploadImage']);
