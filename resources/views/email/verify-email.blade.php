<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Activate Your Account</title>
    <style>
        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            line-height: 1.6;
            color: #333;
            margin: 0;
            padding: 0;
            background-color: #f4f4f4;
        }
        .container {
            max-width: 600px;
            margin: 20px auto;
            background: white;
            border-radius: 10px;
            overflow: hidden;
            box-shadow: 0 4px 10px rgba(0,0,0,0.1);
        }
        .header {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            padding: 30px;
            text-align: center;
        }
        .content {
            padding: 30px;
        }
        .button {
            display: inline-block;
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            color: white;
            text-decoration: none;
            padding: 12px 30px;
            border-radius: 5px;
            font-weight: 600;
            margin: 20px 0;
        }
        .footer {
            background: #f4f4f4;
            padding: 20px;
            text-align: center;
            font-size: 13px;
            color: #777;
        }
        .logo {
            max-width: 150px;
            height: auto;
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="header">
            <img src="{{ $logoData }}" alt="Dataworld Logo" class="logo">
        </div>
        
        <div class="content">
            <h2>Hello {{ $user->name }}!</h2>
            
            <p>Thank you for registering with <strong>Dataworld Support Portal</strong>.</p>
            
            <p>Please click the button below to activate your account:</p>
            
            <div style="text-align: center;">
                <a href="{{ $verificationUrl }}" class="button">Activate My Account</a>
            </div>
            
            <p>⏰ <strong>This link will expire in {{ $expiration }} minutes</strong></p>
            
            <hr>
            
            <p>If you did not create this account, please ignore this email.</p>
            <p>For security reasons, never share this link with anyone.</p>
        </div>
        
        <div class="footer">
            <p>— The Dataworld Support Team</p>
        </div>
    </div>
</body>
</html>