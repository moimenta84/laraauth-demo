<?php

namespace Moimenta84\LaraAuth\Services;

use Laravel\Socialite\Facades\Socialite;
use Moimenta84\LaraAuth\Models\SocialLink;
use App\Models\User;

class SocialAuthService
{
  public function redirect(string $provider)
  {
    return Socialite::driver($provider)->redirect();
  }

  public function handleCallback(string $provider): array
  {
    $socialUser = Socialite::driver($provider)->user();

    $link = SocialLink::where('provider', $provider)
      ->where('provider_id', $socialUser->getId())
      ->first();

    if ($link) {
      $user = $link->user;
      return ['action' => 'login', 'user' => $user];
    }

    $user = User::where('email', $socialUser->getEmail())->first();

    if ($user) {
      $user->socialLinks()->create([
        'provider' => $provider,
        'provider_id' => $socialUser->getId(),
        'avatar_url' => $socialUser->getAvatar(),
        'metadata' => $socialUser->getRaw(),
      ]);
      return ['action' => 'link', 'user' => $user];
    }

    $name = $socialUser->getName() ?? $socialUser->getNickname() ?? 'User';
    $email = $socialUser->getEmail();

    if (!$email) {
      return ['action' => 'error', 'message' => 'El proveedor no proporcionó un email.'];
    }

    $user = User::create([
      'name' => $name,
      'email' => $email,
      'password' => bcrypt(str()->random(32)),
      'auth_method' => 'social',
    ]);

    $user->socialLinks()->create([
      'provider' => $provider,
      'provider_id' => $socialUser->getId(),
      'avatar_url' => $socialUser->getAvatar(),
      'metadata' => $socialUser->getRaw(),
    ]);

    return ['action' => 'register', 'user' => $user];
  }
}
