<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Tu código de verificación</title>
</head>
<body style="margin:0;padding:0;background:#f4f4f5;font-family:Figtree,ui-sans-serif,system-ui,sans-serif">
  <table width="100%" cellpadding="0" cellspacing="0" style="padding:40px 16px">
    <tr><td align="center">
      <table width="480" cellpadding="0" cellspacing="0" style="max-width:480px;width:100%">
        <tr>
          <td style="background:#fff;border-radius:12px;padding:32px;text-align:center">
            <div style="width:56px;height:56px;background:#eef2ff;border-radius:50%;display:flex;align-items:center;justify-content:center;margin:0 auto 20px">
              <svg width="28" height="28" viewBox="0 0 24 24" fill="none" stroke="#4F46E5" stroke-width="2">
                <path d="M12 18h.01M8 21h8a2 2 0 002-2V5a2 2 0 00-2-2H8a2 2 0 00-2 2v14a2 2 0 002 2z"/>
              </svg>
            </div>

            <h1 style="font-size:20px;font-weight:700;color:#111827;margin:0 0 8px;text-align:center">
              Código de verificación
            </h1>
            <p style="font-size:14px;color:#6b7280;margin:0 0 24px;text-align:center;line-height:1.6">
              Usa el siguiente código para verificar tu identidad:
            </p>

            <div style="background:#f9fafb;border-radius:8px;padding:16px;margin-bottom:24px">
              <span style="font-size:32px;font-weight:800;letter-spacing:8px;color:#4F46E5;font-family:monospace">
                {{ $code }}
              </span>
            </div>

            <p style="font-size:12px;color:#9ca3af;margin:0;text-align:center">
              Este código expira en {{ $expiresMinutes }} minutos.<br>
              Si no solicitaste este código, ignora este mensaje.
            </p>
          </td>
        </tr>
        <tr>
          <td style="padding:16px 0 0;text-align:center">
            <p style="font-size:11px;color:#9ca3af;margin:0">
              &copy; {{ date('Y') }} LaraAuth &middot; Sistema de autenticación para Laravel
            </p>
          </td>
        </tr>
      </table>
    </td></tr>
  </table>
</body>
</html>
