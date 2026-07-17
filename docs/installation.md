# Instalación

## 1. Requisitos

- PHP 8.2+
- Laravel 11.x o 12.x
- Composer 2.x
- Base de datos (MySQL, PostgreSQL o SQLite)

## 2. Instalar vía Composer

```bash
composer require moimenta84/laraauth
```

## 3. Publicar assets

```bash
# Publicar configuración
php artisan vendor:publish --tag=laraauth-config

# Publicar migraciones
php artisan vendor:publish --tag=laraauth-migrations

# Publicar vistas (opcional — para personalizar)
php artisan vendor:publish --tag=laraauth-views
```

## 4. Ejecutar migraciones

```bash
php artisan migrate
```

## 5. Configurar servicios externos

### Email (para password reset)
Configura tu driver de email en `.env`:
```env
MAIL_MAILER=smtp
MAIL_HOST=sandbox.smtp.mailtrap.io
MAIL_PORT=2525
MAIL_USERNAME=...
MAIL_PASSWORD=...
```

### OTP por SMS (opcional)
En `config/laraauth.php`:
```php
'otp' => [
    'provider' => 'twilio', // 'twilio' | 'vonage' | 'log' (por defecto solo log)
    'twilio_from' => '+1234567890',
],
```

Agrega en `.env`:
```env
TWILIO_SID=...
TWILIO_TOKEN=...
TWILIO_FROM=+1234567890
```

### Social Login (opcional)
En `config/services.php`:
```php
'google' => [
    'client_id' => env('GOOGLE_CLIENT_ID'),
    'client_secret' => env('GOOGLE_CLIENT_SECRET'),
    'redirect' => '/auth/social/google/callback',
],

'facebook' => [
    'client_id' => env('FACEBOOK_CLIENT_ID'),
    'client_secret' => env('FACEBOOK_CLIENT_SECRET'),
    'redirect' => '/auth/social/facebook/callback',
],
```

## 6. Agregar el trait a tu modelo User

Agrega el trait `HasOTP` y las relaciones a tu `App\Models\User`:

```bash
# Puedes publicar un stub de ejemplo:
php artisan vendor:publish --tag=laraauth-stubs
```

```php
<?php

namespace App\Models;

use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Moimenta84\LaraAuth\Traits\HasOTP;
use Moimenta84\LaraAuth\Models\OTPLog;
use Moimenta84\LaraAuth\Models\SocialLink;
use Moimenta84\LaraAuth\Models\TrustedDevice;

class User extends Authenticatable
{
    use HasOTP, Notifiable;

    protected $fillable = [
        'name', 'email', 'password',
        'phone', 'phone_country_code', 'auth_method',
    ];

    protected function casts(): array
    {
        return [
            'phone_verified_at' => 'datetime',
            'otp_expires_at' => 'datetime',
            'otp_locked_until' => 'datetime',
        ];
    }

    public function otpLogs()
    {
        return $this->hasMany(OTPLog::class);
    }

    public function socialLinks()
    {
        return $this->hasMany(SocialLink::class);
    }

    public function trustedDevices()
    {
        return $this->hasMany(TrustedDevice::class);
    }
}
```

## 7. Proteger rutas con middleware OTP (opcional)

En `routes/web.php`:
```php
Route::middleware(['auth', 'otp.verified'])->group(function () {
    // Rutas que requieren OTP verificado
});
```
