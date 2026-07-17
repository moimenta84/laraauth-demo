# Personalización

## CSS / Tailwind

El paquete usa Tailwind CSS vía CDN por defecto. Puedes:

1. Publicar las vistas y modificar los estilos directamente
2. Instalar Tailwind en tu proyecto y cambiar el CDN por tu build local
3. Sobrescribir el layout `auth.blade.php` en `resources/views/vendor/laraauth/layouts/`

## Traducciones

Añade keys en `resources/lang/vendor/laraauth/`:

```php
// resources/lang/vendor/laraauth/es/auth.php
return [
    'failed' => 'Estas credenciales no coinciden con nuestros registros.',
    'throttle' => 'Demasiados intentos. Intenta de nuevo en :seconds segundos.',
    'invalid_otp' => 'Código incorrecto.',
    'otp_locked' => 'Demasiados intentos. Espera :minutes minutos.',
    'otp_throttle' => 'Demasiados intentos OTP. Intenta de nuevo en :seconds segundos.',
    'register_throttle' => 'Demasiados registros desde esta IP. Espera :minutes minutos.',
    'email_not_found' => 'No encontramos una cuenta con ese email.',
];
```

## Proveedores OTP

Para agregar un proveedor SMS personalizado, extiende `OTPService`:

```php
use Moimenta84\LaraAuth\Services\OTPService;

class MiOTPService extends OTPService
{
    protected function sendCustom(string $phone, string $code): bool
    {
        // Tu lógica aquí
        return true;
    }
}
```

## Eventos

El paquete dispara estos eventos que puedes escuchar:

- `\Moimenta84\LaraAuth\Events\OTPSent`
- `\Moimenta84\LaraAuth\Events\OTPVerified`
- `\Moimenta84\LaraAuth\Events\OTPFailed`

```php
// En EventServiceProvider
protected $listen = [
    \Moimenta84\LaraAuth\Events\OTPVerified::class => [
        \App\Listeners\LogOTPVerification::class,
    ],
];
```
