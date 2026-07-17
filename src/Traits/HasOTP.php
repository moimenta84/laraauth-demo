<?php

namespace Moimenta84\LaraAuth\Traits;

use Carbon\Carbon;
use Illuminate\Support\Facades\Log;

trait HasOTP
{
  public function generateOTP(): string
  {
    $digits = config('laraauth.otp.digits', 6);
    $code = '';

    for ($i = 0; $i < $digits; $i++) {
      $code .= random_int(0, 9);
    }

    $expiresMinutes = config('laraauth.otp.expires_minutes', 10);

    $this->forceFill([
      'otp_code' => $code,
      'otp_expires_at' => Carbon::now()->addMinutes($expiresMinutes),
      'otp_attempts' => 0,
      'otp_locked_until' => null,
    ])->save();

    Log::debug("[LaraAuth] OTP generado para {$this->email}: {$code}");

    return $code;
  }

  public function verifyOTP(string $code): bool
  {
    if ($this->isOTPLocked()) {
      return false;
    }

    if (!$this->otp_code || !$this->otp_expires_at) {
      return false;
    }

    if (Carbon::now()->greaterThan($this->otp_expires_at)) {
      $this->incrementOTPAttempts();
      return false;
    }

    if (!hash_equals($this->otp_code, $code)) {
      $this->incrementOTPAttempts();
      return false;
    }

    $this->forceFill([
      'otp_code' => null,
      'otp_expires_at' => null,
      'otp_attempts' => 0,
      'otp_locked_until' => null,
      'phone_verified_at' => $this->phone_verified_at ?? Carbon::now(),
    ])->save();

    return true;
  }

  public function isOTPLocked(): bool
  {
    if (!$this->otp_locked_until) {
      return false;
    }

    if (Carbon::now()->lessThan($this->otp_locked_until)) {
      return true;
    }

    $this->forceFill([
      'otp_attempts' => 0,
      'otp_locked_until' => null,
    ])->save();

    return false;
  }

  public function incrementOTPAttempts(): void
  {
    $maxAttempts = config('laraauth.otp.max_attempts', 5);
    $lockoutMinutes = config('laraauth.otp.lockout_minutes', 15);

    $this->increment('otp_attempts');

    if ($this->otp_attempts >= $maxAttempts) {
      $this->forceFill([
        'otp_locked_until' => Carbon::now()->addMinutes($lockoutMinutes),
      ])->save();
    }
  }

  public function hasVerifiedPhone(): bool
  {
    return !is_null($this->phone_verified_at);
  }

  public function markPhoneAsVerified(): void
  {
    $this->forceFill([
      'phone_verified_at' => $this->phone_verified_at ?? Carbon::now(),
    ])->save();
  }
}
