<?php

namespace Moimenta84\LaraAuth\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rules\Password;
use Illuminate\Support\Facades\RateLimiter;
use Illuminate\Validation\ValidationException;

class RegisterRequest extends FormRequest
{
  public function authorize(): bool
  {
    return true;
  }

  public function rules(): array
  {
    return [
      'name' => ['required', 'string', 'max:255'],
      'email' => ['required', 'string', 'email', 'max:255', 'unique:users,email'],
      'phone' => ['required', 'string', 'max:20'],
      'phone_country_code' => ['required', 'string', 'max:5'],
      'password' => [
        'required',
        'string',
        'confirmed',
        Password::min(8)
          ->mixedCase()
          ->numbers()
          ->symbols(),
      ],
    ];
  }

  public function ensureIsNotRateLimited(): void
  {
    [$maxAttempts, $perMinutes] = config('laraauth.rate_limit.register', [3, 60]);
    $key = 'register:' . $this->ip();

    if (RateLimiter::tooManyAttempts($key, $maxAttempts)) {
      $seconds = RateLimiter::availableIn($key);
      throw ValidationException::withMessages([
        'email' => __('laraauth::auth.register_throttle', [
          'seconds' => $seconds,
          'minutes' => ceil($seconds / 60),
        ]),
      ]);
    }
  }

  public function incrementRegisterAttempts(): void
  {
    [$maxAttempts, $perMinutes] = config('laraauth.rate_limit.register', [3, 60]);
    RateLimiter::hit('register:' . $this->ip(), $perMinutes * 60);
  }
}
