<?php

use Illuminate\Support\Facades\Route;
use Moimenta84\LaraAuth\Http\Controllers\AuthController;

Route::middleware(['web', 'guest'])->group(function () {
  $prefix = config('laraauth.routes.prefix', 'auth');

  Route::get($prefix . '/social/{provider}/demo', [AuthController::class, 'demoSocialCallback'])->name('laraauth.social.demo');
});
