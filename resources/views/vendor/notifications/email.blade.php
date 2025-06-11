<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Restablecimiento de Contraseña - EncargaYa</title>
</head>
<body style="background: #f4f4f7; margin: 0; padding: 0;">
    <table width="100%" cellpadding="0" cellspacing="0" style="background: #f4f4f7; padding: 40px 0;">
        <tr>
            <td align="center">
                <table width="100%" cellpadding="0" cellspacing="0" style="max-width: 600px; background: #fff; border-radius: 8px; box-shadow: 0 2px 8px rgba(0,0,0,0.05);">
                    <tr>
                        <td align="center" style="padding: 32px 0 16px 0;">
                            <div style="font-family: Arial, sans-serif; font-size: 32px; font-weight: bold; color: #3a86ff; letter-spacing: 2px;">
                                Encarga<span style="color: #22223b;">Ya</span>
                            </div>
                            <div style="font-family: Arial, sans-serif; font-size: 14px; color: #4a4e69; margin-top: 4px; letter-spacing: 1px;">
                                Tu tienda de confianza
                            </div>
                        </td>
                    </tr>
                    <tr>
                        <td style="padding: 0 40px;">
                            <h2 style="color: #22223b; font-family: Arial, sans-serif; font-size: 24px; margin-bottom: 16px;">Hola,</h2>
                            <p style="color: #4a4e69; font-family: Arial, sans-serif; font-size: 16px; margin-bottom: 24px;">
                                Hemos recibido tu solicitud de restablecimiento de contraseña en <strong>EncargaYa</strong>.
                            </p>
                            <p style="color: #4a4e69; font-family: Arial, sans-serif; font-size: 16px; margin-bottom: 32px;">
                                Por favor, haz clic en el siguiente botón para restablecer tu contraseña.<br>
                                Este enlace es válido por <strong>60 minutos</strong>.
                            </p>
                            <div style="text-align: center; margin-bottom: 32px;">
                                <a href="{{ $actionUrl }}" style="background: #3a86ff; color: #fff; text-decoration: none; padding: 14px 32px; border-radius: 6px; font-family: Arial, sans-serif; font-size: 16px; font-weight: bold; display: inline-block;">
                                    Restablecer contraseña
                                </a>
                            </div>
                            <p style="color: #4a4e69; font-family: Arial, sans-serif; font-size: 14px; margin-bottom: 24px;">
                                Si no solicitaste este cambio, podés ignorar este correo.<br>
                                Gracias por confiar en <strong>EncargaYa</strong>.
                            </p>
                            <p style="color: #22223b; font-family: Arial, sans-serif; font-size: 14px; margin-bottom: 0;">
                                Saludos,<br>
                                Equipo de EncargaYa
                            </p>
                        </td>
                    </tr>
                    <tr>
                        <td style="padding: 32px 40px 24px 40px;">
                            <hr style="border: none; border-top: 1px solid #e0e0e0; margin-bottom: 16px;">
                            <p style="color: #9a8c98; font-family: Arial, sans-serif; font-size: 13px; margin: 0;">
                                Si tienes problemas para hacer clic en el botón "Restablecer contraseña", copia y pega la siguiente URL en tu navegador web:<br>
                                <a href="{{ $actionUrl }}" style="color: #3a86ff; word-break: break-all;">{{ $actionUrl }}</a>
                            </p>
                        </td>
                    </tr>
                    <tr>
                        <td align="center" style="padding: 0 0 24px 0;">
                            <span style="color: #bcbcbc; font-size: 12px; font-family: Arial, sans-serif;">&copy; {{ date('Y') }} EncargaYa. Todos los derechos reservados.</span>
                        </td>
                    </tr>
                </table>
            </td>
        </tr>
    </table>
</body>
</html>
