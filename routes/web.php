<?php

use App\Http\Controllers\LoginWithOTPController;
use App\Http\Controllers\SocialiteController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UserController;
use App\Http\Controllers\PermissionController;
//use Illuminate\Support\Str;


Route::resource('admin/permission', PermissionController::class);

Route::get('/', function () {
    return view('welcome');
});

// web.php

Route::get('/users/data', [UserController::class, 'getUsersData'])->name('admin.user.data');
Route::get('/admin/users/{user}/edit', [UserController::class, 'edit'])->name('admin.users.edit');
Route::prefix('admin')->name('admin.')->group(function () {
    Route::resource('users', UserController::class);
});



// Login with OTP Routes
Route::prefix('/otp')->middleware('guest')->name('otp.')->controller(LoginWithOTPController::class)->group(function(){
    Route::get('/login','login')->name('login');
    Route::post('/generate','generate')->name('generate');
    Route::get('/verification/{userId}','verification')->name('verification');
    Route::post('login/verification','loginWithOtp')->name('loginWithOtp');
});




// Socialite Routes
Route::prefix('oauth/')->group(function(){
    Route::prefix('/github/login')->name('github.')->group(function(){
        Route::get('/',[SocialiteController::class,'redirectToGithub'])->name('login');
        Route::get('/callback',[SocialiteController::class,'HandleGithubCallBack'])->name('callback');
    });

    Route::prefix('/google/login')->name('google.')->group(function(){
        Route::get('/',[SocialiteController::class,'redirectToGoogle'])->name('login');
        Route::get('/callback',[SocialiteController::class,'HandleGoogleCallBack'])->name('callback');        
    });

    Route::prefix('/facebook/login')->name('facebook.')->group(function(){
        Route::get('/',[SocialiteController::class,'redirectToFaceBook'])->name('login');
        Route::get('/callback',[SocialiteController::class,'HandleFaceBookCallBack'])->name('callback');
    });
});



// Auth routes
require __DIR__.'/auth.php';
// Admin Routes
require('admin.php');
