<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login Notification</title>
    <style>
        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            background-color: #f7f8fa;
            margin: 0;
            padding: 0;
        }
        .container {
            max-width: 600px;
            background-color: #ffffff;
            margin: 30px auto;
            border-radius: 8px;
            box-shadow: 0 4px 10px rgba(0,0,0,0.08);
            overflow: hidden;
        }
        .header {
            background-color: #0d6efd;
            color: #ffffff;
            padding: 20px;
            text-align: center;
        }
        .content {
            padding: 30px;
            color: #333333;
            line-height: 1.6;
        }
        .info {
            background-color: #f1f5fb;
            padding: 15px;
            border-radius: 6px;
            font-size: 14px;
            margin-top: 15px;
        }
        .footer {
            font-size: 12px;
            color: #888888;
            text-align: center;
            padding: 15px;
            border-top: 1px solid #eaeaea;
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="header">
            <h2>Login Alert Mustafa's Mail</h2>
        </div>
        <div class="content">
            <p>Hello <strong>{{$user->name}}</strong>,</p>

            <p>We noticed a login to your account.</p>

           

            <p>If this was you, no further action is needed.  
            If you don’t recognize this login, please reset your password immediately.</p>

            <p style="margin-top: 20px;">
                <a href="{{ url('/password/reset') }}" style="background-color:#0d6efd;color:#ffffff;padding:10px 18px;border-radius:5px;text-decoration:none;">Reset Password</a>
            </p>
        </div>
        <div class="footer">
            <p>© {{ date('Y') }} {{ config('app.name') }}. All rights reserved.</p>
        </div>
    </div>
</body>
</html>
