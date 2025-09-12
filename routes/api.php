<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\CommentController;
use App\Http\Controllers\Api\AuthController;
use App\Http\Controllers\Api\PostController;
use App\Http\Controllers\Api\CommentApiController;


Route::post("register", [AuthController::class, "register"]);

Route::post("login", [AuthController::class, "login"]) ->middleware('throttle:5,1');

Route::middleware("auth:sanctum")->group(function () {
    
Route::post("logout", [AuthController::class, "logout"]);

//posts
Route::get('/', [PostController::class, 'home'])->middleware(['auth', 'verified'])->name('home');
Route::apiResource('posts',PostController::class);

//comments
Route::post('/comments/store/{post_id}', [CommentApiController::class, 'storeComment'])->name('comments.store');
Route::delete('/comments/{comment}', [CommentApiController::class, 'destroyComment'])->name('comments.destroy');
Route::put('/comments/{comment}', [CommentApiController::class, 'updateComment'])->name('comments.update');


});














