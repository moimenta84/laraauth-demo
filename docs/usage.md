# Uso

## Rutas disponibles

| Método | Ruta | Descripción |
|---|---|---|
| GET | `/auth/login` | Mostrar formulario de login |
| POST | `/auth/login` | Procesar login |
| GET | `/auth/register` | Mostrar formulario de registro |
| POST | `/auth/register` | Procesar registro |
| GET | `/auth/otp` | Mostrar pantalla OTP |
| POST | `/auth/otp/send` | Enviar código OTP |
| POST | `/auth/otp/verify` | Verificar código OTP |
| GET | `/auth/forgot-password` | Mostrar formulario de recuperación |
| POST | `/auth/forgot-password` | Enviar enlace de recuperación |
| GET | `/auth/reset-password/{token}` | Mostrar formulario de nueva contraseña |
| POST | `/auth/reset-password` | Procesar nueva contraseña |
| POST | `/auth/logout` | Cerrar sesión |
| GET | `/auth/social/{provider}` | Redirigir a proveedor social |
| GET | `/auth/social/{provider}/callback` | Callback del proveedor social |
| POST | `/auth/password-strength` | Verificar fortaleza (AJAX) |

## Personalizar vistas

Las vistas se publican en `resources/views/vendor/laraauth/`.

Para anular un componente, crea el mismo archivo en tu proyecto:

```bash
# Ejemplo: personalizar el login
resources/views/vendor/laraauth/components/login.blade.php
```

## Componentes Blade

Puedes usar los componentes directamente en tus vistas:

```blade
<x-laraauth::login />
<x-laraauth::register />
<x-laraauth::otp-verification />
<x-laraauth::forgot-password />
<x-laraauth::reset-password />
```

## Uso del trait HasOTP

```php
$user = User::find(1);

// Generar código
$code = $user->generateOTP();

// Verificar código
if ($user->verifyOTP('123456')) {
    // Código correcto
}

// Comprobar si está bloqueado
if ($user->isOTPLocked()) {
    // Demasiados intentos
}

// Teléfono verificado
if ($user->hasVerifiedPhone()) {
    // OK
}
```
