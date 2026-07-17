<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Restablecer contraseña</title>
</head>
<body style="margin:0;padding:0;background:#f4f4f5;font-family:Figtree,ui-sans-serif,system-ui,sans-serif">
  <table width="100%" cellpadding="0" cellspacing="0" style="padding:40px 16px">
    <tr><td align="center">
      <table width="480" cellpadding="0" cellspacing="0" style="max-width:480px;width:100%">
        <tr>
          <td style="background:#fff;border-radius:12px;padding:32px;text-align:center">
            <div style="width:56px;height:56px;background:#fef3c7;border-radius:50%;display:flex;align-items:center;justify-content:center;margin:0 auto 20px">
              <svg width="28" height="28" viewBox="0 0 24 24" fill="none" stroke="#D97706" stroke-width="2">
                <path d="M15 7a2 2 0 012 2m4 0a6 6 0 01-7.743 5.743L11 17H9v2H7v2H4a1 1 0 01-1-1v-2.586a1 1 0 01.293-.707l5.964-5.964A6 6 0 1121 9z"/>
              </svg>
            </div>

            <h1 style="font-size:20px;font-weight:700;color:#111827;margin:0 0 8px;text-align:center">
              Restablecer contraseña
            </h1>
            <p style="font-size:14px;color:#6b7280;margin:0 0 24px;text-align:center;line-height:1.6">
              Recibimos una solicitud para restablecer la contraseña de tu cuenta.
            </p>

            <a href="{{ $resetUrl }}"
               style="display:inline-block;padding:12px 32px;background:#4F46E5;color:#fff;border-radius:8px;text-decoration:none;font-size:14px;font-weight:600">
              Restablecer contraseña
            </a>

            <p style="font-size:12px;color:#9ca3af;margin:24px 0 0;text-align:center;line-height:1.6">
              Este enlace expira en {{ $expiresMinutes }} minutos.<br>
              Si no solicitaste este cambio, ignora este mensaje.
            </p>
          </td>
        </tr>
        <tr>
          <td style="padding:16px 0 0;text-align:center">
            <p style="font-size:11px;color:#9ca3af;margin:0">
              &copy; {{ date('Y') }} LaraAuth
            </p>
          </td>
        </tr>
      </table>
    </td></tr>
  </table>
</body>
</html>
