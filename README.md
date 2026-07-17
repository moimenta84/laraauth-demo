# LaraAuth

[![Latest Version](https://img.shields.io/packagist/v/moimenta84/laraauth)](https://packagist.org/packages/moimenta84/laraauth)
![Laravel](https://img.shields.io/badge/Laravel-11%2F12-red)
![PHP](https://img.shields.io/badge/PHP-8.2%2B-blue)
[![License](https://img.shields.io/badge/license-MIT-green)](LICENSE)

**Sistema de autenticación premium para Laravel.** Diseño moderno, OTP por SMS, social login, rate limiting y componentes Blade 100% personalizables.

![Preview](./preview.png)

## ✨ Características

| | |
|---|---|
| 🎨 | Split layout con panel informativo lateral |
| 📱 | 6 vistas auth: login, registro, OTP, forgot, reset, perfil |
| 📞 | Verificación SMS con OTP (Twilio / Vonage / Log) |
| 🔗 | Social login: Google, Facebook, GitHub, LinkedIn |
| 🛡️ | Rate limiting en login, registro, OTP y password reset |
| 🔐 | Barra de fortaleza de contraseña en tiempo real |
| 🌐 | Traducciones ES / EN incluidas |
| 🧩 | Componentes Blade publicables con `php artisan vendor:publish` |
| 📦 | Instalable vía Composer |

## Stack

- **Backend:** Laravel 11/12 · PHP 8.2+ · SQLite/MySQL/PostgreSQL
- **Frontend:** Tailwind CSS · Blade · Alpine.js (opcional)
- **Servicios:** Laravel Socialite · Twilio / Vonage

## Instalación

```bash
composer require moimenta84/laraauth

php artisan vendor:publish --tag=laraauth-config
php artisan vendor:publish --tag=laraauth-migrations
php artisan migrate
```

Añade el trait `HasOTP` a tu `User` model — ver [docs/installation.md](docs/installation.md).

## Documentación

- [Instalación](docs/installation.md)
- [Configuración](docs/configuration.md)
- [Uso](docs/usage.md)
- [Personalización](docs/customization.md)

## Demo

Prueba la demo online: [ikermartinezdev.com/laraauth-demo](https://ikermartinezdev.com/laraauth-demo)

## Licencia

MIT — uso personal y comercial.
