<?php

namespace Moimenta84\LaraAuth\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\ValidationException;
use Illuminate\Support\Facades\RateLimiter;

class LoginRequest extends FormRequest
{
  public function authorize(): bool
  {
    return true;
  }

  public function rules(): array
  {
    return [
      'email' => ['required', 'string', 'email', 'max:255'],
      'password' => ['required', 'string'],
      'remember' => ['boolean'],
    ];
  }

  public function ensureIsNotRateLimited(): void
  {
    [$maxAttempts, $perMinutes] = config('laraauth.rate_limit.login', [5, 15]);
    $key = 'login:' . $this->ip();

    if (RateLimiter::tooManyAttempts($key, $maxAttempts)) {
      $seconds = RateLimiter::availableIn($key);

      throw ValidationException::withMessages([
        'email' => __('laraauth::auth.throttle', [
          'seconds' => $seconds,
          'minutes' => ceil($seconds / 60),
        ]),
      ]);
    }
  }

  public function incrementLoginAttempts(): void
  {
    [$maxAttempts, $perMinutes] = config('laraauth.rate_limit.login', [5, 15]);
    $key = 'login:' . $this->ip();

    RateLimiter::hit($key, $perMinutes * 60);
  }

  public function clearLoginAttempts(): void
  {
    $key = 'login:' . $this->ip();
    RateLimiter::clear($key);
  }
}
