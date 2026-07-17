<?php

namespace Moimenta84\LaraAuth\Tests;

use Orchestra\Testbench\TestCase;
use Moimenta84\LaraAuth\LaraAuthServiceProvider;

class BasicTest extends TestCase
{
  protected function getPackageProviders($app): array
  {
    return [LaraAuthServiceProvider::class];
  }

  protected function getEnvironmentSetUp($app): void
  {
    $app['config']->set('laraauth.otp.digits', 6);
    $app['config']->set('laraauth.otp.expires_minutes', 10);
  }

  public function test_config_is_loaded(): void
  {
    $this->assertEquals(6, config('laraauth.otp.digits'));
    $this->assertEquals(10, config('laraauth.otp.expires_minutes'));
  }

  public function test_password_strength_service(): void
  {
    $service = new \Moimenta84\LaraAuth\Services\PasswordStrength();

    $weak = $service->validate('abc');
    $this->assertFalse($weak['valid']);
    $this->assertEquals(0, $weak['score']);

    $strong = $service->validate('Str0ng!Pass');
    $this->assertTrue($strong['valid']);
    $this->assertEquals(4, $strong['score']);
  }
}
