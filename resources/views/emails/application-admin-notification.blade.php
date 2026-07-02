<!DOCTYPE html>
<html lang="ja">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>{{ $labels['intro'] }}</title>
</head>
<body style="margin:0;padding:0;background:#f6f3ec;font-family:Georgia,'Times New Roman',serif;color:#1f1f1f;">
    <table role="presentation" width="100%" cellspacing="0" cellpadding="0" style="background:#f6f3ec;padding:32px 16px;">
        <tr>
            <td align="center">
                <table role="presentation" width="100%" cellspacing="0" cellpadding="0" style="max-width:560px;background:#fffdf8;border:1px solid #ddd4c4;">
                    <tr>
                        <td style="padding:32px 28px;">
                            <p style="margin:0 0 8px;font-size:12px;letter-spacing:0.12em;text-transform:uppercase;color:#8a7a5a;">Akemin Golf</p>
                            <p style="margin:0 0 20px;font-size:18px;line-height:1.6;">{{ $labels['intro'] }}</p>
                            <table role="presentation" width="100%" cellspacing="0" cellpadding="0" style="font-size:15px;line-height:1.7;color:#3a3a3a;">
                                <tr>
                                    <td style="padding:8px 0;border-bottom:1px solid #ece4d6;width:34%;vertical-align:top;color:#6b6b6b;">{{ $labels['name'] }}</td>
                                    <td style="padding:8px 0;border-bottom:1px solid #ece4d6;vertical-align:top;">{{ $application->name }}</td>
                                </tr>
                                <tr>
                                    <td style="padding:8px 0;border-bottom:1px solid #ece4d6;vertical-align:top;color:#6b6b6b;">{{ $labels['email'] }}</td>
                                    <td style="padding:8px 0;border-bottom:1px solid #ece4d6;vertical-align:top;">{{ $application->email ?: $labels['none'] }}</td>
                                </tr>
                                <tr>
                                    <td style="padding:8px 0;border-bottom:1px solid #ece4d6;vertical-align:top;color:#6b6b6b;">{{ $labels['country'] }}</td>
                                    <td style="padding:8px 0;border-bottom:1px solid #ece4d6;vertical-align:top;">{{ $application->country ?: $labels['none'] }}</td>
                                </tr>
                                <tr>
                                    <td style="padding:8px 0;border-bottom:1px solid #ece4d6;vertical-align:top;color:#6b6b6b;">{{ $labels['interest'] }}</td>
                                    <td style="padding:8px 0;border-bottom:1px solid #ece4d6;vertical-align:top;">{{ $interest ?: $labels['none'] }}</td>
                                </tr>
                                <tr>
                                    <td style="padding:8px 0;border-bottom:1px solid #ece4d6;vertical-align:top;color:#6b6b6b;">{{ $labels['locale'] }}</td>
                                    <td style="padding:8px 0;border-bottom:1px solid #ece4d6;vertical-align:top;">{{ strtoupper($application->locale ?? '—') }}</td>
                                </tr>
                                <tr>
                                    <td style="padding:12px 0 0;vertical-align:top;color:#6b6b6b;">{{ $labels['message'] }}</td>
                                    <td style="padding:12px 0 0;vertical-align:top;white-space:pre-line;">{{ $application->message ?: $labels['none'] }}</td>
                                </tr>
                            </table>
                        </td>
                    </tr>
                </table>
            </td>
        </tr>
    </table>
</body>
</html>
