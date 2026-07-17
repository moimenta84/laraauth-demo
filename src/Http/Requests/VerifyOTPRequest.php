<?php

namespace Moimenta84\LaraAuth\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\RateLimiter;
use Illuminate\Validation\ValidationException;

class VerifyOTPRequest extends FormRequest
{
  public function authorize(): bool
  {
    return true;
  }

  public function rules(): array
  {
    return [
      'code' => ['required', 'string', 'size:' . config('laraauth.otp.digits', 6)],
    ];
  }

  public function ensureIsNotRateLimited(string $identifier): void
  {
    [$maxAttempts, $perMinutes] = config('laraauth.rate_limit.otp_verify', [10, 15]);
    $key = 'otp_verify:' . $identifier;

    if (RateLimiter::tooManyAttempts($key, $maxAttempts)) {
      $seconds = RateLimiter::availableIn($key);
      throw ValidationException::withMessages([
        'code' => __('laraauth::auth.otp_throttle', [
          'seconds' => $seconds,
          'minutes' => ceil($seconds / 60),
        ]),
      ]);
    }
  }

  public function hitRateLimiter(string $identifier): void
  {
    [$maxAttempts, $perMinutes] = config('laraauth.rate_limit.otp_verify', [10, 15]);
    RateLimiter::hit('otp_verify:' . $identifier, $perMinutes * 60);
  }
}
