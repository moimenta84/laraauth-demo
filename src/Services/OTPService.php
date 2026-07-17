<?php

namespace Moimenta84\LaraAuth\Services;

use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Log;
use Moimenta84\LaraAuth\Models\OTPLog;

class OTPService
{
  public function send(string $phone, string $code): bool
  {
    $provider = config('laraauth.otp.provider', 'log');

    return match ($provider) {
      'twilio' => $this->sendTwilio($phone, $code),
      'vonage' => $this->sendVonage($phone, $code),
      default => $this->sendLog($phone, $code),
    };
  }

  protected function sendLog(string $phone, string $code): bool
  {
    Log::info("[LaraAuth] SMS enviado a {$phone}: {$code}");
    return true;
  }

  protected function sendTwilio(string $phone, string $code): bool
  {
    // Pendiente: integración con Twilio SDK
    // $twilio = new \Twilio\Rest\Client($sid, $token);
    // $twilio->messages->create($phone, [
    //   'from' => config('laraauth.otp.twilio_from'),
    //   'body' => "Tu código de verificación es: {$code}",
    // ]);
    Log::info("[LaraAuth] Twilio no implementado aún. Código para {$phone}: {$code}");
    return true;
  }

  protected function sendVonage(string $phone, string $code): bool
  {
    Log::info("[LaraAuth] Vonage no implementado aún. Código para {$phone}: {$code}");
    return true;
  }

  public function canResend(string $identifier): bool
  {
    $key = "laraauth_otp_resend_{$identifier}";
    $lastSent = Cache::get($key);

    if (!$lastSent) return true;

    $resendSeconds = config('laraauth.otp.resend_seconds', 30);
    return now()->diffInSeconds($lastSent) >= $resendSeconds;
  }

  public function markSent(string $identifier): void
  {
    $key = "laraauth_otp_resend_{$identifier}";
    Cache::put($key, now(), now()->addDay());
  }
}
