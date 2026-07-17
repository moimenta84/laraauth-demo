# Publicación de LaraAuth

## 1. Packagist (composer require moimenta84/laraauth)

1. Ve a https://packagist.org/packages/submit
2. Ingresa la URL del repo: `https://github.com/moimenta84/laraauth-demo`
3. Packagist detectará `composer.json` automáticamente
4. Configura el webhook en GitHub:
   - GitHub repo → Settings → Webhooks → Add webhook
   - Payload URL: `https://packagist.org/api/github?username=moimenta84`
   - Content type: `application/json`
   - Secret: obtenerlo de https://packagist.org/profile/ → API Token
   - Events: Just the push event
5. Marca el repo como "Auto-update" en Packagist (o usa el webhook)

Para versiones futuras: crea un tag (ej. `v1.1.0`) y haz push; Packagist lo detecta automáticamente si el webhook está configurado.

---

## 2. CodeCanyon

### Preparación del ZIP

El ZIP debe contener solo lo necesario para el comprador:

```
laraauth.zip
├── composer.json
├── config/
│   └── laraauth.php
├── database/
│   └── migrations/
├── docs/
│   ├── installation.md
│   ├── configuration.md
│   ├── usage.md
│   └── customization.md
├── resources/
│   ├── lang/
│   ├── views/
│   └── emails/
├── routes/
│   └── auth.php
├── src/
│   ├── Controllers/
│   ├── Middleware/
│   ├── Models/
│   ├── Requests/
│   ├── Services/
│   ├── Traits/
│   ├── LaraAuthServiceProvider.php
├── stubs/
│   └── User.stub
├── tests/
│   └── BasicTest.php
├── index.html        ← landing/demo page
├── preview.png       ← screenshot del demo
├── README.md
├── LICENSE
└── PUBLISHING.md     ← (excluir del ZIP final)
```

**Excluir**: `.git/`, `.github/`, `.gitattributes`, `.gitignore`, `vendor/`.

### Crear el ZIP

```bash
# Desde el repo local (Linux/Mac)
git archive --format=zip --output=laraauth-v1.0.0.zip main

# O manual: copiar la carpeta y borrar lo que no sirva
```

### Subir a CodeCanyon

1. Ve a https://codecanyon.net/new-item
2. Categoría: **Laravel Plugins / Authentication & Authorization**
3. Tags sugeridos: `laravel`, `authentication`, `login`, `register`, `otp`, `email-verification`, `social-login`, `blade`, `tailwind`
4. Sube el ZIP
5. Precio sugerido: **$12–$18 USD**
6. Incluye en la descripción las features de la tabla del README
7. Añade screenshots/gifs del demo funcionando

### Soporte post-venta

- Configura sistema de tickets en CodeCanyon
- Responde en < 24h
- Mantén un changelog en `docs/changelog.md`

---

## Notas

- No subas claves de API ni .env al repo público
- El `index.html` puede alojarse en tu VPS como landing público
- Para actualizar: sube nueva versión a GitHub, haz tag, y actualiza en CodeCanyon manualmente
