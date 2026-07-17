# Configuración

## Archivo config/laraauth.php

```php
<?php

return [
    // Métodos de autenticación habilitados
    'methods' => [
        'email' => true,    // Login con email + contraseña
        'otp' => true,      // Verificación SMS OTP
        'social' => true,   // Login con Google, Facebook, etc.
    ],

    // Configuración OTP
    'otp' => [
        'digits' => 6,              // Dígitos del código
        'expires_minutes' => 10,     // Tiempo de expiración
        'resend_seconds' => 30,      // Tiempo entre reenvíos
        'max_attempts' => 5,         // Intentos antes de bloqueo
        'lockout_minutes' => 15,     // Duración del bloqueo
    ],

    // Rate limiting
    'rate_limit' => [
        'login' => [5, 15],          // Intentos / minutos
        'register' => [3, 60],
        'otp_verify' => [10, 15],
        'otp_send' => [3, 15],
        'password_reset' => [3, 60],
    ],

    // Requisitos de contraseña
    'password_rules' => [
        'min' => 8,
        'mixed_case' => true,
        'numbers' => true,
        'symbols' => true,
    ],

    // Rutas
    'routes' => [
        'prefix' => 'auth',
        'middleware' => ['web'],
    ],

    // Redirección post-login
    'redirect_after_login' => '/dashboard',
    'redirect_after_logout' => '/',
];
```

## Variables de entorno

| Variable | Descripción | Obligatoria |
|---|---|---|
| `MAIL_*` | Configuración de email | Sí (para password reset) |
| `GOOGLE_CLIENT_ID` | Google OAuth Client ID | Si usas Google login |
| `GOOGLE_CLIENT_SECRET` | Google OAuth Secret | Si usas Google login |
| `FACEBOOK_CLIENT_ID` | Facebook OAuth Client ID | Si usas Facebook login |
| `FACEBOOK_CLIENT_SECRET` | Facebook OAuth Secret | Si usas Facebook login |
| `TWILIO_SID` | Twilio Account SID | Si usas SMS Twilio |
| `TWILIO_TOKEN` | Twilio Auth Token | Si usas SMS Twilio |
| `TWILIO_FROM` | Número Twilio emisor | Si usas SMS Twilio |
