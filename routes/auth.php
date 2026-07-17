<?php

use Illuminate\Support\Facades\Route;
use Moimenta84\LaraAuth\Http\Controllers\AuthController;

$prefix = config('laraauth.routes.prefix', 'auth');
$middleware = config('laraauth.routes.middleware', ['web']);

Route::middleware($middleware)->group(function () use ($prefix) {

  // Guest
  Route::middleware('guest')->group(function () use ($prefix) {
    Route::get($prefix . '/login', [AuthController::class, 'showLogin'])->name('laraauth.login');
    Route::post($prefix . '/login', [AuthController::class, 'login']);
    Route::get($prefix . '/register', [AuthController::class, 'showRegister'])->name('laraauth.register');
    Route::post($prefix . '/register', [AuthController::class, 'register']);
    Route::get($prefix . '/forgot-password', [AuthController::class, 'showForgot'])->name('laraauth.password.request');
    Route::post($prefix . '/forgot-password', [AuthController::class, 'sendResetLink'])->name('laraauth.password.email');
    Route::get($prefix . '/reset-password/{token}', [AuthController::class, 'showReset'])->name('laraauth.password.reset');
    Route::post($prefix . '/reset-password', [AuthController::class, 'reset'])->name('laraauth.password.update');
    Route::get($prefix . '/social/{provider}', [AuthController::class, 'socialRedirect'])->name('laraauth.social.redirect');
    Route::get($prefix . '/social/{provider}/callback', [AuthController::class, 'socialCallback'])->name('laraauth.social.callback');
  });

  // Authenticated
  Route::middleware('auth')->group(function () use ($prefix) {
    Route::post($prefix . '/logout', [AuthController::class, 'logout'])->name('laraauth.logout');
    Route::get($prefix . '/otp', [AuthController::class, 'showOTP'])->name('laraauth.otp.show');
    Route::post($prefix . '/otp/send', [AuthController::class, 'sendOTP'])->name('laraauth.otp.send');
    Route::post($prefix . '/otp/verify', [AuthController::class, 'verifyOTP'])->name('laraauth.otp.verify');
  });

  // AJAX
  Route::post($prefix . '/password-strength', [AuthController::class, 'checkPasswordStrength'])->name('laraauth.password.strength');
});
