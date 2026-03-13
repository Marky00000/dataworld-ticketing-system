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
                        darkBlue: '#1e2b4f',
                        darkerBlue: '#152238',
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
            border-color: rgba(99, 102, 241, 0.3);
        }

        /* Primary color for focus states */
        input:focus {
            border-color: #6366f1 !important;
            box-shadow: 0 0 0 3px rgba(99, 102, 241, 0.1) !important;
        }

        /* Primary color for checkbox */
        input[type="checkbox"]:checked {
            background-color: #6366f1 !important;
            border-color: #6366f1 !important;
        }

        /* Primary color for links hover */
        a:hover {
            color: #4f46e5 !important;
        }
    </style>
</head>
<body class="min-h-screen flex">
    <!-- Left Column - Branding & Stats (Subtle Gradient) -->
    <div class="hidden lg:flex lg:w-1/2 gradient-bg p-12 flex-col justify-between relative overflow-hidden">
        <!-- Animated background elements -->
        <div class="absolute inset-0 opacity-20">
            <div class="absolute top-20 left-10 w-64 h-64 bg-white/10 rounded-full blur-3xl animate-float"></div>
            <div class="absolute bottom-20 right-10 w-80 h-80 bg-primary/20 rounded-full blur-3xl animate-float" style="animation-delay: 2s;"></div>
            <div class="absolute top-1/2 left-1/2 transform -translate-x-1/2 -translate-y-1/2 w-96 h-96 bg-purple-500/10 rounded-full blur-3xl"></div>
        </div>
        
        <!-- Logo -->
        <div class="relative z-10">
        </div>
        
        <!-- Center Content -->
        <div class="relative z-10 text-center max-w-md mx-auto">
            <h2 class="text-4xl font-bold text-white mb-4">Dataworld Ticketing System</h2>
            <p class="text-white/80 text-lg mb-12">Enterprise-grade network solutions, server maintenance, and round-the-clock technical support.</p>            
            
            <!-- Stats -->
            <div class="grid grid-cols-3 gap-6">
                <div class="stat-card rounded-2xl p-6 text-center transition-all duration-300">
                    <div class="w-14 h-14 bg-white/20 rounded-xl flex items-center justify-center mx-auto mb-3 backdrop-blur-sm">
                        <i class="fas fa-network-wired text-white text-2xl"></i>
                    </div>
                    <div class="text-white/90 text-sm font-medium">Network Support</div>
                    <div class="text-white/50 text-xs mt-1">24/7 Available</div>
                </div>
                <div class="stat-card rounded-2xl p-6 text-center transition-all duration-300">
                    <div class="w-14 h-14 bg-white/20 rounded-xl flex items-center justify-center mx-auto mb-3 backdrop-blur-sm">
                        <i class="fas fa-server text-white text-2xl"></i>
                    </div>
                    <div class="text-white/90 text-sm font-medium">Server Uptime</div>
                    <div class="text-white/50 text-xs mt-1">99.9% Guarantee</div>
                </div>
                <div class="stat-card rounded-2xl p-6 text-center transition-all duration-300">
                    <div class="w-14 h-14 bg-white/20 rounded-xl flex items-center justify-center mx-auto mb-3 backdrop-blur-sm">
                        <i class="fas fa-headset text-white text-2xl"></i>
                    </div>
                    <div class="text-white/90 text-sm font-medium">Tech Support</div>
                    <div class="text-white/50 text-xs mt-1">24/7 Assistance</div>
                </div>
            </div>

            <!-- Trust badges -->
            <div class="mt-12 flex items-center justify-center space-x-8 text-sm text-white/70">
                <span class="flex items-center">
                    <i class="fas fa-shield-alt mr-2 text-green-400"></i> 24/7 Support
                </span>
                <span class="flex items-center">
                    <i class="fas fa-lock mr-2 text-green-400"></i> Secure Portal
                </span>
                <span class="flex items-center">
                    <i class="fas fa-clock mr-2 text-green-400"></i> Fast Response
                </span>
            </div>
        </div>
        
        <!-- Footer -->
        <div class="relative z-10 text-white/40 text-sm flex justify-between items-center">
            <span>© {{ date('Y') }} Dataworld Computer Center</span>
            <span class="text-white/20">|</span>
            <span class="text-white/30">Client Portal v2.0</span>
        </div>
    </div>

    <!-- Right Column - Sign In Form -->
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
                <h1 class="text-3xl font-bold text-gray-900">Welcome back</h1>
                <p class="text-gray-500 mt-2">Sign in to your client portal</p>
            </div>

            <!-- Alert Messages -->
            @if(session('success'))
                <div class="mb-6 p-4 bg-green-50 text-green-700 rounded-xl border border-green-200 text-sm">
                    <div class="flex items-center">
                        <i class="fas fa-check-circle text-green-500 mr-3"></i>
                        <span>{{ session('success') }}</span>
                    </div>
                </div>
            @endif

            @if($errors->any())
                <div class="mb-6 p-4 bg-red-50 text-red-700 rounded-xl border border-red-200 text-sm">
                    <div class="flex items-center mb-2">
                        <i class="fas fa-exclamation-circle text-red-500 mr-3"></i>
                        <span class="font-medium">Unable to sign in</span>
                    </div>
                    <ul class="list-disc list-inside text-xs space-y-1 ml-8">
                        @foreach($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <!-- Sign In Form -->
            <form action="{{ route('sign-in.post') }}" method="POST" id="signinForm" class="space-y-6">
                @csrf
                
                <!-- Email -->
                <div>
                    <label for="email" class="block text-sm font-medium text-gray-700 mb-1.5">
                        Email address
                    </label>
                    <input type="email" 
                           id="email" 
                           name="email" 
                           value="{{ old('email') }}"
                           required
                           class="w-full px-4 py-3 rounded-xl border border-gray-300 focus:outline-none focus:ring-2 focus:ring-primary/20 focus:border-primary transition-all bg-white/50 backdrop-blur-sm"
                           placeholder="you@company.com">
                </div>

                <!-- Password -->
                <div>
                    <div class="flex items-center justify-between mb-1.5">
                        <label for="password" class="block text-sm font-medium text-gray-700">
                            Password
                        </label>
                        <a href="{{ route('forgot-password') }}" class="text-sm text-primary hover:text-primaryDark">
                            Forgot password?
                        </a>
                    </div>
                    <div class="relative">
                        <input type="password" 
                               id="password" 
                               name="password" 
                               required
                               class="w-full px-4 py-3 pr-12 rounded-xl border border-gray-300 focus:outline-none focus:ring-2 focus:ring-primary/20 focus:border-primary transition-all bg-white/50 backdrop-blur-sm"
                               placeholder="Enter your password">
                        <button type="button" 
                                id="togglePasswordBtn"
                                class="absolute right-3 top-3.5 text-gray-400 hover:text-primary transition-colors">
                            <i class="fas fa-eye"></i>
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
                           class="h-4 w-4 text-primary rounded border-gray-300 focus:ring-primary">
                    <label for="remember" class="ml-2 block text-sm text-gray-700">
                        Remember me for 30 days
                    </label>
                </div>

                <!-- Submit Button -->
                <button type="submit"
                        id="submitButton"
                        class="w-full bg-gradient-to-r from-primary to-primaryDark text-white py-3 px-4 rounded-xl font-medium hover:shadow-lg hover:shadow-primary/25 transition-all duration-300 flex items-center justify-center space-x-2 disabled:opacity-50">
                    <span>Sign in</span>
                </button>
            </form>

            <!-- Sign Up Link -->
            <p class="mt-8 text-center text-sm text-gray-600">
                Don't have an account?
                <a href="{{ route('sign-up') }}" class="font-medium text-primary hover:text-primaryDark ml-1">
                    Sign up
                </a>
            </p>

            <!-- Security note -->
            <p class="mt-6 text-center text-xs text-gray-400 flex items-center justify-center">
                <i class="fas fa-shield-alt text-primary mr-1"></i>
                Secure login · 256-bit encryption
            </p>
        </div>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            // Password toggle
            const togglePasswordBtn = document.getElementById('togglePasswordBtn');
            const passwordInput = document.getElementById('password');
            
            if (togglePasswordBtn && passwordInput) {
                togglePasswordBtn.addEventListener('click', function() {
                    const type = passwordInput.type === 'password' ? 'text' : 'password';
                    passwordInput.type = type;
                    this.innerHTML = type === 'password' ? '<i class="fas fa-eye"></i>' : '<i class="fas fa-eye-slash"></i>';
                });
            }
            
            // Form submission loading state
            const form = document.getElementById('signinForm');
            const submitBtn = document.getElementById('submitButton');
            
            if (form) {
                form.addEventListener('submit', function(e) {
                    if (!form.checkValidity()) {
                        e.preventDefault();
                        return;
                    }
                    
                    submitBtn.disabled = true;
                    submitBtn.innerHTML = `
                        <div class="loading-spinner mr-2"></div>
                        <span>Signing in...</span>
                    `;
                });
            }

            // Auto-focus email
            document.getElementById('email')?.focus();

            // Add primary color hover effect to stat cards
            const statCards = document.querySelectorAll('.stat-card');
            statCards.forEach(card => {
                card.addEventListener('mouseenter', function() {
                    this.style.borderColor = '#6366f1';
                });
                card.addEventListener('mouseleave', function() {
                    this.style.borderColor = 'rgba(255, 255, 255, 0.1)';
                });
            });
        });
    </script>
</body>
</html>