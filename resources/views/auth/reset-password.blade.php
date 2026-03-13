<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="icon" type="image/png" href="{{ asset('images/logo.png') }}">
    <title>Set New Password - Dataworld Support Portal</title>
    
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

        /* Password strength bars */
        .strength-bar {
            height: 6px;
            border-radius: 3px;
            transition: all 0.3s ease;
        }
        .strength-0 { background-color: #ef4444; }
        .strength-1 { background-color: #f59e0b; }
        .strength-2 { background-color: #f59e0b; }
        .strength-3 { background-color: #10b981; }
        .strength-4 { background-color: #10b981; }

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
            <h2 class="text-4xl font-bold text-white mb-4">Secure your account</h2>
            <p class="text-white/80 text-lg mb-12">Create a strong password to protect your support portal access.</p>            
            
            <!-- Stats -->
            <div class="grid grid-cols-3 gap-6">
                <div class="stat-card rounded-2xl p-6 text-center transition-all duration-300">
                    <div class="w-14 h-14 bg-white/20 rounded-xl flex items-center justify-center mx-auto mb-3 backdrop-blur-sm">
                        <i class="fas fa-shield-alt text-white text-2xl"></i>
                    </div>
                    <div class="text-white/90 text-sm font-medium">Secure</div>
                    <div class="text-white/50 text-xs mt-1">Encrypted</div>
                </div>
                <div class="stat-card rounded-2xl p-6 text-center transition-all duration-300">
                    <div class="w-14 h-14 bg-white/20 rounded-xl flex items-center justify-center mx-auto mb-3 backdrop-blur-sm">
                        <i class="fas fa-lock text-white text-2xl"></i>
                    </div>
                    <div class="text-white/90 text-sm font-medium">Protected</div>
                    <div class="text-white/50 text-xs mt-1">256-bit</div>
                </div>
                <div class="stat-card rounded-2xl p-6 text-center transition-all duration-300">
                    <div class="w-14 h-14 bg-white/20 rounded-xl flex items-center justify-center mx-auto mb-3 backdrop-blur-sm">
                        <i class="fas fa-clock text-white text-2xl"></i>
                    </div>
                    <div class="text-white/90 text-sm font-medium">24/7</div>
                    <div class="text-white/50 text-xs mt-1">Support</div>
                </div>
            </div>

            <!-- Security tips -->
            <div class="mt-12 text-left bg-white/5 rounded-2xl p-6 backdrop-blur-sm border border-white/10">
                <h3 class="text-white font-medium mb-3 flex items-center">
                    <i class="fas fa-lightbulb text-yellow-400 mr-2"></i>
                    Password Tips
                </h3>
                <ul class="space-y-2 text-sm text-white/70">
                    <li class="flex items-center gap-2">
                        <i class="fas fa-check-circle text-green-400 text-xs"></i>
                        <span>Use at least 8 characters</span>
                    </li>
                    <li class="flex items-center gap-2">
                        <i class="fas fa-check-circle text-green-400 text-xs"></i>
                        <span>Include uppercase & lowercase letters</span>
                    </li>
                    <li class="flex items-center gap-2">
                        <i class="fas fa-check-circle text-green-400 text-xs"></i>
                        <span>Add numbers for extra strength</span>
                    </li>
                    <li class="flex items-center gap-2">
                        <i class="fas fa-check-circle text-green-400 text-xs"></i>
                        <span>Avoid common words or patterns</span>
                    </li>
                </ul>
            </div>
        </div>
        
        <!-- Footer -->
        <div class="relative z-10 text-white/40 text-sm flex justify-between items-center">
            <span>© {{ date('Y') }} Dataworld Computer Center</span>
            <span class="text-white/20">|</span>
            <span class="text-white/30">Secure Portal</span>
        </div>
    </div>

    <!-- Right Column - Set New Password Form -->
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
                <h1 class="text-3xl font-bold text-gray-900">Set New Password</h1>
                <p class="text-gray-500 mt-2">Create a strong password for your account</p>
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
                <div class="mb-6 p-4 bg-red-50 text-red-700 rounded-xl border border-red-200 text-sm shake">
                    <div class="flex items-center mb-2">
                        <i class="fas fa-exclamation-circle text-red-500 mr-3"></i>
                        <span class="font-medium">Unable to reset password</span>
                    </div>
                    <ul class="list-disc list-inside text-xs space-y-1 ml-8">
                        @foreach($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <!-- Reset Form -->
            <form action="{{ route('password.update') }}" method="POST" id="resetPasswordForm" class="bg-white rounded-2xl shadow-xl p-8 border border-gray-100">
                @csrf
                
                <input type="hidden" name="token" value="{{ $token }}">
                
                <div class="space-y-5">
                    <!-- Email (readonly) -->
                    <div>
                        <label for="email" class="block text-sm font-medium text-gray-700 mb-1.5">
                            Email address
                        </label>
                        <div class="relative">
                            <input type="email" 
                                   id="email" 
                                   name="email" 
                                   value="{{ $email }}"
                                   required
                                   readonly
                                   class="w-full px-4 py-3 rounded-xl border border-gray-300 bg-gray-100 text-gray-600 cursor-not-allowed"
                                   placeholder="you@company.com">
                            <i class="fas fa-lock absolute right-4 top-3.5 text-gray-400"></i>
                        </div>
                    </div>

                    <!-- New Password -->
                    <div>
                        <label for="password" class="block text-sm font-medium text-gray-700 mb-1.5">
                            New Password
                        </label>
                        <div class="relative">
                            <input type="password" 
                                   id="password" 
                                   name="password" 
                                   required
                                   class="w-full px-4 py-3 pr-12 rounded-xl border border-gray-300 focus:outline-none focus:ring-2 focus:ring-primary/20 focus:border-primary transition-all"
                                   placeholder="Create a strong password">
                            <button type="button" 
                                    id="togglePasswordBtn"
                                    class="absolute right-3 top-3 text-gray-400 hover:text-primary transition-colors">
                                <i class="fas fa-eye"></i>
                            </button>
                        </div>
                        
                        <!-- Password Strength Meter -->
                        <div class="mt-3">
                            <div class="flex gap-1 h-1.5 mb-2">
                                <div id="strength-bar-1" class="strength-bar flex-1 bg-gray-200"></div>
                                <div id="strength-bar-2" class="strength-bar flex-1 bg-gray-200"></div>
                                <div id="strength-bar-3" class="strength-bar flex-1 bg-gray-200"></div>
                            </div>
                            <p id="password-strength-text" class="text-xs text-gray-500">Must be at least 8 characters</p>
                        </div>
                    </div>

                    <!-- Confirm Password -->
                    <div>
                        <label for="password_confirmation" class="block text-sm font-medium text-gray-700 mb-1.5">
                            Confirm Password
                        </label>
                        <div class="relative">
                            <input type="password" 
                                   id="password_confirmation" 
                                   name="password_confirmation" 
                                   required
                                   class="w-full px-4 py-3 pr-12 rounded-xl border border-gray-300 focus:outline-none focus:ring-2 focus:ring-primary/20 focus:border-primary transition-all"
                                   placeholder="Confirm your password">
                            <button type="button" 
                                    id="toggleConfirmPasswordBtn"
                                    class="absolute right-3 top-3 text-gray-400 hover:text-primary transition-colors">
                                <i class="fas fa-eye"></i>
                            </button>
                        </div>
                        <div id="passwordMatchContainer" class="mt-2 hidden">
                            <p class="text-xs text-red-600 flex items-center">
                                <i class="fas fa-times-circle mr-1"></i> Passwords don't match
                            </p>
                        </div>
                        <div id="passwordMatchSuccess" class="mt-2 hidden">
                            <p class="text-xs text-green-600 flex items-center">
                                <i class="fas fa-check-circle mr-1"></i> Passwords match
                            </p>
                        </div>
                    </div>

                    <!-- Password Requirements Summary -->
                    <div class="bg-gray-50 rounded-xl p-4 border border-gray-200">
                        <h4 class="text-xs font-medium text-gray-700 mb-2 flex items-center">
                            <i class="fas fa-shield-alt text-primary mr-1"></i>
                            Password requirements:
                        </h4>
                        <div class="grid grid-cols-2 gap-2 text-xs">
                            <div id="req-length" class="flex items-center text-gray-500">
                                <i class="fas fa-circle text-[6px] mr-1.5"></i>
                                <span>8+ characters</span>
                            </div>
                            <div id="req-uppercase" class="flex items-center text-gray-500">
                                <i class="fas fa-circle text-[6px] mr-1.5"></i>
                                <span>Uppercase letter</span>
                            </div>
                            <div id="req-lowercase" class="flex items-center text-gray-500">
                                <i class="fas fa-circle text-[6px] mr-1.5"></i>
                                <span>Lowercase letter</span>
                            </div>
                            <div id="req-number" class="flex items-center text-gray-500">
                                <i class="fas fa-circle text-[6px] mr-1.5"></i>
                                <span>At least one number</span>
                            </div>
                        </div>
                    </div>

                    <!-- Submit Button -->
                    <button type="submit"
                            id="submitButton"
                            class="w-full bg-primary hover:bg-primaryDark text-white py-3 px-4 rounded-xl font-medium hover:shadow-lg hover:shadow-primary/25 transition-all duration-300 flex items-center justify-center space-x-2 disabled:opacity-50 mt-6">
                        <i class="fas fa-key"></i>
                        <span>Reset Password</span>
                    </button>
                </div>
            </form>

            <!-- Back to Sign In Link -->
            <p class="mt-8 text-center text-sm text-gray-600">
                Remember your password?
                <a href="{{ route('sign-in') }}" class="font-medium text-primary hover:text-primaryDark ml-1">
                    Sign in
                </a>
            </p>

            <!-- Security note -->
            <p class="mt-6 text-center text-xs text-gray-400 flex items-center justify-center">
                <i class="fas fa-shield-alt text-primary mr-1"></i>
                Secure password reset · 256-bit encryption
            </p>
        </div>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            // Password visibility toggles
            const togglePasswordBtn = document.getElementById('togglePasswordBtn');
            const passwordInput = document.getElementById('password');
            
            if (togglePasswordBtn && passwordInput) {
                togglePasswordBtn.addEventListener('click', function() {
                    const type = passwordInput.type === 'password' ? 'text' : 'password';
                    passwordInput.type = type;
                    this.innerHTML = type === 'password' ? '<i class="fas fa-eye"></i>' : '<i class="fas fa-eye-slash"></i>';
                });
            }

            const toggleConfirmPasswordBtn = document.getElementById('toggleConfirmPasswordBtn');
            const confirmPasswordInput = document.getElementById('password_confirmation');
            
            if (toggleConfirmPasswordBtn && confirmPasswordInput) {
                toggleConfirmPasswordBtn.addEventListener('click', function() {
                    const type = confirmPasswordInput.type === 'password' ? 'text' : 'password';
                    confirmPasswordInput.type = type;
                    this.innerHTML = type === 'password' ? '<i class="fas fa-eye"></i>' : '<i class="fas fa-eye-slash"></i>';
                });
            }

            // Password strength checker
            const password = document.getElementById('password');
            const confirmPassword = document.getElementById('password_confirmation');
            const strengthBars = [
                document.getElementById('strength-bar-1'),
                document.getElementById('strength-bar-2'),
                document.getElementById('strength-bar-3')
            ];
            const strengthText = document.getElementById('password-strength-text');
            const passwordMatchContainer = document.getElementById('passwordMatchContainer');
            const passwordMatchSuccess = document.getElementById('passwordMatchSuccess');
            
            // Requirement elements
            const reqLength = document.getElementById('req-length');
            const reqUppercase = document.getElementById('req-uppercase');
            const reqLowercase = document.getElementById('req-lowercase');
            const reqNumber = document.getElementById('req-number');

            function checkPasswordStrength() {
                const val = password.value;
                
                // Check requirements
                const hasLength = val.length >= 8;
                const hasUppercase = /[A-Z]/.test(val);
                const hasLowercase = /[a-z]/.test(val);
                const hasNumber = /[0-9]/.test(val);
                
                // Update requirement indicators
                updateRequirement(reqLength, hasLength);
                updateRequirement(reqUppercase, hasUppercase);
                updateRequirement(reqLowercase, hasLowercase);
                updateRequirement(reqNumber, hasNumber);

                // Calculate strength (0-4)
                const requirements = [hasLength, hasUppercase, hasLowercase, hasNumber];
                const metCount = requirements.filter(Boolean).length;
                
                // Update strength bars
                strengthBars.forEach((bar, index) => {
                    bar.className = `strength-bar flex-1 ${index < metCount ? getStrengthClass(metCount) : 'bg-gray-200'}`;
                });

                // Update strength text
                if (val.length === 0) {
                    strengthText.textContent = 'Must be at least 8 characters';
                    strengthText.className = 'text-xs text-gray-500';
                } else {
                    const strengthLevels = ['Very Weak', 'Weak', 'Fair', 'Good', 'Strong'];
                    strengthText.textContent = `Password strength: ${strengthLevels[metCount]}`;
                    strengthText.className = `text-xs ${getStrengthTextClass(metCount)}`;
                }
            }

            function updateRequirement(element, met) {
                const icon = element.querySelector('i');
                const text = element.querySelector('span') || element.childNodes[1];
                
                if (met) {
                    element.className = 'flex items-center text-green-600 text-xs';
                    icon.className = 'fas fa-check-circle mr-1.5 text-xs';
                } else {
                    element.className = 'flex items-center text-gray-500 text-xs';
                    icon.className = 'fas fa-circle text-[6px] mr-1.5';
                }
            }

            function getStrengthClass(count) {
                switch(count) {
                    case 1: return 'bg-orange-500';
                    case 2: return 'bg-yellow-500';
                    case 3: return 'bg-green-500';
                    case 4: return 'bg-emerald-500';
                    default: return 'bg-red-500';
                }
            }

            function getStrengthTextClass(count) {
                switch(count) {
                    case 1: return 'text-orange-600';
                    case 2: return 'text-yellow-600';
                    case 3: return 'text-green-600';
                    case 4: return 'text-emerald-600';
                    default: return 'text-red-600';
                }
            }

            // Check password match
            function checkPasswordMatch() {
                if (confirmPassword.value) {
                    if (password.value === confirmPassword.value) {
                        passwordMatchContainer.classList.add('hidden');
                        passwordMatchSuccess.classList.remove('hidden');
                        return true;
                    } else {
                        passwordMatchContainer.classList.remove('hidden');
                        passwordMatchSuccess.classList.add('hidden');
                        return false;
                    }
                } else {
                    passwordMatchContainer.classList.add('hidden');
                    passwordMatchSuccess.classList.add('hidden');
                    return false;
                }
            }

            // Add event listeners
            if (password) {
                password.addEventListener('input', function() {
                    checkPasswordStrength();
                    checkPasswordMatch();
                });
            }

            if (confirmPassword) {
                confirmPassword.addEventListener('input', checkPasswordMatch);
            }

            // Form submission with validation
            const resetForm = document.getElementById('resetPasswordForm');
            const submitButton = document.getElementById('submitButton');
            
            if (resetForm) {
                resetForm.addEventListener('submit', function(e) {
                    if (password.value !== confirmPassword.value) {
                        e.preventDefault();
                        alert('Passwords do not match!');
                        return;
                    }
                    
                    // Show loading state
                    submitButton.disabled = true;
                    submitButton.innerHTML = `
                        <div class="loading-spinner mr-2"></div>
                        <span>Resetting password...</span>
                    `;
                });
            }

            // Auto-focus password field
            if (password) {
                password.focus();
            }
        });
    </script>

</body>
</html>