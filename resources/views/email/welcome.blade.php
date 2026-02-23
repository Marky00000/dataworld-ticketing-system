<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Activate Your Dataworld Support Account</title>
    <style>
        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            line-height: 1.6;
            color: #333;
            margin: 0;
            padding: 0;
            background-color: #f4f4f4;
        }
        .email-container {
            max-width: 600px;
            margin: 20px auto;
            background: white;
            border-radius: 10px;
            overflow: hidden;
            box-shadow: 0 4px 10px rgba(0,0,0,0.1);
        }
        .header {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            color: white;
            padding: 30px;
            text-align: center;
        }
        .header h1 {
            margin: 0;
            font-size: 24px;
            font-weight: 600;
        }
        .content {
            padding: 30px;
        }
        .welcome-message {
            font-size: 16px;
            color: #555;
            margin-bottom: 25px;
        }
        .info-box {
            background: #f8f9fa;
            border-left: 4px solid #667eea;
            padding: 20px;
            margin: 25px 0;
            border-radius: 5px;
        }
        .info-box h3 {
            margin: 0 0 10px 0;
            color: #333;
            font-size: 18px;
        }
        .info-box p {
            margin: 5px 0;
            color: #666;
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
        .button:hover {
            opacity: 0.9;
        }
        .expiry-badge {
            background: #fff3cd;
            border: 1px solid #ffeeba;
            color: #856404;
            padding: 12px;
            border-radius: 5px;
            margin: 20px 0;
            text-align: center;
            font-size: 14px;
        }
        .features {
            display: flex;
            flex-wrap: wrap;
            margin: 25px 0;
            gap: 15px;
        }
        .feature {
            flex: 1 1 45%;
            text-align: center;
            padding: 15px;
            background: #f8f9fa;
            border-radius: 5px;
        }
        .feature span {
            display: block;
            font-size: 14px;
            color: #555;
        }
        .footer {
            background: #f4f4f4;
            padding: 20px 30px;
            text-align: center;
            font-size: 13px;
            color: #777;
            border-top: 1px solid #ddd;
        }
        .footer a {
            color: #667eea;
            text-decoration: none;
        }
        .divider {
            height: 1px;
            background: #ddd;
            margin: 20px 0;
        }
        .credentials {
            background: #e8f4fd;
            padding: 15px;
            border-radius: 5px;
            margin: 15px 0;
        }
        .credentials p {
            margin: 5px 0;
        }
        .warning {
            color: #dc3545;
            font-size: 13px;
            margin-top: 10px;
        }
    </style>
</head>
<body>
    <div class="email-container">
        <div class="header">
            <h1>Activate Your Dataworld Support Account</h1>
        </div>
        
        <div class="content">
            <div class="welcome-message">
                <p>Hello <strong>{{ $user->name }}</strong>,</p>
                <p>Thank you for registering with Dataworld Support Portal! We're excited to have you on board. Please activate your account to start using our technical support services.</p>
            </div>

            <div class="expiry-badge">
                ⏰ <strong>This activation link will expire in {{ $expiration }} minutes</strong>
            </div>
            
            <div class="info-box">
                <h3>Account Details</h3>
                <p><strong>Name:</strong> {{ $user->name }}</p>
                <p><strong>Email:</strong> {{ $user->email }}</p>
                <p><strong>Company:</strong> {{ $user->company ?? 'Not specified' }}</p>
                <p><strong>Phone:</strong> {{ $user->phone ?? 'Not specified' }}</p>
                <p><strong>Account Type:</strong> Client Support Account</p>
                <p><strong>Registered:</strong> {{ $user->created_at->format('F j, Y \a\t g:i A') }}</p>
            </div>
            
            <div style="text-align: center;">
                <a href="{{ $activationUrl }}" class="button">
                    ✅ Activate My Account
                </a>
            </div>

            <p style="text-align: center; font-size: 13px; color: #666; margin-top: 10px;">
                Button not working? Copy and paste this link into your browser:<br>
                <a href="{{ $activationUrl }}" style="color: #667eea; word-break: break-all;">{{ $activationUrl }}</a>
            </p>
            
            <div class="features">
                <div class="feature">
                    <span>Submit Support Tickets</span>
                </div>
                <div class="feature">
                    <span>Live Chat Support</span>
                </div>
                <div class="feature">
                    <span>Track Ticket History</span>
                </div>
                <div class="feature">
                    <span>Knowledge Base</span>
                </div>
            </div>
            
            <div class="credentials">
                <h4 style="margin: 0 0 10px 0;">What you can do after activation:</h4>
                <p>✓ Submit technical support tickets for Dataworld products</p>
                <p>✓ Track the status of your existing tickets</p>
                <p>✓ Communicate directly with our technical team</p>
                <p>✓ Access support documentation and resources</p>
                <p>✓ Receive notifications about ticket updates</p>
            </div>
            
            <div class="divider"></div>
            
            <p style="font-size: 14px; color: #666;">
                <strong>Need help getting started?</strong><br>
                Our support team is here to assist you.
            </p>

            <div class="warning">
                ⚠️ If you didn't create this account, please ignore this email. The account will expire automatically.
            </div>
        </div>
        
        <div class="footer">
            <p>© {{ date('Y') }} Dataworld Computer Center. All rights reserved.</p>
            <p>
                <a href="#">Privacy Policy</a> | 
                <a href="#">Terms of Service</a>
            </p>
            <p style="font-size: 11px; margin-top: 15px;">
                This email was sent to {{ $user->email }} because you registered for a Dataworld Support Portal account. 
                If you didn't create this account, please contact us immediately.
            </p>
        </div>
    </div>
</body>
</html>