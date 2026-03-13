<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Verify Your Email - Dataworld Support</title>
    <link rel="icon" type="image/png" href="{{ asset('images/logo.png') }}">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <script src="https://cdn.tailwindcss.com"></script>
    <style>
        .gradient-bg {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
        }
        
        .gradient-text {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            background-clip: text;
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
            box-shadow: 0 20px 25px -5px rgba(99, 102, 241, 0.1), 0 10px 10px -5px rgba(99, 102, 241, 0.04);
        }
        
        /* Card border gradient */
        .card-gradient-border {
            position: relative;
            background: white;
            border-radius: 1rem;
        }
        .card-gradient-border::before {
            content: "";
            position: absolute;
            inset: -1px;
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            border-radius: 1rem;
            opacity: 0.1;
            z-index: -1;
        }
        
        /* Loading spinner for button */
        .loading-spinner {
            width: 1.25rem;
            height: 1.25rem;
            border: 2px solid rgba(99, 102, 241, 0.2);
            border-top-color: #6366f1;
            border-radius: 50%;
            animation: spin 0.75s linear infinite;
            display: inline-block;
        }
        
        @keyframes spin {
            to { transform: rotate(360deg); }
        }
        
        /* Pulse animation for icon */
        .pulse {
            animation: pulse 2s infinite;
        }
        
        @keyframes pulse {
            0% { box-shadow: 0 0 0 0 rgba(99, 102, 241, 0.4); }
            70% { box-shadow: 0 0 0 15px rgba(99, 102, 241, 0); }
            100% { box-shadow: 0 0 0 0 rgba(99, 102, 241, 0); }
        }
    </style>
