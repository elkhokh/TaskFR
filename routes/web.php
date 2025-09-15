<?php

use App\Mail\CommentAddedMail;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\PostController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\CommentsController;
use App\Http\Controllers\Auth\RegisteredUserController;
use Laravel\Socialite\Facades\Socialite;
use App\Http\Controllers\Auth\SocialLoginController;


Route::get('/', [RegisteredUserController::class, 'create'])->name('register');

//variable login with (facebook,google)
Route::get('/auth/{provider}/redirect',[SocialLoginController::class,'redirectToProvider'])->name('auth.provider.redirect');
Route::get('/auth/{provider}/callback',[SocialLoginController::class,'handlePorviderCallback'])->name('auth.provider.callback');

//google
// Route::get('/auth/google/redirect',[SocialLoginController::class,'redirectToGoogle'])->name('auth.google.redirect');
// Route::get('/auth/google/callback',[SocialLoginController::class,'handleGoogleCallback'])->name('auth.google.callback');

//facebook
// Route::get('/auth/facebook/redirect', [SocialLoginController::class, 'redirectToFacebook'])->name('auth.facebook.redirect');
// Route::get('/auth/facebook/callback', [SocialLoginController::class, 'handleFacebookCallback'])->name('auth.facebook.callback');


Route::middleware(['auth', 'verified'])->group(function () {

Route::get('/home', [PostController::class, 'home'])->name('home');

Route::resource('posts',PostController::class);

Route::post('/comments/store/{post_id}', [CommentsController::class, 'storeComment'])->name('comments.store');
Route::delete('/comments/{comment}', [CommentsController::class, 'destroyComment'])->name('comments.destroy');
Route::put('/comments/{comment}', [CommentsController::class, 'updateComment'])->name('comments.update');

});

require __DIR__.'/auth.php';
