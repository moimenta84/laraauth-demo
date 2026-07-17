<?php

namespace Moimenta84\LaraAuth\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class OTPVerified
{
  public function handle(Request $request, Closure $next)
  {
    if (!config('laraauth.methods.otp', true)) {
      return $next($request);
    }

    $user = Auth::user();

    if ($user && !$user->hasVerifiedPhone() && $user->phone) {
      return redirect()->route('laraauth.otp.show');
    }

    return $next($request);
  }
}