</head>
<body class="bg-gray-50 min-h-screen flex flex-col antialiased">
    <!-- Background Elements -->
    <div class="fixed inset-0 overflow-hidden pointer-events-none">
        <div class="absolute -top-40 -right-40 w-96 h-96 bg-primary/5 rounded-full blur-3xl animate-float"></div>
        <div class="absolute -bottom-40 -left-40 w-96 h-96 bg-purple-300/10 rounded-full blur-3xl animate-float" style="animation-delay: 2s;"></div>
        <div class="absolute top-1/2 left-1/2 -translate-x-1/2 -translate-y-1/2 w-[800px] h-[800px] bg-primary/5 rounded-full blur-3xl opacity-30"></div>
    </div>

    <!-- Top Navigation with Breadcrumb - Consistent with sign-in/sign-up -->
    <div class="w-full bg-white/80 backdrop-blur-sm border-b border-gray-200 sticky top-0 z-50">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 py-4">
            <div class="flex items-center text-sm">
                <a href="/" class="text-gray-500 hover:text-primary transition flex items-center gap-1.5 group">
                    <i class="fas fa-home text-xs group-hover:text-primary"></i>
                    <span>Dashboard</span>
                </a>
                <i class="fas fa-chevron-right mx-2 text-xs text-gray-400"></i>
                <span class="text-primary font-medium bg-primary/5 px-2.5 py-1 rounded-full">Email Verification</span>
            </div>
        </div>
    </div>

    <!-- Main Content -->
    <div class="flex-1 flex items-center justify-center p-4">
        <div class="max-w-md w-full relative z-10">
            <!-- Logo - Consistent with sign-in/sign-up -->
            <div class="text-center mb-8">
                <div class="relative inline-block">
                    <div class="absolute inset-0 bg-primary/20 rounded-full blur-xl"></div>
                    <a href="/" class="relative inline-flex items-center space-x-2 hover-lift bg-white px-4 py-2 rounded-full shadow-sm">
                        <img src="{{ asset('images/dwcc.png') }}" alt="Dataworld Logo" class="h-8 w-auto">
                    </a>
                </div>
                <h1 class="text-2xl font-bold text-gray-800 mt-6">Email Verification</h1>
                <p class="text-gray-500 text-sm mt-1">Almost there! Check your inbox</p>
            </div>

            <!-- Success Message -->
            @if(session('success'))
                <div class="mb-4 p-4 bg-green-50 border-l-4 border-green-500 text-green-700 rounded-xl shadow-md animate__animated animate__fadeInDown">
                    <div class="flex items-center">
                        <div class="w-6 h-6 bg-green-100 rounded-full flex items-center justify-center mr-3">
                            <i class="fas fa-check-circle text-green-600 text-xs"></i>
                        </div>
                        <span>{{ session('success') }}</span>
                    </div>
                </div>
            @endif

            <!-- Error Message -->
            @if(session('error'))
                <div class="mb-4 p-4 bg-red-50 border-l-4 border-red-500 text-red-700 rounded-xl shadow-md">
                    <div class="flex items-center">
                        <div class="w-6 h-6 bg-red-100 rounded-full flex items-center justify-center mr-3">
                            <i class="fas fa-exclamation-circle text-red-600 text-xs"></i>
                        </div>
                        <span>{{ session('error') }}</span>
                    </div>
                </div>
            @endif

            <!-- Main Card -->
            <div class="bg-white rounded-2xl shadow-xl p-8 border border-gray-100 card-gradient-border relative">
                <!-- Decorative element - Consistent with sign-up -->
                <div class="absolute -top-3 left-1/2 -translate-x-1/2 w-20 h-1.5 bg-gradient-to-r from-primary to-primaryDark rounded-full"></div>
                
                <div class="text-center">
                    <!-- Animated Icon -->
                    <div class="relative inline-block mb-6">
                        <div class="w-24 h-24 bg-gradient-to-br from-primary to-primaryDark rounded-full flex items-center justify-center mx-auto shadow-xl pulse">
                            <i class="fas fa-envelope-open-text text-4xl text-white"></i>
                        </div>
                        <div class="absolute -bottom-2 -right-2 w-8 h-8 bg-green-500 rounded-full flex items-center justify-center border-4 border-white shadow-lg">
                            <i class="fas fa-check text-white text-xs"></i>
                        </div>
                    </div>
                    
                    <h2 class="text-2xl font-bold text-gray-800 mb-2">Check Your Inbox</h2>
                    
                    <p class="text-gray-600 mb-2">
                        We've sent a verification link to:
                    </p>
                    <div class="bg-primary/5 rounded-xl p-3 mb-6 border border-primary/10">
                        <strong class="text-primary text-lg break-all">{{ $email ?? session('registered_email') }}</strong>
                    </div>
                    
                    <!-- Timer/Expiry Card -->
                    <div class="bg-gradient-to-br from-amber-50 to-orange-50 border border-amber-200 rounded-xl p-5 mb-6 text-left">
                        <div class="flex items-start">
                            <div class="w-8 h-8 bg-amber-100 rounded-full flex items-center justify-center mr-3 flex-shrink-0">
                                <i class="fas fa-hourglass-half text-amber-600 text-sm"></i>
                            </div>
                            <div>
                                <div class="flex items-center gap-2 mb-1">
                                    <span class="text-sm font-semibold text-amber-800">Link expires in</span>
                                    <span class="bg-amber-200 text-amber-800 text-xs font-bold px-2 py-0.5 rounded-full">
                                        {{ config('auth.verification.expire', 60) }} minutes
                                    </span>
                                </div>
                                <p class="text-sm text-amber-700">
                                    For your security, this verification link will expire in {{ config('auth.verification.expire', 60) }} minutes. 
                                    If you don't verify within this time, you'll need to request a new verification email.
                                </p>
                            </div>
                        </div>
                    </div>

                    <div class="space-y-5">
                        <!-- Resend Form -->
                        <form action="{{ route('verification.resend') }}" method="POST" id="resendForm">
                            @csrf
                            <input type="hidden" name="email" value="{{ $email ?? session('registered_email') }}">
                            <button type="submit" 
                                    id="resendButton"
                                    class="w-full bg-white border-2 border-primary text-primary py-3 px-4 rounded-xl font-medium hover:bg-primary/5 transition-all duration-300 flex items-center justify-center space-x-2 group">
                                <i class="fas fa-redo-alt group-hover:rotate-180 transition-transform duration-500"></i>
                                <span>Resend verification email</span>
                            </button>
                        </form>

                        <!-- Divider -->
                        <div class="relative">
                            <div class="absolute inset-0 flex items-center">
                                <div class="w-full border-t border-gray-200"></div>
                            </div>
                            <div class="relative flex justify-center text-xs">
                                <span class="px-3 bg-white text-gray-400">or</span>
                            </div>
                        </div>

                        <!-- Back to Sign In -->
                        <a href="{{ route('sign-in') }}" class="inline-flex items-center justify-center text-sm text-gray-500 hover:text-primary transition-colors group">
                            <i class="fas fa-arrow-left mr-2 group-hover:-translate-x-1 transition-transform"></i>
                            Back to Sign In
                        </a>
                    </div>
                </div>
            </div>

            <!-- Help Card -->
            <div class="mt-6 bg-white/80 backdrop-blur-sm rounded-xl p-4 border border-gray-200 text-center">
                <p class="text-xs text-gray-500 flex items-center justify-center gap-2">
                    <i class="fas fa-shield-alt text-primary"></i>
                    <span>Didn't receive the email? Check your spam folder</span>
                </p>
                <p class="text-xs text-gray-400 mt-2">
                    Still having issues? <a href="#" class="text-primary hover:underline">Contact support</a>
                </p>
            </div>
        </div>
    </div>

    <!-- JavaScript for resend button loading state -->
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const resendForm = document.getElementById('resendForm');
            const resendButton = document.getElementById('resendButton');
            
            if (resendForm) {
                resendForm.addEventListener('submit', function(e) {
                    // Prevent double submission
                    if (resendButton.disabled) {
                        e.preventDefault();
                        return;
                    }
                    
                    // Show loading state
                    const originalContent = resendButton.innerHTML;
                    resendButton.disabled = true;
                    resendButton.innerHTML = `
                        <div class="loading-spinner mr-2"></div>
                        <span>Sending...</span>
                    `;
                    
                    // Re-enable after 5 seconds in case of error
                    setTimeout(() => {
                        if (resendButton.disabled) {
                            resendButton.disabled = false;
                            resendButton.innerHTML = originalContent;
                        }
                    }, 5000);
                });
            }
        });
    </script>
</body>
</html>