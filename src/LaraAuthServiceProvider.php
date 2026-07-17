<?php

namespace Moimenta84\LaraAuth;

use Illuminate\Support\ServiceProvider;
use Illuminate\Routing\Router;
use Moimenta84\LaraAuth\Http\Middleware\OTPVerified;

class LaraAuthServiceProvider extends ServiceProvider
{
  public function boot(): void
  {
    $this->publishes([
      __DIR__ . '/../config/laraauth.php' => config_path('laraauth.php'),
    ], 'laraauth-config');

    $this->publishes([
      __DIR__ . '/../resources/views' => resource_path('views/vendor/laraauth'),
    ], 'laraauth-views');

    $this->publishes([
      __DIR__ . '/../database/migrations/' => database_path('migrations'),
    ], 'laraauth-migrations');

    $this->publishes([
      __DIR__ . '/../stubs/User.stub' => base_path('stubs/laraauth-user.stub'),
    ], 'laraauth-stubs');

    $this->loadViewsFrom(__DIR__ . '/../resources/views', 'laraauth');
    $this->loadRoutesFrom(__DIR__ . '/../routes/auth.php');

    if (config('laraauth.demo_mode', false) || app()->environment('local')) {
      $this->loadRoutesFrom(__DIR__ . '/../routes/demo.php');
    }

    $router = $this->app->make(Router::class);
    $router->aliasMiddleware('otp.verified', OTPVerified::class);
  }

  public function register(): void
  {
    $this->mergeConfigFrom(__DIR__ . '/../config/laraauth.php', 'laraauth');
  }
}
