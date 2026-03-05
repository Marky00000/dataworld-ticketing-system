<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="icon" type="image/png" href="{{ asset('images/logo.png') }}">
    <title>Sign In - Dataworld Support Portal</title>
    
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
        
        /* Breadcrumb styling */
        .breadcrumb-hover {
            transition: color 0.2s ease;
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
                    <span>Dashboard</span>
                </a>
                <i class="fas fa-chevron-right mx-2 text-xs text-gray-400"></i>
                <span class="text-primary font-medium bg-primary/5 px-2.5 py-1 rounded-full">Sign In</span>
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
                <h1 class="text-3xl font-bold text-gray-800 mt-6">Welcome Back</h1>
                <p class="text-gray-500 text-sm mt-1">Sign in to access your support portal</p>
            </div>

            <!-- Alert Messages -->
            @if(session('success'))
                <div class="mb-4 p-4 bg-green-50 text-green-700 rounded-xl border border-green-200 text-sm animate__animated animate__fadeInDown">
                    <div class="flex items-center space-x-2">
                        <div class="w-6 h-6 bg-green-100 rounded-full flex items-center justify-center">
                            <i class="fas fa-check-circle text-green-600 text-xs"></i>
                        </div>
                        <span>{{ session('success') }}</span>
                    </div>
                </div>
            @endif

            @if($errors->any())
                <div class="mb-4 p-4 bg-red-50 text-red-700 rounded-xl border border-red-200 text-sm">
                    <div class="flex items-center space-x-2 mb-2">
                        <div class="w-6 h-6 bg-red-100 rounded-full flex items-center justify-center">
                            <i class="fas fa-exclamation-circle text-red-600 text-xs"></i>
                        </div>
                        <span class="font-medium">Unable to sign in</span>
                    </div>
                    <ul class="list-disc list-inside text-xs space-y-1 ml-8">
                        @foreach($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <!-- Sign In Form Card -->
            <div class="bg-white rounded-2xl shadow-xl p-8 border border-gray-100 card-gradient-border relative">
                <!-- Decorative element -->
                <div class="absolute -top-3 left-1/2 -translate-x-1/2 w-20 h-1.5 bg-gradient-to-r from-primary to-primaryDark rounded-full"></div>
                
                <form action="{{ route('sign-in.post') }}" method="POST" id="signinForm">
                    @csrf
                    
                    <div class="space-y-5">
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
                                       class="w-full px-4 py-3 rounded-xl border border-gray-200 focus:outline-none focus:ring-2 focus:ring-primary/20 focus:border-primary transition-all text-sm bg-gray-50/50 hover:bg-white focus:bg-white"
                                       placeholder="you@company.com"
                                       autocomplete="email">
                                <i class="fas fa-check-circle absolute right-3 top-3.5 text-green-500 text-sm opacity-0 peer-valid:opacity-100 transition-opacity"></i>
                            </div>
                        </div>

                        <!-- Password -->
                        <div>
                            <div class="flex items-center justify-between mb-1.5">
                                <label for="password" class="block text-xs font-semibold text-gray-700 uppercase tracking-wider flex items-center">
                                    <div class="w-5 h-5 bg-primary/10 rounded-full flex items-center justify-center mr-1.5">
                                        <i class="fas fa-lock text-primary text-[10px]"></i>
                                    </div>
                                    Password
                                </label>
                                <a href="{{ route('forgot-password') }}" class="text-xs text-primary hover:text-primaryDark transition flex items-center gap-1">
                                    <i class="fas fa-question-circle"></i>
                                    Forgot Password?
                                </a>
                            </div>
                            <div class="relative">
                                <input type="password" 
                                       id="password" 
                                       name="password" 
                                       required
                                       class="w-full px-4 py-3 pr-12 rounded-xl border border-gray-200 focus:outline-none focus:ring-2 focus:ring-primary/20 focus:border-primary transition-all text-sm bg-gray-50/50 hover:bg-white focus:bg-white"
                                       placeholder="••••••••"
                                       autocomplete="current-password">
                                <button type="button" 
                                        id="togglePasswordBtn"
                                        class="absolute right-3 top-3 text-gray-400 hover:text-primary transition-colors focus:outline-none">
                                    <i class="fas fa-eye text-sm"></i>
                                </button>
                            </div>
                        </div>

                        <!-- Remember Me -->
                        <div class="flex items-center justify-between">
                            <label class="flex items-center cursor-pointer group">
                                <input type="checkbox" 
                                       id="remember" 
                                       name="remember"
                                       value="1"
                                       {{ old('remember') ? 'checked' : '' }}
                                       class="h-4 w-4 text-primary rounded border-gray-300 focus:ring-primary/20 transition">
                                <span class="ml-2 text-sm text-gray-600 group-hover:text-primary transition">
                                    Keep me signed in
                                </span>
                            </label>
                            
                            <div class="flex items-center text-xs text-gray-400">
                                <i class="fas fa-shield-alt mr-1"></i>
                                <span>Secure login</span>
                            </div>
                        </div>

                        <!-- Submit Button -->
                        <button type="submit"
                                id="submitButton"
                                class="w-full bg-gradient-to-r from-primary to-primaryDark text-white py-3.5 px-4 rounded-xl font-medium hover:shadow-xl hover:shadow-primary/20 transition-all duration-300 flex items-center justify-center space-x-2 disabled:opacity-50 disabled:cursor-not-allowed text-sm group relative overflow-hidden">
                            <span class="absolute inset-0 bg-white/10 translate-y-full group-hover:translate-y-0 transition-transform"></span>
                            <i class="fas fa-sign-in-alt relative z-10"></i>
                            <span class="relative z-10">Sign In to Dashboard</span>
                        </button>
                    </div>
                </form>

                <!-- Sign Up Link -->
                <div class="mt-8 pt-6 border-t border-gray-100">
                    <p class="text-sm text-gray-500 text-center">
                        New to Dataworld Support?
                        <a href="{{ route('sign-up') }}" class="text-primary font-semibold hover:text-primaryDark transition ml-1 group">
                            Create account
                            <i class="fas fa-arrow-right text-xs ml-1 group-hover:translate-x-1 transition-transform"></i>
                        </a>
                    </p>
                    
                    <!-- Trust badges -->
                    <div class="flex items-center justify-center gap-3 mt-4 text-[10px] text-gray-400">
                        <span class="flex items-center gap-1">
                            <i class="fas fa-user-secret text-primary"></i> Private & Secure
                        </span> 
                        <span class="w-1 h-1 bg-gray-300 rounded-full"></span>
                        <span class="flex items-center gap-1">
                            <i class="fas fa-clock text-primary"></i> 24/7 Access
                        </span>
                        <span class="w-1 h-1 bg-gray-300 rounded-full"></span>
                        <span class="flex items-center gap-1">
                            <i class="fas fa-headset text-primary"></i> Free Support
                        </span>
                    </div>
                </div>
            </div>
            
            <!-- Footer note -->
            <p class="text-center text-xs text-gray-400 mt-6 flex items-center justify-center gap-2">
                <i class="fas fa-shield-alt text-primary"></i>
                Free portal exclusively for Dataworld clients
            </p>
        </div>
    </div>

    <!-- Vanilla JavaScript for interactivity -->
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            // Password toggle functionality
            const togglePasswordBtn = document.getElementById('togglePasswordBtn');
            const passwordInput = document.getElementById('password');
            
            if (togglePasswordBtn && passwordInput) {
                togglePasswordBtn.addEventListener('click', function() {
                    const type = passwordInput.type === 'password' ? 'text' : 'password';
                    passwordInput.type = type;
                    const icon = this.querySelector('i');
                    if (icon) {
                        icon.className = type === 'password' ? 'fas fa-eye text-sm' : 'fas fa-eye-slash text-sm';
                    }
                });
            }
            
            // Form submission
            const signinForm = document.getElementById('signinForm');
            const submitButton = document.getElementById('submitButton');
            
            if (signinForm) {
                signinForm.addEventListener('submit', function(e) {
                    if (!signinForm.checkValidity()) {
                        e.preventDefault();
                        return;
                    }
                    
                    // Show loading state
                    const originalContent = submitButton.innerHTML;
                    submitButton.disabled = true;
                    submitButton.innerHTML = `
                        <div class="loading-spinner"></div>
                        <span>Signing in...</span>
                    `;
                });
            }
            
            // Auto-focus email field
            const emailField = document.getElementById('email');
            if (emailField) {
                emailField.focus();
            }

            // Prevent double submission
            let submitted = false;
            signinForm?.addEventListener('submit', function(e) {
                if (submitted) {
                    e.preventDefault();
                    return;
                }
                submitted = true;
            });

            // Add floating label effect
            const inputs = document.querySelectorAll('input[type="email"], input[type="password"]');
            inputs.forEach(input => {
                input.addEventListener('focus', function() {
                    this.parentElement.classList.add('ring-2', 'ring-primary/10', 'rounded-xl');
                });
                input.addEventListener('blur', function() {
                    this.parentElement.classList.remove('ring-2', 'ring-primary/10', 'rounded-xl');
                });
            });
        });
    </script>

</body>
</html>