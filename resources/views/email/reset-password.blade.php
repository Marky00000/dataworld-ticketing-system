<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Reset Your Password - Dataworld Support Portal</title>
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
            border-radius: 16px;
            overflow: hidden;
            box-shadow: 0 20px 40px rgba(0,0,0,0.08);
        }
        .header {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            color: white;
            padding: 40px 30px;
            text-align: center;
        }
        .header h1 {
            margin: 20px 0 0 0;
            font-size: 28px;
            font-weight: 600;
        }
        .header p {
            margin: 10px 0 0 0;
            opacity: 0.9;
            font-size: 16px;
        }
        .logo {
            background: rgba(255,255,255,0.15);
            width: 80px;
            height: 80px;
            border-radius: 50%;
            margin: 0 auto 20px;
            display: flex;
            align-items: center;
            justify-content: center;
            backdrop-filter: blur(10px);
            border: 3px solid rgba(255,255,255,0.3);
        }
        .logo img {
            width: 50px;
            height: auto;
        }
        .content {
            padding: 40px 30px;
        }
        .greeting {
            font-size: 18px;
            color: #2d3748;
            margin-bottom: 25px;
        }
        .greeting strong {
            color: #667eea;
            font-weight: 600;
        }
        .message {
            color: #4a5568;
            font-size: 16px;
            margin-bottom: 30px;
            line-height: 1.8;
        }
        .security-badge {
            background: linear-gradient(135deg, #f6f9ff 0%, #f0f4ff 100%);
            border-radius: 12px;
            padding: 20px;
            margin: 30px 0;
            border: 1px solid #e0e7ff;
        }
        .security-badge h3 {
            margin: 0 0 15px 0;
            color: #2d3748;
            font-size: 16px;
            display: flex;
            align-items: center;
            gap: 8px;
        }
        .security-badge h3 i {
            color: #667eea;
        }
        .security-features {
            display: flex;
            flex-wrap: wrap;
            gap: 12px;
        }
        .security-feature {
            flex: 1 1 calc(50% - 6px);
            display: flex;
            align-items: center;
            gap: 8px;
            color: #4a5568;
            font-size: 14px;
        }
        .security-feature i {
            color: #48bb78;
            font-size: 14px;
        }
        .button-container {
            text-align: center;
            margin: 35px 0;
        }
        .button {
            display: inline-block;
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            color: white !important;
            text-decoration: none;
            padding: 16px 40px;
            border-radius: 50px;
            font-weight: 600;
            font-size: 16px;
            box-shadow: 0 10px 20px rgba(102, 126, 234, 0.3);
            transition: all 0.3s ease;
            border: none;
            cursor: pointer;
        }
        .button:hover {
            transform: translateY(-2px);
            box-shadow: 0 15px 30px rgba(102, 126, 234, 0.4);
        }
        .button i {
            margin-right: 8px;
        }
        .expiry-box {
            background: #fff3cd;
            border: 1px solid #ffeeba;
            border-radius: 10px;
            padding: 16px;
            margin: 25px 0;
            display: flex;
            align-items: center;
            gap: 12px;
        }
        .expiry-icon {
            width: 40px;
            height: 40px;
            background: #ffc107;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            color: white;
            font-size: 20px;
            flex-shrink: 0;
        }
        .expiry-text {
            color: #856404;
            font-size: 14px;
            line-height: 1.5;
        }
        .expiry-text strong {
            font-size: 16px;
            display: block;
            margin-bottom: 4px;
        }
        .link-box {
            background: #f7f9fc;
            border: 1px solid #e9ecef;
            border-radius: 10px;
            padding: 16px;
            margin: 25px 0;
        }
        .link-box p {
            margin: 0 0 8px 0;
            color: #718096;
            font-size: 13px;
            text-transform: uppercase;
            letter-spacing: 0.5px;
        }
        .link-url {
            color: #667eea;
            word-break: break-all;
            font-size: 14px;
            font-family: monospace;
            padding: 8px;
            background: white;
            border-radius: 6px;
            border: 1px dashed #cbd5e0;
        }
        .features-grid {
            display: flex;
            flex-wrap: wrap;
            gap: 15px;
            margin: 30px 0;
        }
        .feature-card {
            flex: 1 1 calc(50% - 7.5px);
            background: #f7fafc;
            border-radius: 10px;
            padding: 15px;
            text-align: center;
            border: 1px solid #e2e8f0;
        }
        .feature-icon {
            width: 40px;
            height: 40px;
            background: #e6ecfe;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            margin: 0 auto 10px;
            color: #667eea;
            font-size: 18px;
        }
        .feature-card span {
            display: block;
            font-size: 14px;
            color: #2d3748;
            font-weight: 500;
        }
        .divider {
            height: 1px;
            background: linear-gradient(90deg, transparent, #e2e8f0, transparent);
            margin: 30px 0;
        }
        .info-box {
            background: #f8f9fa;
            border-radius: 10px;
            padding: 20px;
            margin: 20px 0;
        }
        .info-box h4 {
            margin: 0 0 10px 0;
            color: #2d3748;
            font-size: 16px;
        }
        .info-box p {
            margin: 5px 0;
            color: #4a5568;
            font-size: 14px;
        }
        .warning {
            background: #fef2f2;
            border: 1px solid #fecaca;
            border-radius: 8px;
            padding: 12px 16px;
            color: #dc2626;
            font-size: 13px;
            display: flex;
            align-items: center;
            gap: 8px;
            margin-top: 25px;
        }
        .warning i {
            font-size: 16px;
        }
        .footer {
            background: #f8fafc;
            padding: 30px;
            text-align: center;
            font-size: 13px;
            color: #718096;
            border-top: 1px solid #e2e8f0;
        }
        .footer-links {
            margin: 15px 0;
        }
        .footer-links a {
            color: #667eea;
            text-decoration: none;
            margin: 0 10px;
            font-size: 13px;
        }
        .social-links {
            margin: 20px 0;
        }
        .social-links a {
            display: inline-block;
            width: 32px;
            height: 32px;
            background: #edf2f7;
            border-radius: 50%;
            margin: 0 5px;
            line-height: 32px;
            color: #4a5568;
            text-decoration: none;
            transition: all 0.3s ease;
        }
        .social-links a:hover {
            background: #667eea;
            color: white;
        }
        @media only screen and (max-width: 600px) {
            .content {
                padding: 30px 20px;
            }
            .feature-card {
                flex: 1 1 100%;
            }
            .security-feature {
                flex: 1 1 100%;
            }
        }
    </style>
</head>
<body>
    <div class="email-container">
        <!-- Header with Logo -->
        <div class="header">
            <h1>Password Reset Request</h1>
            <p>Secure your Dataworld Support Account</p>
        </div>
        
        <!-- Main Content -->
        <div class="content">
            <!-- Greeting -->
            <div class="greeting">
                Hello <strong>{{ $user->name }}</strong>,
            </div>
            
            <!-- Main Message -->
            <div class="message">
                We received a request to reset the password for your Dataworld Support Portal account. 
                No changes have been made to your account yet. Click the button below to create a new password.
            </div>
            
            <!-- Expiry Badge -->
            <div class="expiry-box">
                <div class="expiry-icon">⏰</div>
                <div class="expiry-text">
                    <strong>This reset link expires in 24 hours</strong>
                    For your security, this link will expire on <strong>{{ $expires }}</strong>.
                    If you didn't request this reset, you can safely ignore this email.
                </div>
            </div>
            
            <!-- Reset Button -->
            <div class="button-container">
                <a href="{{ $resetLink }}" class="button">
                    <i>🔐</i> Create New Password
                </a>
            </div>
            
            <!-- Alternative Link -->
            <div class="link-box">
                <p>📋 Alternative link (copy & paste):</p>
                <div class="link-url">{{ $resetLink }}</div>
            </div>
            
            <!-- Account Information -->
            <div class="info-box">
                <h4>📋 Account Information</h4>
                <p><strong>Account:</strong> {{ $user->email }}</p>
                <p><strong>Account Type:</strong> {{ ucfirst($user->user_type) }} Account</p>
                <p><strong>Member since:</strong> {{ $user->created_at->format('F j, Y') }}</p>
            </div>
            
            <!-- Divider -->
            <div class="divider"></div>
            
            <!-- Did You Know -->
            <div style="background: #f0f9ff; border-radius: 8px; padding: 15px; margin: 20px 0;">
                <p style="margin: 0; color: #0369a1; font-size: 14px;">
                    <strong>💡 Did you know?</strong> You can also change your password anytime from your 
                    profile settings after logging in.
                </p>
            </div>
            
            <!-- Warning Message -->
            <div class="warning">
                <i>⚠️</i>
                If you didn't request a password reset, please ignore this email. 
                Your account remains secure and no changes have been made.
            </div>
            
            <!-- Need Help -->
            <div style="text-align: center; margin: 30px 0 10px;">
                <p style="color: #718096; font-size: 14px;">
                    <strong>Need help?</strong> Contact our support team at 
                    <a href="mailto:support@dataworld.com.ph" style="color: #667eea; text-decoration: none;">support@dataworld.com.ph</a>
                </p>
            </div>
        </div>
        
        <!-- Footer -->
        <div class="footer">
            <!-- Social Links -->
            <div class="social-links">
                <a href="#">f</a>
                <a href="#">t</a>
                <a href="#">in</a>
                <a href="#">ig</a>
            </div>
            
            <!-- Footer Links -->
            <div class="footer-links">
                <a href="#">Privacy Policy</a> | 
                <a href="#">Terms of Service</a> | 
                <a href="#">Contact Support</a>
            </div>
            
            <!-- Copyright -->
            <p>© {{ date('Y') }} Dataworld Computer Center. All rights reserved.</p>
            
            <!-- Company Info -->
            <p style="font-size: 11px; margin-top: 15px; color: #a0aec0;">
                Dataworld Computer Center<br>
                123 Business Park, Manila, Philippines 1000
            </p>
            
            <!-- Email Footer Note -->
            <p style="font-size: 11px; margin-top: 15px; color: #a0aec0;">
                This email was sent to {{ $user->email }} because you requested a password reset 
                for your Dataworld Support Portal account. If you did not make this request, 
                please contact us immediately.
            </p>
            
            <!-- Unsubscribe (subtle) -->
            <p style="font-size: 10px; margin-top: 20px; color: #cbd5e0;">
                This is a transactional email related to your account security.
            </p>
        </div>
    </div>
</body>
</html>