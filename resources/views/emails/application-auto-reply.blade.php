<!DOCTYPE html>
<html lang="{{ $application->locale ?? app()->getLocale() }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>{{ $lines['greeting'] }}</title>
</head>
<body style="margin:0;padding:0;background:#f6f3ec;font-family:Georgia,'Times New Roman',serif;color:#1f1f1f;">
    <table role="presentation" width="100%" cellspacing="0" cellpadding="0" style="background:#f6f3ec;padding:32px 16px;">
        <tr>
            <td align="center">
                <table role="presentation" width="100%" cellspacing="0" cellpadding="0" style="max-width:560px;background:#fffdf8;border:1px solid #ddd4c4;">
                    <tr>
                        <td style="padding:32px 28px;">
                            <p style="margin:0 0 8px;font-size:12px;letter-spacing:0.12em;text-transform:uppercase;color:#8a7a5a;">Akemin Golf</p>
                            <p style="margin:0 0 20px;font-size:22px;line-height:1.5;">{{ $lines['greeting'] }}</p>
                            <p style="margin:0 0 16px;font-size:16px;line-height:1.8;color:#3a3a3a;">{{ $lines['body'] }}</p>
                            <p style="margin:0;font-size:16px;line-height:1.8;color:#3a3a3a;">{{ $lines['closing'] }}</p>
                        </td>
                    </tr>
                </table>
            </td>
        </tr>
    </table>
</body>
</html>
