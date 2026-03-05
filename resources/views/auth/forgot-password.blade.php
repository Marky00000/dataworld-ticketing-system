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
                    }
                }
            }
        }
    </script>
    
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
        
        .hover-lift {
            transition: transform 0.3s ease, box-shadow 0.3s ease;
        }
        .hover-lift:hover {
            transform: translateY(-2px);
            box-shadow: 0 20px 25px -5px rgba(99, 102, 241, 0.1), 0 10px 10px -5px rgba(99, 102, 241, 0.04);
        }
        
        .input-focus:focus {
            border-color: #6366f1;
            box-shadow: 0 0 0 4px rgba(99, 102, 241, 0.1);
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
        
        /* Pulse animation for success message */
        .pulse-animation {
            animation: pulse 2s infinite;
        }
        
        @keyframes pulse {
            0%, 100% { opacity: 1; }
            50% { opacity: 0.8; }
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
<body class="bg-gray-50 min-h-screen flex flex-col antialiased">
    <!-- Background Elements -->
    <div class="fixed inset-0 overflow-hidden pointer-events-none">
        <div class="absolute -top-40 -right-40 w-96 h-96 bg-primary/5 rounded-full blur-3xl animate-float"></div>
        <div class="absolute -bottom-40 -left-40 w-96 h-96 bg-purple-300/10 rounded-full blur-3xl animate-float" style="animation-delay: 2s;"></div>
        <div class="absolute top-1/2 left-1/2 -translate-x-1/2 -translate-y-1/2 w-[800px] h-[800px] bg-primary/5 rounded-full blur-3xl opacity-30"></div>
    </div>

    <!-- Top Navigation with Breadcrumb -->
    <div class="w-full bg-white/80 backdrop-blur-sm border-b border-gray-200 sticky top-0 z-10">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 py-4">
            <div class="flex items-center text-sm">
                <a href="/" class="text-gray-500 hover:text-primary transition flex items-center gap-1.5 group">
                    <i class="fas fa-home text-xs group-hover:text-primary"></i>
                    <span>Home</span>
                </a>
                <i class="fas fa-chevron-right mx-2 text-xs text-gray-400"></i>
                <a href="{{ route('sign-in') }}" class="text-gray-500 hover:text-primary transition">Sign In</a>
                <i class="fas fa-chevron-right mx-2 text-xs text-gray-400"></i>
                <span class="text-primary font-medium bg-primary/5 px-2.5 py-1 rounded-full">Reset Password</span>
            </div>
        </div>
    </div>

    <!-- Main Content -->
    <div class="flex-grow flex items-center justify-center p-4">
        <div class="w-full max-w-md relative z-10">
            
            <!-- Logo & Header -->
            <div class="text-center mb-8">
                <div class="relative inline-block">
                    <div class="absolute inset-0 bg-primary/20 rounded-full blur-xl"></div>
                    <a href="/" class="relative inline-flex items-center space-x-2 hover-lift bg-white px-4 py-2 rounded-full shadow-sm">
                        <img src="{{ asset('images/dwcc.png') }}" 
                             alt="Dataworld Logo" 
                             class="h-8 w-auto">
                    </a>
                </div>
                <h1 class="text-3xl font-bold text-gray-800 mt-6">Reset Password</h1>
                <p class="text-gray-500 text-sm mt-1">Enter your email to receive a reset link</p>
            </div>

           <!-- Alert Messages -->
            @if(session('status') || session('success'))
                <div class="mb-6 p-5 bg-green-50 border-l-4 border-green-500 rounded-r-xl shadow-sm">
                    <div class="flex items-start">
                        <div class="flex-shrink-0">
                            <div class="w-10 h-10 bg-green-100 rounded-full flex items-center justify-center">
                                <i class="fas fa-check-circle text-green-600 text-xl"></i>
                            </div>
                        </div>
                        <div class="ml-4 flex-1">
                            <h3 class="text-lg font-semibold text-green-800">Password Reset Email Sent</h3>
                            <p class="text-green-700 mt-1">{{ session('status') ?? session('success') }}</p>
                        </div>
                    </div>
                </div>
            @endif

            @if($errors->any())
                <div class="mb-6 p-5 bg-red-50 border-l-4 border-red-500 rounded-r-xl shadow-sm">
                    <div class="flex items-start">
                        <div class="flex-shrink-0">
                            <div class="w-10 h-10 bg-red-100 rounded-full flex items-center justify-center">
                                <i class="fas fa-exclamation-circle text-red-600 text-xl"></i>
                            </div>
                        </div>
                        <div class="ml-4 flex-1">
                            <h3 class="text-lg font-semibold text-red-800">Unable to Process Request</h3>
                            <div class="mt-2 space-y-1">
                                @foreach($errors->all() as $error)
                                    <p class="text-sm text-red-700">• {{ $error }}</p>
                                @endforeach
                            </div>
                            <div class="mt-4">
                                <a href="{{ route('forgot-password') }}" class="inline-flex items-center text-sm text-red-700 hover:text-red-800 font-medium">
                                    <i class="fas fa-redo-alt mr-2"></i>
                                    Try Again
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
            @endif

            <!-- Info Message (shows when no errors) -->
            @if(!session('status') && !session('success') && !$errors->any())
                <div class="mb-6 p-5 bg-blue-50 border-l-4 border-blue-500 rounded-r-xl shadow-sm">
                    <div class="flex items-start">
                        <div class="flex-shrink-0">
                            <div class="w-10 h-10 bg-blue-100 rounded-full flex items-center justify-center">
                                <i class="fas fa-info-circle text-blue-600 text-xl"></i>
                            </div>
                        </div>
                        <div class="ml-4 flex-1">
                            <h3 class="text-lg font-semibold text-blue-800">How Password Reset Works</h3>
                            <div class="mt-3 space-y-3">
                                <div class="flex items-start gap-3">
                                    <div class="w-5 h-5 bg-blue-200 rounded-full flex items-center justify-center mt-0.5">
                                        <span class="text-xs font-bold text-blue-700">1</span>
                                    </div>
                                    <p class="text-sm text-blue-700">Enter your registered email address below</p>
                                </div>
                                <div class="flex items-start gap-3">
                                    <div class="w-5 h-5 bg-blue-200 rounded-full flex items-center justify-center mt-0.5">
                                        <span class="text-xs font-bold text-blue-700">2</span>
                                    </div>
                                    <p class="text-sm text-blue-700">We'll send a password reset link to your inbox</p>
                                </div>
                                <div class="flex items-start gap-3">
                                    <div class="w-5 h-5 bg-blue-200 rounded-full flex items-center justify-center mt-0.5">
                                        <span class="text-xs font-bold text-blue-700">3</span>
                                    </div>
                                    <p class="text-sm text-blue-700">Click the link to create a new password</p>
                                </div>
                            </div>
                            <p class="text-xs text-blue-600 mt-4">
                                <i class="fas fa-clock mr-1"></i> 
                                Reset links expire after 60 minutes for security
                            </p>
                        </div>
                    </div>
                </div>
            @endif

            <!-- Reset Form Card -->
            <div class="bg-white rounded-2xl shadow-xl p-8 border border-gray-100 card-gradient-border relative">
                <!-- Decorative element -->
                <div class="absolute -top-3 left-1/2 -translate-x-1/2 w-20 h-1.5 bg-gradient-to-r from-primary to-primaryDark rounded-full"></div>
                
                <form action="{{ route('forgot-password.post') }}" method="POST" id="resetForm">
                    @csrf
                    
                    <div class="space-y-6">
                        <!-- Email -->
                        <div>
                            <label for="email" class="block text-xs font-semibold text-gray-700 uppercase tracking-wider mb-1.5 flex items-center">
                                <div class="w-5 h-5 bg-primary/10 rounded-full flex items-center justify-center mr-1.5">
                                    <i class="fas fa-envelope text-primary text-[10px]"></i>
                                </div>
                                Email Address
                            </label>
                            <div class="relative">
                                <input type="email" 
                                       id="email" 
                                       name="email" 
                                       value="{{ old('email') }}"
                                       required
                                       class="w-full px-4 py-3.5 rounded-xl border border-gray-200 focus:outline-none focus:ring-2 focus:ring-primary/20 focus:border-primary transition-all text-sm bg-gray-50/50 hover:bg-white focus:bg-white"
                                       placeholder="you@company.com"
                                       autocomplete="email"
                                       autofocus>
                                <i class="fas fa-envelope absolute right-4 top-3.5 text-gray-400 text-sm"></i>
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
                                class="w-full bg-gradient-to-r from-primary to-primaryDark text-white py-3.5 px-4 rounded-xl font-medium hover:shadow-xl hover:shadow-primary/20 transition-all duration-300 flex items-center justify-center space-x-2 disabled:opacity-50 disabled:cursor-not-allowed text-sm group relative overflow-hidden">
                            <span class="absolute inset-0 bg-white/10 translate-y-full group-hover:translate-y-0 transition-transform"></span>
                            <i class="fas fa-paper-plane relative z-10 group-hover:rotate-12 transition-transform"></i>
                            <span class="relative z-10">Send Reset Link</span>
                        </button>

                        <!-- Security Note -->
                        <div class="flex items-center justify-center gap-2 text-[10px] text-gray-400 pt-2">
                            <i class="fas fa-clock text-primary"></i>
                            <span>Link expires in 60 minutes</span>
                            <span class="w-1 h-1 bg-gray-300 rounded-full"></span>
                            <i class="fas fa-lock text-primary"></i>
                            <span>Secure</span>
                        </div>
                    </div>
                </form>

                <!-- Additional Links -->
                <div class="mt-6 pt-6 border-t border-gray-100">
                    <div class="flex flex-col items-center space-y-3">
                        <a href="{{ route('sign-in') }}" class="text-primary hover:text-primaryDark transition flex items-center space-x-2 group text-sm">
                            <i class="fas fa-arrow-left group-hover:-translate-x-1 transition-transform"></i>
                            <span>Back to Sign In</span>
                        </a>
                        
                        <p class="text-xs text-gray-400">
                            Don't have an account? 
                            <a href="{{ route('sign-up') }}" class="text-primary hover:text-primaryDark font-medium">
                                Sign up
                            </a>
                        </p>
                    </div>
                </div>
            </div>
            
            <!-- Footer note -->
            <p class="text-center text-xs text-gray-400 mt-6 flex items-center justify-center gap-2">
                <i class="fas fa-shield-alt text-primary"></i>
                Need help? Contact support at support@dataworld.com.ph
            </p>
        </div>
    </div>

    <!-- Vanilla JavaScript for interactivity -->
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
                    const originalContent = submitButton.innerHTML;
                    submitButton.disabled = true;
                    submitButton.innerHTML = `
                        <div class="loading-spinner mr-2"></div>
                        <span>Sending reset link...</span>
                    `;
                });
            }

            // Prevent double submission
            let submitted = false;
            resetForm?.addEventListener('submit', function(e) {
                if (submitted) {
                    e.preventDefault();
                    return;
                }
                submitted = true;
            });

            // Add floating label effect
            const input = document.querySelector('input[type="email"]');
            if (input) {
                input.addEventListener('focus', function() {
                    this.parentElement.classList.add('ring-2', 'ring-primary/10', 'rounded-xl');
                });
                input.addEventListener('blur', function() {
                    this.parentElement.classList.remove('ring-2', 'ring-primary/10', 'rounded-xl');
                });
            }

            // Auto-hide error message after 5 seconds
            const errorMessage = document.getElementById('errorMessage');
            if (errorMessage) {
                setTimeout(() => {
                    errorMessage.style.transition = 'opacity 0.5s ease';
                    errorMessage.style.opacity = '0';
                    setTimeout(() => {
                        errorMessage.style.display = 'none';
                    }, 500);
                }, 5000);
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
        });
    </script>

</body>
</html>