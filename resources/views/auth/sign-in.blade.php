<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="icon" type="image/png" href="{{ asset('images/logo.png') }}">
    <title>Client Support Portal - Dataworld Ticketing System</title>
    
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
                        primaryDark: '#4f46e5'
                    }
                }
            }
        }
    </script>
    
    <style>
        .gradient-bg {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
        }
        
        .hover-lift {
            transition: transform 0.3s ease, box-shadow 0.3s ease;
        }
        .hover-lift:hover {
            transform: translateY(-2px);
            box-shadow: 0 10px 25px rgba(99, 102, 241, 0.15);
        }
        
        .input-focus:focus {
            border-color: #6366f1;
            box-shadow: 0 0 0 3px rgba(99, 102, 241, 0.1);
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
    </style>
</head>
<body class="bg-gray-50 min-h-screen flex flex-col">
    <!-- Background Elements -->
    <div class="fixed inset-0 overflow-hidden pointer-events-none">
        <div class="absolute -top-40 -right-40 w-80 h-80 bg-primary/10 rounded-full blur-3xl animate-float"></div>
        <div class="absolute -bottom-40 -left-40 w-80 h-80 bg-purple-300/10 rounded-full blur-3xl animate-float" style="animation-delay: 2s;"></div>
    </div>

    <!-- Top Navigation with Breadcrumb -->
    <div class="w-full bg-white/80 backdrop-blur-sm border-b border-gray-200 sticky top-0 z-10">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 py-3">
            <div class="flex items-center text-sm">
                <a href="/" class="text-gray-500 hover:text-primary transition flex items-center gap-1">
                    <i class="fas fa-home text-xs"></i>
                    <span>Dashboard</span>
                </a>
                <i class="fas fa-chevron-right mx-2 text-xs text-gray-400"></i>
                <span class="text-primary font-medium">Sign In</span>
            </div>
        </div>
    </div>

    <!-- Main Content -->
    <div class="flex-grow flex items-center justify-center p-4">
        <div class="w-full max-w-md relative z-10">
            
            <!-- Logo -->
            <div class="text-center mb-6">
                <a href="/" class="inline-flex items-center space-x-2 hover-lift">
                    <img src="{{ asset('images/dwcc.png') }}" 
                         alt="Dataworld Logo" 
                         class="h-10 w-auto">
                    <span class="text-xl font-bold text-primary">Dataworld</span>
                </a>
                <h1 class="text-2xl font-bold text-gray-800 mt-4">Welcome Back</h1>
                <p class="text-gray-500 text-sm">Sign in to your support account</p>
            </div>

            @if(session('success'))
                <div class="mb-4 p-3 bg-green-50 text-green-700 rounded-lg border border-green-200 text-sm">
                    <div class="flex items-center space-x-2">
                        <i class="fas fa-check-circle"></i>
                        <span>{{ session('success') }}</span>
                    </div>
                </div>
            @endif

            @if($errors->any())
                <div class="mb-4 p-3 bg-red-50 text-red-700 rounded-lg border border-red-200 text-sm">
                    <div class="flex items-center space-x-2 mb-1">
                        <i class="fas fa-exclamation-circle"></i>
                        <span class="font-medium">Please fix the following:</span>
                    </div>
                    <ul class="list-disc list-inside text-xs space-y-0.5">
                        @foreach($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <!-- Sign In Form -->
            <div class="bg-white rounded-xl shadow-lg p-6 hover-lift border border-gray-100">
                <form action="{{ route('sign-in.post') }}" method="POST" id="signinForm">
                    @csrf
                    
                    <div class="space-y-4">
                        <!-- Email -->
                        <div>
                            <label for="email" class="block text-xs font-medium text-gray-600 uppercase tracking-wider mb-1.5">
                                <i class="fas fa-envelope text-primary mr-1"></i>
                                Email Address
                            </label>
                            <input type="email" 
                                   id="email" 
                                   name="email" 
                                   value="{{ old('email') }}"
                                   required
                                   class="w-full px-3 py-2.5 rounded-lg border border-gray-300 focus:outline-none focus:ring-2 focus:ring-primary/20 focus:border-primary transition text-sm"
                                   placeholder="you@company.com"
                                   autocomplete="email">
                        </div>

                        <!-- Password -->
                        <div>
                            <div class="flex items-center justify-between mb-1.5">
                                <label for="password" class="block text-xs font-medium text-gray-600 uppercase tracking-wider">
                                    <i class="fas fa-lock text-primary mr-1"></i>
                                    Password
                                </label>
                                <a href="{{ route('forgot-password') }}" class="text-xs text-primary hover:text-primaryDark transition">
                                    Forgot?
                                </a>
                            </div>
                            <div class="relative">
                                <input type="password" 
                                       id="password" 
                                       name="password" 
                                       required
                                       class="w-full px-3 py-2.5 pr-10 rounded-lg border border-gray-300 focus:outline-none focus:ring-2 focus:ring-primary/20 focus:border-primary transition text-sm"
                                       placeholder="••••••••"
                                       autocomplete="current-password">
                                <button type="button" 
                                        id="togglePasswordBtn"
                                        class="absolute right-2 top-2.5 text-gray-400 hover:text-gray-600 focus:outline-none">
                                    <i class="fas fa-eye text-sm"></i>
                                </button>
                            </div>
                        </div>

                        <!-- Remember Me -->
                        <div class="flex items-center">
                            <input type="checkbox" 
                                   id="remember" 
                                   name="remember"
                                   value="1"
                                   {{ old('remember') ? 'checked' : '' }}
                                   class="h-4 w-4 text-primary rounded border-gray-300 focus:ring-primary/20">
                            <label for="remember" class="ml-2 text-xs text-gray-600">
                                Keep me signed in
                            </label>
                        </div>

                        <!-- Submit Button -->
                        <button type="submit"
                                id="submitButton"
                                class="w-full bg-gradient-to-r from-primary to-primaryDark text-white py-2.5 px-4 rounded-lg font-medium hover:shadow-lg hover:shadow-primary/20 transition-all duration-300 flex items-center justify-center space-x-2 disabled:opacity-50 disabled:cursor-not-allowed text-sm">
                            <i class="fas fa-sign-in-alt"></i>
                            <span>Sign In</span>
                        </button>
                    </div>
                </form>

                <!-- Sign Up Link -->
                <div class="mt-5 pt-4 border-t border-gray-100">
                    <p class="text-xs text-gray-500 text-center">
                        Need support access?
                        <a href="{{ route('sign-up') }}" class="text-primary font-medium hover:text-primaryDark transition">
                            Register here
                        </a>
                    </p>
                    <p class="text-[10px] text-gray-400 text-center mt-2 flex items-center justify-center gap-1">
                        <i class="fas fa-shield-alt"></i>
                        Free portal for Dataworld clients
                    </p>
                </div>
            </div>
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
            signinForm?.addEventListener('submit', function() {
                if (submitted) {
                    e.preventDefault();
                    return;
                }
                submitted = true;
            });
        });
    </script>

</body>
</html>