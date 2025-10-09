<?php
$verificationUrl = 'https://example.com/verify-email?token=' . $token;
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Verify Your Email Address</title>
    <style>
        body {
            margin: 0;
            padding: 0;
            font-family: -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, 'Helvetica Neue', Arial, sans-serif;
            background-color: #f8f9fa;
            line-height: 1.6;
        }
        .email-wrapper {
            max-width: 600px;
            margin: 0 auto;
            padding: 20px;
        }
        .email-container {
            background-color: #ffffff;
            border-radius: 8px;
            box-shadow: 0 2px 8px rgba(0, 0, 0, 0.1);
            overflow: hidden;
        }
        .email-header {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            padding: 40px 30px;
            text-align: center;
            color: #ffffff;
        }
        .email-header h1 {
            margin: 0;
            font-size: 28px;
            font-weight: 600;
        }
        .email-body {
            padding: 40px 30px;
        }
        .greeting {
            font-size: 18px;
            color: #333333;
            margin-bottom: 20px;
        }
        .content {
            font-size: 16px;
            color: #555555;
            margin-bottom: 30px;
        }
        .verify-button {
            text-align: center;
            margin: 35px 0;
        }
        .verify-button a {
            display: inline-block;
            padding: 16px 40px;
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            color: #ffffff;
            text-decoration: none;
            border-radius: 6px;
            font-size: 16px;
            font-weight: 600;
            transition: transform 0.2s;
        }
        .verify-button a:hover {
            transform: translateY(-2px);
        }
        .alternative-link {
            margin-top: 30px;
            padding-top: 30px;
            border-top: 1px solid #e9ecef;
            font-size: 14px;
            color: #666666;
        }
        .alternative-link p {
            margin: 10px 0;
        }
        .link-text {
            word-break: break-all;
            color: #667eea;
            text-decoration: none;
        }
        .email-footer {
            padding: 30px;
            text-align: center;
            font-size: 14px;
            color: #999999;
            background-color: #f8f9fa;
        }
        .email-footer p {
            margin: 5px 0;
        }
        .expiry-notice {
            background-color: #fff3cd;
            border-left: 4px solid #ffc107;
            padding: 15px;
            margin: 20px 0;
            border-radius: 4px;
            font-size: 14px;
            color: #856404;
        }
        @media only screen and (max-width: 600px) {
            .email-wrapper {
                padding: 10px;
            }
            .email-header {
                padding: 30px 20px;
            }
            .email-header h1 {
                font-size: 24px;
            }
            .email-body {
                padding: 30px 20px;
            }
            .verify-button a {
                padding: 14px 30px;
                font-size: 15px;
            }
        }
    </style>
</head>
<body>
    <div class="email-wrapper">
        <div class="email-container">
            <div class="email-header">
                <h1>Verify Your Email Address</h1>
            </div>
            
            <div class="email-body">
                <p class="greeting">Hello {{ $user->name }},</p>
                
                <div class="content">
                    <p>Thank you for registering with {{ config('app.name') }}! We're excited to have you on board.</p>
                    <p>To complete your registration and start using your account, please verify your email address by clicking the button below:</p>
                </div>
                
                <div class="verify-button">
                    <a href="{{ $verificationUrl }}">Verify Email Address</a>
                </div>
                
                <div class="expiry-notice">
                    <strong>⏰ Important:</strong> This verification link will expire in 60 minutes for security purposes.
                </div>
                
                <div class="alternative-link">
                    <p>If the button above doesn't work, copy and paste the following link into your browser:</p>
                    <p><a href="{{ $verificationUrl }}" class="link-text">{{ $verificationUrl }}</a></p>
                </div>
                
                <div class="content" style="margin-top: 30px;">
                    <p>If you did not create an account with us, please ignore this email and no further action is required.</p>
                </div>
            </div>
            
            <div class="email-footer">
                <p>&copy; {{ date('Y') }} {{ config('app.name') }}. All rights reserved.</p>
                <p>This is an automated email, please do not reply to this message.</p>
            </div>
        </div>
    </div>
</body>
</html>