<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="icon" type="image/png" href="{{ asset('images/logo.png') }}">
    <title>Reset Password - Dataworld Support Portal</title>
    
    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    
    <!-- Tailwind CSS -->
    <script src="https://cdn.tailwindcss.com"></script>
    
    <!-- Tailwind Configuration -->
    <script>
        tailwind.config = {
            theme: {
                extend: {
                    colors: {
                        primary: '#6366f1',
                        primaryDark: '#4f46e5',
                        primaryLight: '#e0e7ff',
                        darkBlue: '#1e2b4f',
                    }
                }
            }
        }
    </script>
    
    <style>
        .gradient-bg {
            background: linear-gradient(135deg, #1e2b4f 0%, #2a3a6a 50%, #1e2b4f 100%);
        }
        
        .hover-lift {
            transition: transform 0.3s ease, box-shadow 0.3s ease;
        }
        .hover-lift:hover {
            transform: translateY(-2px);
            box-shadow: 0 20px 25px -5px rgba(99, 102, 241, 0.1);
        }
        
        .animate-float {
            animation: float 6s ease-in-out infinite;
        }
        
        @keyframes float {
            0%, 100% { transform: translateY(0px); }
            50% { transform: translateY(-20px); }
        }
        
        /* Loading spinner */
        .loading-spinner {
            width: 1.25rem;
            height: 1.25rem;
            border: 2px solid rgba(255,255,255,0.3);
            border-top-color: white;
            border-radius: 50%;
            animation: spin 0.75s linear infinite;
            display: inline-block;
        }
        
        @keyframes spin {
            to { transform: rotate(360deg); }
        }

        /* Stats card */
        .stat-card {
            background: rgba(255, 255, 255, 0.05);
            backdrop-filter: blur(10px);
            border: 1px solid rgba(255, 255, 255, 0.1);
            transition: all 0.3s ease;
        }
        .stat-card:hover {
            background: rgba(255, 255, 255, 0.1);
            transform: translateY(-4px);
            border-color: rgba(255, 255, 255, 0.2);
        }

        /* Shake animation for errors */
        @keyframes shake {
            0%, 100% { transform: translateX(0); }
            10%, 30%, 50%, 70%, 90% { transform: translateX(-2px); }
            20%, 40%, 60%, 80% { transform: translateX(2px); }
        }
        .shake {
            animation: shake 0.6s ease-in-out;
        }
    </style>
</head>
<body class="min-h-screen flex">
    <!-- Left Column - Branding & Stats -->
    <div class="hidden lg:flex lg:w-1/2 gradient-bg p-12 flex-col justify-between relative overflow-hidden">
        <!-- Animated background elements -->
        <div class="absolute inset-0 opacity-20">
            <div class="absolute top-20 left-10 w-64 h-64 bg-white/10 rounded-full blur-3xl animate-float"></div>
            <div class="absolute bottom-20 right-10 w-80 h-80 bg-primary/20 rounded-full blur-3xl animate-float" style="animation-delay: 2s;"></div>
        </div>
        
        <!-- Logo -->
        <div class="relative z-10">
        </div>
        
        <!-- Center Content -->
        <div class="relative z-10 text-center max-w-md mx-auto">
            <h2 class="text-4xl font-bold text-white mb-4">Forgot your password?</h2>
            <p class="text-white/80 text-lg mb-12">No worries! We'll help you reset it and get back to managing your support tickets.</p>            
            
            <!-- Stats -->
            <div class="grid grid-cols-3 gap-6">
                <div class="stat-card rounded-2xl p-6 text-center transition-all duration-300">
                    <div class="w-14 h-14 bg-white/20 rounded-xl flex items-center justify-center mx-auto mb-3 backdrop-blur-sm">
                        <i class="fas fa-clock text-white text-2xl"></i>
                    </div>
                    <div class="text-white/90 text-sm font-medium">Quick Reset</div>
                    <div class="text-white/50 text-xs mt-1">60-min link</div>
                </div>
                <div class="stat-card rounded-2xl p-6 text-center transition-all duration-300">
                    <div class="w-14 h-14 bg-white/20 rounded-xl flex items-center justify-center mx-auto mb-3 backdrop-blur-sm">
                        <i class="fas fa-shield-alt text-white text-2xl"></i>
                    </div>
                    <div class="text-white/90 text-sm font-medium">Secure</div>
                    <div class="text-white/50 text-xs mt-1">Encrypted</div>
                </div>
                <div class="stat-card rounded-2xl p-6 text-center transition-all duration-300">
                    <div class="w-14 h-14 bg-white/20 rounded-xl flex items-center justify-center mx-auto mb-3 backdrop-blur-sm">
                        <i class="fas fa-headset text-white text-2xl"></i>
                    </div>
                    <div class="text-white/90 text-sm font-medium">24/7</div>
                    <div class="text-white/50 text-xs mt-1">Support</div>
                </div>
            </div>

            <!-- Reset Process Steps -->
            <div class="mt-12 text-left bg-white/5 rounded-2xl p-6 backdrop-blur-sm border border-white/10">
                <h3 class="text-white font-medium mb-4 flex items-center">
                    <i class="fas fa-key text-yellow-400 mr-2"></i>
                    How to reset your password
                </h3>
                <div class="space-y-3">
                    <div class="flex items-start gap-3">
                        <div class="w-6 h-6 bg-white/10 rounded-full flex items-center justify-center flex-shrink-0 mt-0.5">
                            <span class="text-xs font-bold text-white">1</span>
                        </div>
                        <p class="text-sm text-white/80">Enter your registered email address</p>
                    </div>
                    <div class="flex items-start gap-3">
                        <div class="w-6 h-6 bg-white/10 rounded-full flex items-center justify-center flex-shrink-0 mt-0.5">
                            <span class="text-xs font-bold text-white">2</span>
                        </div>
                        <p class="text-sm text-white/80">Check your inbox for the reset link</p>
                    </div>
                    <div class="flex items-start gap-3">
                        <div class="w-6 h-6 bg-white/10 rounded-full flex items-center justify-center flex-shrink-0 mt-0.5">
                            <span class="text-xs font-bold text-white">3</span>
                        </div>
                        <p class="text-sm text-white/80">Create a new password and log in</p>
                    </div>
                </div>
                <p class="text-xs text-white/50 mt-4 flex items-center">
                    <i class="fas fa-clock mr-1"></i>
                    Reset links expire after 60 minutes for security
                </p>
            </div>
        </div>
        
        <!-- Footer -->
        <div class="relative z-10 text-white/40 text-sm flex justify-between items-center">
            <span>© {{ date('Y') }} Dataworld Computer Center</span>
            <span class="text-white/20">|</span>
            <span class="text-white/30">Secure Portal</span>
        </div>
    </div>

    <!-- Right Column - Reset Password Form -->
    <div class="w-full lg:w-1/2 flex items-center justify-center p-8 bg-gradient-to-br from-gray-50 to-gray-100">
        <div class="w-full max-w-md">
            
            <!-- Mobile Logo (visible only on mobile) -->
            <div class="lg:hidden text-center mb-8">
                <div class="inline-flex items-center space-x-2 bg-white px-4 py-2 rounded-full shadow-lg">
                    <div class="w-8 h-8 bg-primary rounded-lg flex items-center justify-center">
                        <i class="fas fa-ticket-alt text-white text-sm"></i>
                    </div>
                    <span class="font-semibold text-gray-900">Dataworld</span>
                </div>
            </div>

            <!-- Header -->
            <div class="text-center mb-8">
                <h1 class="text-3xl font-bold text-gray-900">Reset password</h1>
                <p class="text-gray-500 mt-2">Enter your email to receive a reset link</p>
            </div>

            <!-- Alert Messages -->
            @if(session('status') || session('success'))
                <div class="mb-6 p-5 bg-green-50 rounded-xl border border-green-200 shadow-sm">
                    <div class="flex items-start">
                        <div class="flex-shrink-0">
                            <div class="w-10 h-10 bg-green-100 rounded-full flex items-center justify-center">
                                <i class="fas fa-check-circle text-green-600 text-xl"></i>
                            </div>
                        </div>
                        <div class="ml-4 flex-1">
                            <h3 class="font-semibold text-green-800">Password Reset Email Sent</h3>
                            <p class="text-sm text-green-700 mt-1">{{ session('status') ?? session('success') }}</p>
                        </div>
                    </div>
                </div>
            @endif

            @if($errors->any())
                <div class="mb-6 p-5 bg-red-50 rounded-xl border border-red-200 shadow-sm shake">
                    <div class="flex items-start">
                        <div class="flex-shrink-0">
                            <div class="w-10 h-10 bg-red-100 rounded-full flex items-center justify-center">
                                <i class="fas fa-exclamation-circle text-red-600 text-xl"></i>
                            </div>
                        </div>
                        <div class="ml-4 flex-1">
                            <h3 class="font-semibold text-red-800">Unable to Process Request</h3>
                            <div class="mt-2 space-y-1">
                                @foreach($errors->all() as $error)
                                    <p class="text-sm text-red-700">• {{ $error }}</p>
                                @endforeach
                            </div>
                        </div>
                    </div>
                </div>
            @endif

            <!-- Reset Form -->
            <form action="{{ route('forgot-password.post') }}" method="POST" id="resetForm" class="bg-white rounded-2xl shadow-xl p-8 border border-gray-100">
                @csrf
                
                <div class="space-y-6">
                    <!-- Email -->
                    <div>
                        <label for="email" class="block text-sm font-medium text-gray-700 mb-1.5">
                            Email address
                        </label>
                        <div class="relative">
                            <input type="email" 
                                   id="email" 
                                   name="email" 
                                   value="{{ old('email') }}"
                                   required
                                   class="w-full px-4 py-3 pr-12 rounded-xl border border-gray-300 focus:outline-none focus:ring-2 focus:ring-primary/20 focus:border-primary transition-all"
                                   placeholder="you@company.com"
                                   autocomplete="email"
                                   autofocus>
                            <i class="fas fa-envelope absolute right-4 top-3.5 text-gray-400"></i>
                        </div>
                        @error('email')
                            <p class="text-xs text-red-600 mt-1.5 flex items-center gap-1">
                                <i class="fas fa-exclamation-circle"></i>
                                {{ $message }}
                            </p>
                        @enderror
                    </div>

                    <!-- Submit Button -->
                    <button type="submit"
                            id="submitButton"
                            class="w-full bg-primary hover:bg-primaryDark text-white py-3 px-4 rounded-xl font-medium hover:shadow-lg hover:shadow-primary/25 transition-all duration-300 flex items-center justify-center space-x-2 disabled:opacity-50">
                        <i class="fas fa-paper-plane"></i>
                        <span>Send Reset Link</span>
                    </button>

                    <!-- Security Note -->
                    <div class="flex items-center justify-center gap-3 text-xs text-gray-400 pt-2">
                        <span class="flex items-center">
                            <i class="fas fa-clock text-primary mr-1"></i>
                            60-min expiry
                        </span>
                        <span class="w-1 h-1 bg-gray-300 rounded-full"></span>
                        <span class="flex items-center">
                            <i class="fas fa-lock text-primary mr-1"></i>
                            Secure
                        </span>
                    </div>
                </div>
            </form>

            <!-- Additional Links -->
            <div class="mt-8 text-center">
                <a href="{{ route('sign-in') }}" class="text-sm text-primary hover:text-primaryDark transition flex items-center justify-center space-x-2 group">
                    <i class="fas fa-arrow-left group-hover:-translate-x-1 transition-transform"></i>
                    <span>Back to Sign In</span>
                </a>
                
            </div>

            <!-- Security note -->
            <p class="mt-6 text-center text-xs text-gray-400 flex items-center justify-center">
                <i class="fas fa-shield-alt text-primary mr-1"></i>
                Secure password reset · 256-bit encryption
            </p>
        </div>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            // Auto-focus email field
            const emailField = document.getElementById('email');
            if (emailField) {
                emailField.focus();
            }

            // Form submission with loading state
            const resetForm = document.getElementById('resetForm');
            const submitButton = document.getElementById('submitButton');
            
            if (resetForm) {
                resetForm.addEventListener('submit', function(e) {
                    if (!resetForm.checkValidity()) {
                        e.preventDefault();
                        return;
                    }
                    
                    // Show loading state
                    submitButton.disabled = true;
                    submitButton.innerHTML = `
                        <div class="loading-spinner mr-2"></div>
                        <span>Sending reset link...</span>
                    `;
                });
            }

            // Prevent double submission
            let submitted = false;
            if (resetForm) {
                resetForm.addEventListener('submit', function(e) {
                    if (submitted) {
                        e.preventDefault();
                        return;
                    }
                    submitted = true;
                });
            }

            // Validate email as user types
            if (emailField) {
                emailField.addEventListener('input', function() {
                    const email = this.value;
                    const isValid = /^[^\s@]+@[^\s@]+\.[^\s@]+$/.test(email);
                    
                    if (email.length > 0) {
                        if (isValid) {
                            this.classList.add('border-green-500', 'bg-green-50/50');
                            this.classList.remove('border-red-300', 'bg-red-50/50');
                        } else {
                            this.classList.add('border-red-300', 'bg-red-50/50');
                            this.classList.remove('border-green-500', 'bg-green-50/50');
                        }
                    } else {
                        this.classList.remove('border-green-500', 'bg-green-50/50', 'border-red-300', 'bg-red-50/50');
                    }
                });
            }

            // Auto-hide error message after 5 seconds
            const errorMessage = document.querySelector('.bg-red-50');
            if (errorMessage) {
                setTimeout(() => {
                    errorMessage.style.transition = 'opacity 0.5s ease';
                    errorMessage.style.opacity = '0';
                    setTimeout(() => {
                        errorMessage.style.display = 'none';
                    }, 500);
                }, 5000);
            }
        });
    </script>

</body>
</html>