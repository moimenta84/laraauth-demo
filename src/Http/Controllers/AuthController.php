<?php

namespace Moimenta84\LaraAuth\Http\Controllers;

use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Password;
use Illuminate\Support\Facades\RateLimiter;
use Illuminate\Validation\ValidationException;
use Moimenta84\LaraAuth\Http\Requests\LoginRequest;
use Moimenta84\LaraAuth\Http\Requests\RegisterRequest;
use Moimenta84\LaraAuth\Http\Requests\VerifyOTPRequest;
use Moimenta84\LaraAuth\Services\PasswordStrength;
use Moimenta84\LaraAuth\Services\OTPService;
use Moimenta84\LaraAuth\Services\SocialAuthService;

class AuthController extends Controller
{
  // ─── LOGIN ─────────────────────────────────────────────────

  public function showLogin()
  {
    return view('laraauth::components.login');
  }

  public function login(LoginRequest $request)
  {
    $request->ensureIsNotRateLimited();

    if (!Auth::attempt($request->only('email', 'password'), $request->boolean('remember'))) {
      $request->incrementLoginAttempts();
      return back()->withErrors(['email' => __('laraauth::auth.failed')])->onlyInput('email');
    }

    $request->clearLoginAttempts();
    $request->session()->regenerate();

    Auth::user()->forceFill(['auth_method' => 'email'])->save();

    return redirect()->intended(config('laraauth.redirect_after_login', '/dashboard'));
  }

  // ─── REGISTER ──────────────────────────────────────────────

  public function showRegister()
  {
    return view('laraauth::components.register', [
      'countryCodes' => $this->getCountryCodes(),
    ]);
  }

  public function register(RegisterRequest $request)
  {
    $request->ensureIsNotRateLimited();

    $userModel = config('laraauth.user_model');
    $user = $userModel::create([
      'name' => $request->name,
      'email' => $request->email,
      'phone' => $request->phone,
      'phone_country_code' => $request->phone_country_code,
      'password' => bcrypt($request->password),
      'auth_method' => 'email',
    ]);

    Auth::login($user);

    if (config('laraauth.methods.otp')) {
      return redirect()->route('laraauth.otp.show');
    }

    return redirect()->intended(config('laraauth.redirect_after_login', '/dashboard'));
  }

  // ─── OTP ───────────────────────────────────────────────────

  public function showOTP()
  {
    $user = Auth::user();
    if ($user->hasVerifiedPhone()) {
      return redirect()->intended(config('laraauth.redirect_after_login', '/dashboard'));
    }

    $otpService = app(OTPService::class);
    $fullPhone = $user->phone_country_code . ' ' . $user->phone;

    return view('laraauth::components.otp-verification', [
      'phone' => $fullPhone,
      'canResend' => $otpService->canResend($user->email),
      'resendSeconds' => config('laraauth.otp.resend_seconds', 30),
    ]);
  }

  public function sendOTP()
  {
    $user = Auth::user();

    if ($user->hasVerifiedPhone()) {
      return response()->json(['message' => 'Teléfono ya verificado.'], 400);
    }

    $otpService = app(OTPService::class);

    if (!$otpService->canResend($user->email)) {
      return response()->json(['message' => 'Espera antes de solicitar un nuevo código.'], 429);
    }

    $code = $user->generateOTP();
    $otpService->send($user->phone_country_code . $user->phone, $code);
    $otpService->markSent($user->email);

    return response()->json([
      'message' => 'Código enviado.',
      'expires_minutes' => config('laraauth.otp.expires_minutes', 10),
    ]);
  }

  public function verifyOTP(VerifyOTPRequest $request)
  {
    $user = Auth::user();

    $request->ensureIsNotRateLimited($user->email);

    if ($user->isOTPLocked()) {
      return back()->withErrors(['code' => __('laraauth::auth.otp_locked')]);
    }

    if ($user->verifyOTP($request->code)) {
      $request->session()->put('laraauth_otp_verified', true);
      return redirect()->intended(config('laraauth.redirect_after_login', '/dashboard'));
    }

    $request->hitRateLimiter($user->email);

    return back()->withErrors(['code' => __('laraauth::auth.invalid_otp')]);
  }

