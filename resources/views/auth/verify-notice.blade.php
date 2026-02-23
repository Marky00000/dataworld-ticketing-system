<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Verify Email - Dataworld Support</title>
    <link rel="icon" type="image/png" href="{{ asset('images/logo.png') }}">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <script src="https://cdn.tailwindcss.com"></script>
    <style>
        .gradient-bg {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
        }
        .animate-float {
            animation: float 6s ease-in-out infinite;
        }
        @keyframes float {
            0%, 100% { transform: translateY(0px); }
            50% { transform: translateY(-20px); }
        }
        .hover-lift {
            transition: transform 0.3s ease, box-shadow 0.3s ease;
        }
        .hover-lift:hover {
            transform: translateY(-2px);
            box-shadow: 0 10px 25px rgba(99, 102, 241, 0.15);
        }
    </style>
</head>
<body class="bg-gray-50 min-h-screen flex flex-col">
    <!-- Background Elements -->
    <div class="fixed inset-0 overflow-hidden pointer-events-none">
        <div class="absolute -top-40 -right-40 w-80 h-80 bg-primary/10 rounded-full blur-3xl animate-float"></div>
        <div class="absolute -bottom-40 -left-40 w-80 h-80 bg-purple-300/10 rounded-full blur-3xl animate-float" style="animation-delay: 2s;"></div>
    </div>

    <!-- Top Navigation -->
    <div class="w-full bg-white border-b border-gray-200 sticky top-0 z-50 shadow-sm">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 py-3">
            <div class="flex items-center text-sm">
                <a href="/" class="text-gray-500 hover:text-primary transition flex items-center gap-1">
                    <i class="fas fa-home text-xs"></i>
                    <span>Dashboard</span>
                </a>
                <i class="fas fa-chevron-right mx-2 text-xs text-gray-400"></i>
                <span class="text-primary font-medium">Email Verification</span>
            </div>
        </div>
    </div>

    <!-- Main Content -->
    <div class="flex-1 flex items-center justify-center p-4">
        <div class="max-w-md w-full">
            <!-- Logo -->
            <div class="text-center mb-8">
                <a href="/" class="inline-flex items-center space-x-2 hover-lift">
                    <img src="{{ asset('images/dwcc.png') }}" alt="Dataworld Logo" class="h-10 w-auto">
                    <span class="text-xl font-bold text-primary">Dataworld</span>
                </a>
            </div>

            <!-- Success Message -->
            @if(session('success'))
                <div class="mb-4 p-4 bg-green-50 border-l-4 border-green-500 text-green-700 rounded-lg shadow-md">
                    <div class="flex items-center">
                        <i class="fas fa-check-circle mr-2"></i>
                        <span>{{ session('success') }}</span>
                    </div>
                </div>
            @endif

            <!-- Error Message -->
            @if(session('error'))
                <div class="mb-4 p-4 bg-red-50 border-l-4 border-red-500 text-red-700 rounded-lg shadow-md">
                    <div class="flex items-center">
                        <i class="fas fa-exclamation-circle mr-2"></i>
                        <span>{{ session('error') }}</span>
                    </div>
                </div>
            @endif

            <!-- Main Card -->
            <div class="bg-white rounded-2xl shadow-xl p-8 text-center hover-lift">
                <div class="w-24 h-24 bg-gradient-to-br from-primary to-primaryDark rounded-full flex items-center justify-center mx-auto mb-6 shadow-lg">
                    <i class="fas fa-envelope-open-text text-4xl text-white"></i>
                </div>
                
                <h2 class="text-2xl font-bold text-gray-800 mb-2">Verify Your Email</h2>
                
                <p class="text-gray-600 mb-6">
                    We've sent a verification link to:<br>
                    <strong class="text-primary text-lg">{{ $email ?? session('registered_email') }}</strong>
                </p>
                
                <div class="bg-blue-50 border border-blue-200 rounded-xl p-5 mb-6 text-left">
                    <div class="flex items-start">
                        <i class="fas fa-info-circle text-blue-500 mr-3 mt-1"></i>
                        <div>
                            <p class="text-sm text-blue-800 font-medium mb-2">Link expires in {{ config('auth.verification.expire', 2) }} minutes</p>
                            <p class="text-sm text-blue-700">
                                For your security, this verification link will expire in {{ config('auth.verification.expire', 2) }} minutes. 
                                If you don't verify within this time, you'll need to request a new verification email.
                            </p>
                        </div>
                    </div>
                </div>

                <div class="space-y-4">
                    <!-- Resend Form -->
                    <form action="{{ route('verification.resend') }}" method="POST" class="inline-block">
                        @csrf
                        <input type="hidden" name="email" value="{{ $email ?? session('registered_email') }}">
                        <button type="submit" class="text-primary hover:text-primaryDark font-medium hover:underline">
                            <i class="fas fa-redo-alt mr-1"></i>
                            Resend verification email
                        </button>
                    </form>

                    <div class="border-t border-gray-200 pt-4">
                        <a href="{{ route('sign-in') }}" class="text-sm text-gray-500 hover:text-gray-700 transition">
                            <i class="fas fa-arrow-left mr-1"></i>
                            Back to Sign In
                        </a>
                    </div>
                </div>
            </div>

            <!-- Help Text -->
            <p class="text-center text-xs text-gray-500 mt-6">
                <i class="fas fa-shield-alt mr-1"></i>
                Didn't receive the email? Check your spam folder or 
                <button onclick="document.querySelector('form').submit()" class="text-primary hover:underline">
                    click here to resend
                </button>
            </p>
        </div>
    </div>
</body>
</html>