<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Codigo de recuperacion</title>
</head>
<body style="margin:0; padding:0; background:#f4f1ea; font-family:Arial, sans-serif; color:#1a1a1a;">
    <table role="presentation" width="100%" cellspacing="0" cellpadding="0" style="padding:24px 12px;">
        <tr>
            <td align="center">
                <table role="presentation" width="560" cellspacing="0" cellpadding="0" style="max-width:560px; width:100%; background:#ffffff; border:1px solid #dfd7c8; border-radius:14px; overflow:hidden;">
                    <tr>
                        <td style="padding:24px; background:#0b0b0b; color:#f6f3ee; text-align:center;">
                            <h1 style="margin:0; font-size:22px; font-weight:700;">Recuperación  de contraseña</h1>
                        </td>
                    </tr>
                    <tr>
                        <td style="padding:24px;">
                            <p style="margin:0 0 12px; line-height:1.5;">
                                Recibimos una solicitud para restablecer la contrasena de tu cuenta.
                            </p>
                            <p style="margin:0 0 16px; line-height:1.5;">
                                Usa este codigo de verificacion de 6 digitos para continuar:
                            </p>
                            <p style="margin:0 0 18px; font-size:34px; font-weight:800; letter-spacing:6px; text-align:center; color:#111111;">
                                {{ $code }}
                            </p>
                            <p style="margin:0 0 10px; line-height:1.5;">
                                El codigo expira en 10 minutos.
                            </p>
                            <p style="margin:0; line-height:1.5; color:#555555;">
                                Si no solicitaste este cambio, puedes ignorar este correo.
                            </p>
                        </td>
                    </tr>
                </table>
            </td>
        </tr>
    </table>
</body>
</html>
