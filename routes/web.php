<?php

use App\Mail\CommentAddedMail;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\PostController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\CommentsController;
use App\Http\Controllers\Auth\RegisteredUserController;

Route::get('/', [RegisteredUserController::class, 'create'])->name('register');

Route::middleware(['auth', 'verified'])->group(function () {

Route::get('/home', [PostController::class, 'home'])->name('home');

Route::resource('posts',PostController::class);

Route::post('/comments/store/{post_id}', [CommentsController::class, 'storeComment'])->name('comments.store');
Route::delete('/comments/{comment}', [CommentsController::class, 'destroyComment'])->name('comments.destroy');
Route::put('/comments/{comment}', [CommentsController::class, 'updateComment'])->name('comments.update');

});


require __DIR__.'/auth.php';
