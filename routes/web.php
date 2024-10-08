<?php

use App\Http\Controllers\UserController;
use App\Http\Middleware\TokenVerificationMiddleware;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/registrationPage',[UserController::class,'registrationPage']);
Route::get('/loginPage',[UserController::class,'loginPage']);
Route::get('/otp-send-page',[UserController::class,'otpCodeSend']);
Route::get('/verify-OTP',[UserController::class,'verifyOTPPage']);
Route::get('/resetPasswordPage',[UserController::class,'resetPasswordPage'])->middleware([TokenVerificationMiddleware::class]);
Route::get('/dashboard',[UserController::class, 'dashboard'])->middleware([TokenVerificationMiddleware::class]);
Route::get('/user-profile',[UserController::class, 'userProfile'])->middleware([TokenVerificationMiddleware::class]);
Route::get('/userLogout',[UserController::class, 'UserLogout']);

// User Profile
Route::get('/userProfile',[userController::class, 'userProfileDetails'])->middleware([TokenVerificationMiddleware::class]);
Route::post('/updateProfile',[userController::class, 'updateProfile'])->middleware([TokenVerificationMiddleware::class]);


Route::post('/user-registration',[UserController::class, 'userRegister']);
Route::post('/user-login',[UserController::class, 'userLogin']);
Route::post('/sent-otp',[UserController::class, 'SentOTPCode']);
Route::post('/verify-otp',[UserController::class, 'VerifyOTP']);

Route::post('/reset-password',[UserController::class, 'ResetPassword'])->middleware([TokenVerificationMiddleware::class]);