  // ─── PASSWORD RESET ────────────────────────────────────────

  public function showForgot()
  {
    return view('laraauth::components.forgot-password');
  }

  public function sendResetLink()
  {
    $data = request()->validate(['email' => ['required', 'email', 'exists:users,email']]);

    [$maxAttempts, $perMinutes] = config('laraauth.rate_limit.password_reset', [3, 60]);
    $key = 'password_reset:' . request()->ip();

    if (RateLimiter::tooManyAttempts($key, $maxAttempts)) {
      $seconds = RateLimiter::availableIn($key);
      throw ValidationException::withMessages([
        'email' => __('laraauth::auth.throttle', ['seconds' => $seconds, 'minutes' => ceil($seconds / 60)]),
      ]);
    }

    $status = Password::sendResetLink($data);
    RateLimiter::hit($key, $perMinutes * 60);

    return $status === Password::RESET_LINK_SENT
      ? back()->with('status', __($status))
      : back()->withErrors(['email' => __($status)]);
  }

  public function showReset(string $token)
  {
    return view('laraauth::components.reset-password', [
      'token' => $token,
      'email' => request('email'),
    ]);
  }

  public function reset()
  {
    $data = request()->validate([
      'token' => ['required'],
      'email' => ['required', 'email'],
      'password' => ['required', 'confirmed', 'min:8'],
    ]);

    $status = Password::reset($data, function ($user, $password) {
      $user->forceFill(['password' => bcrypt($password)])->save();
    });

    return $status === Password::PASSWORD_RESET
      ? redirect()->route('laraauth.login')->with('status', __($status))
      : back()->withErrors(['email' => [__($status)]]);
  }

  // ─── SOCIAL AUTH ───────────────────────────────────────────

  public function socialRedirect(string $provider)
  {
    $allowed = config('laraauth.social_providers', []);

    if (!in_array($provider, $allowed)) {
      return redirect()->route('laraauth.login')->withErrors(['provider' => 'Proveedor no soportado.']);
    }

    return app(SocialAuthService::class)->redirect($provider);
  }

  public function socialCallback(string $provider)
  {
    $result = app(SocialAuthService::class)->handleCallback($provider);

    if ($result['action'] === 'error') {
      return redirect()->route('laraauth.login')->withErrors(['email' => $result['message']]);
    }

    Auth::login($result['user']);

    if (config('laraauth.methods.otp')
      && $result['action'] === 'register'
      && $result['user']->phone
      && !$result['user']->hasVerifiedPhone()) {
      return redirect()->route('laraauth.otp.show');
    }

    return redirect()->intended(config('laraauth.redirect_after_login', '/dashboard'));
  }

  // ─── LOGOUT ────────────────────────────────────────────────

  public function logout()
  {
    Auth::guard('web')->logout();
    request()->session()->invalidate();
    request()->session()->regenerateToken();

    return redirect(config('laraauth.redirect_after_logout', '/'));
  }

  // ─── UTILS ─────────────────────────────────────────────────

  public function checkPasswordStrength()
  {
    return response()->json(
      app(PasswordStrength::class)->validate(request('password', ''))
    );
  }

  protected function getCountryCodes(): array
  {
    return [
      ['code' => '+34', 'country' => '🇪🇸', 'name' => 'España'],
      ['code' => '+52', 'country' => '🇲🇽', 'name' => 'México'],
      ['code' => '+54', 'country' => '🇦🇷', 'name' => 'Argentina'],
      ['code' => '+57', 'country' => '🇨🇴', 'name' => 'Colombia'],
      ['code' => '+56', 'country' => '🇨🇱', 'name' => 'Chile'],
      ['code' => '+51', 'country' => '🇵🇪', 'name' => 'Perú'],
      ['code' => '+1', 'country' => '🇺🇸', 'name' => 'EE.UU.'],
      ['code' => '+44', 'country' => '🇬🇧', 'name' => 'Reino Unido'],
    ];
  }
}
