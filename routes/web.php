<?php

use App\Mail\CommentAddedMail;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\PostController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\CommentsController;


Route::get('/', [PostController::class, 'home'])->middleware(['auth', 'verified'])->name('home');

Route::resource('posts',PostController::class);
Route::post('/comments/store/{post_id}', [CommentsController::class, 'storeComment'])->name('comments.store');
Route::delete('/comments/{comment}', [CommentsController::class, 'destroyComment'])->name('comments.destroy');
Route::put('/comments/{comment}', [CommentsController::class, 'updateComment'])->name('comments.update');


Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__.'/auth.php';
