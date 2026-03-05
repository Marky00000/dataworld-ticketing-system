<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="icon" type="image/png" href="{{ asset('images/logo.png') }}">
    <title>Change Password - {{ $user->name }} - Dataworld Support</title>
    
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
        
        /* Password strength indicator */
        .strength-weak { background-color: #ef4444; }
        .strength-medium { background-color: #f59e0b; }
        .strength-strong { background-color: #10b981; }
        
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
        
        /* Password visibility toggle */
        .password-toggle {
            transition: all 0.2s ease;
        }
        .password-toggle:hover {
            color: #6366f1;
            transform: scale(1.1);
        }
        
        /* Match indicator animations */
        @keyframes fadeIn {
            from { opacity: 0; transform: translateY(-5px); }
            to { opacity: 1; transform: translateY(0); }
        }
        
        .fade-in {
            animation: fadeIn 0.3s ease-out;
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
                <a href="/dashboard" class="text-gray-500 hover:text-primary transition flex items-center gap-1.5 group">
                    <i class="fas fa-home text-xs group-hover:text-primary"></i>
                    <span>Dashboard</span>
                </a>
                <i class="fas fa-chevron-right mx-2 text-xs text-gray-400"></i>
                <a href="{{ route('profile.dashboard') }}" class="text-gray-500 hover:text-primary transition flex items-center gap-1.5">
                    <i class="fas fa-user text-xs"></i>
                    <span>Profile</span>
                </a>
                <i class="fas fa-chevron-right mx-2 text-xs text-gray-400"></i>
                <span class="text-primary font-medium bg-primary/5 px-2.5 py-1 rounded-full">Change Password</span>
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
                    <a href="/dashboard" class="relative inline-flex items-center space-x-2 hover-lift bg-white px-4 py-2 rounded-full shadow-sm">
                        <img src="{{ asset('images/dwcc.png') }}" 
                             alt="Dataworld Logo" 
                             class="h-8 w-auto">
                    </a>
                </div>
                <h1 class="text-3xl font-bold text-gray-800 mt-6">Change Password</h1>
                <p class="text-gray-500 text-sm mt-1">Update your password to keep your account secure</p>
            </div>

            <!-- Alert Messages -->
            @if(session('success'))
                <div class="mb-4 p-4 bg-green-50 text-green-700 rounded-xl border border-green-200 text-sm animate__animated animate__fadeInDown">
                    <div class="flex items-center space-x-2">
                        <div class="w-8 h-8 bg-green-100 rounded-full flex items-center justify-center">
                            <i class="fas fa-check-circle text-green-600"></i>
                        </div>
                        <div>
                            <span class="font-medium block">Success!</span>
                            <span class="text-xs">{{ session('success') }}</span>
                        </div>
                    </div>
                </div>
            @endif

            @if(session('error'))
                <div class="mb-4 p-4 bg-red-50 text-red-700 rounded-xl border border-red-200 text-sm">
                    <div class="flex items-center space-x-2">
                        <div class="w-8 h-8 bg-red-100 rounded-full flex items-center justify-center">
                            <i class="fas fa-exclamation-circle text-red-600"></i>
                        </div>
                        <div>
                            <span class="font-medium block">Error!</span>
                            <span class="text-xs">{{ session('error') }}</span>
                        </div>
                    </div>
                </div>
            @endif

            @if($errors->any())
                <div class="mb-4 p-4 bg-red-50 text-red-700 rounded-xl border border-red-200 text-sm shake" id="errorMessage">
                    <div class="flex items-center space-x-2 mb-2">
                        <div class="w-8 h-8 bg-red-100 rounded-full flex items-center justify-center">
                            <i class="fas fa-exclamation-circle text-red-600"></i>
                        </div>
                        <span class="font-medium">Unable to change password</span>
                    </div>
                    <ul class="list-disc list-inside text-xs space-y-1 ml-4">
                        @foreach($errors->all() as $error)
                            <li class="text-red-600">{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <!-- Security Info Banner -->
            <div class="mb-4 p-3 bg-blue-50 text-blue-700 rounded-xl border border-blue-200 text-xs flex items-start gap-2">
                <div class="w-6 h-6 bg-blue-100 rounded-full flex items-center justify-center flex-shrink-0 mt-0.5">
                    <i class="fas fa-shield-alt text-blue-600 text-xs"></i>
                </div>
                <div>
                    <span class="font-medium">Security Tip:</span> Use a unique password with at least 8 characters, including uppercase, lowercase, and numbers.
                </div>
            </div>

            <!-- Password Change Form Card -->
            <div class="bg-white rounded-2xl shadow-xl p-8 border border-gray-100 card-gradient-border relative">
                <!-- Decorative element -->
                <div class="absolute -top-3 left-1/2 -translate-x-1/2 w-20 h-1.5 bg-gradient-to-r from-primary to-primaryDark rounded-full"></div>
                
                <form action="{{ route('profile.password.update') }}" method="POST" id="changePasswordForm">
                    @csrf
                    @method('PUT')
                    
                    <div class="space-y-5">
                        <!-- Current Password -->
                        <div>
                            <label for="current_password" class="block text-xs font-semibold text-gray-700 uppercase tracking-wider mb-1.5 flex items-center">
                                <div class="w-5 h-5 bg-primary/10 rounded-full flex items-center justify-center mr-1.5">
                                    <i class="fas fa-lock text-primary text-[10px]"></i>
                                </div>
                                Current Password
                            </label>
                            <div class="relative">
                                <input type="password" 
                                       id="current_password" 
                                       name="current_password" 
                                       required
                                       class="w-full px-4 py-3 pr-12 rounded-xl border border-gray-200 focus:outline-none focus:ring-2 focus:ring-primary/20 focus:border-primary transition-all text-sm bg-gray-50/50 hover:bg-white focus:bg-white"
                                       placeholder="Enter current password"
                                       autocomplete="current-password">
                                <button type="button" 
                                        class="password-toggle absolute right-3 top-3 text-gray-400 hover:text-primary transition-colors focus:outline-none"
                                        onclick="togglePasswordVisibility('current_password', this)">
                                    <i class="fas fa-eye text-sm"></i>
                                </button>
                            </div>
                        </div>

                        <!-- New Password -->
                        <div>
                            <label for="new_password" class="block text-xs font-semibold text-gray-700 uppercase tracking-wider mb-1.5 flex items-center">
                                <div class="w-5 h-5 bg-primary/10 rounded-full flex items-center justify-center mr-1.5">
                                    <i class="fas fa-lock text-primary text-[10px]"></i>
                                </div>
                                New Password
                            </label>
                            <div class="relative">
                                <input type="password" 
                                       id="new_password" 
                                       name="new_password" 
                                       required
                                       class="w-full px-4 py-3 pr-12 rounded-xl border border-gray-200 focus:outline-none focus:ring-2 focus:ring-primary/20 focus:border-primary transition-all text-sm bg-gray-50/50 hover:bg-white focus:bg-white"
                                       placeholder="••••••••"
                                       autocomplete="new-password">
                                <button type="button" 
                                        class="password-toggle absolute right-3 top-3 text-gray-400 hover:text-primary transition-colors focus:outline-none"
                                        onclick="togglePasswordVisibility('new_password', this)">
                                    <i class="fas fa-eye text-sm"></i>
                                </button>
                            </div>
                            
                            <!-- Password Strength Meter -->
                            <div class="mt-3 space-y-2">
                                <div class="flex gap-1 h-1">
                                    <div id="strength-bar-1" class="flex-1 rounded-full bg-gray-200 transition-all"></div>
                                    <div id="strength-bar-2" class="flex-1 rounded-full bg-gray-200 transition-all"></div>
                                    <div id="strength-bar-3" class="flex-1 rounded-full bg-gray-200 transition-all"></div>
                                </div>
                                <div id="password-strength-text" class="text-xs text-gray-500 flex items-center gap-1">
                                    <i class="fas fa-info-circle text-gray-400"></i>
                                    <span>Enter a password to see strength</span>
                                </div>
                            </div>
                            
                            <!-- Password Requirements List -->
                            <div class="mt-3 bg-gray-50 rounded-lg p-3 text-xs space-y-1.5">
                                <p class="font-medium text-gray-700 mb-1.5 flex items-center gap-1">
                                    <i class="fas fa-list-check text-primary"></i>
                                    Password requirements:
                                </p>
                                <div class="grid grid-cols-2 gap-1.5">
                                    <div id="req-length" class="flex items-center gap-1.5 text-gray-500">
                                        <i class="fas fa-circle text-[6px]"></i>
                                        <span>8+ characters</span>
                                    </div>
                                    <div id="req-uppercase" class="flex items-center gap-1.5 text-gray-500">
                                        <i class="fas fa-circle text-[6px]"></i>
                                        <span>Uppercase</span>
                                    </div>
                                    <div id="req-lowercase" class="flex items-center gap-1.5 text-gray-500">
                                        <i class="fas fa-circle text-[6px]"></i>
                                        <span>Lowercase</span>
                                    </div>
                                    <div id="req-number" class="flex items-center gap-1.5 text-gray-500">
                                        <i class="fas fa-circle text-[6px]"></i>
                                        <span>Number</span>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Confirm New Password with Simple Match/No Match Indicator -->
                        <div>
                            <label for="new_password_confirmation" class="block text-xs font-semibold text-gray-700 uppercase tracking-wider mb-1.5 flex items-center">
                                <div class="w-5 h-5 bg-primary/10 rounded-full flex items-center justify-center mr-1.5">
                                    <i class="fas fa-lock text-primary text-[10px]"></i>
                                </div>
                                Confirm New Password
                            </label>
                            <div class="relative">
                                <input type="password" 
                                       id="new_password_confirmation" 
                                       name="new_password_confirmation" 
                                       required
                                       class="w-full px-4 py-3 pr-12 rounded-xl border border-gray-200 focus:outline-none focus:ring-2 focus:ring-primary/20 focus:border-primary transition-all text-sm bg-gray-50/50 hover:bg-white focus:bg-white"
                                       placeholder="••••••••"
                                       autocomplete="new-password">
                                <button type="button" 
                                        class="password-toggle absolute right-3 top-3 text-gray-400 hover:text-primary transition-colors focus:outline-none"
                                        onclick="togglePasswordVisibility('new_password_confirmation', this)">
                                    <i class="fas fa-eye text-sm"></i>
                                </button>
                            </div>
                            
                            <!-- Simple Password Match Indicator -->
                            <div id="password-match-container" class="mt-2 hidden fade-in">
                                <div id="password-match" class="flex items-center gap-2 text-xs">
                                    <!-- Dynamically filled by JavaScript -->
                                </div>
                            </div>
                        </div>

                        <!-- Submit Button -->
                        <button type="submit"
                                id="submitButton"
                                class="w-full bg-gradient-to-r from-primary to-primaryDark text-white py-3.5 px-4 rounded-xl font-medium hover:shadow-xl hover:shadow-primary/20 transition-all duration-300 flex items-center justify-center space-x-2 disabled:opacity-50 disabled:cursor-not-allowed text-sm group relative overflow-hidden mt-6">
                            <span class="absolute inset-0 bg-white/10 translate-y-full group-hover:translate-y-0 transition-transform"></span>
                            <i class="fas fa-key relative z-10 group-hover:rotate-12 transition-transform"></i>
                            <span class="relative z-10">Update Password</span>
                        </button>
                    </div>
                </form>

                <!-- Help Links -->
                <div class="mt-6 pt-4 border-t border-gray-100">
                    <div class="flex flex-col items-center space-y-2">
                        <a href="{{ route('profile.dashboard') }}" class="text-primary hover:text-primaryDark transition flex items-center space-x-2 group text-sm">
                            <i class="fas fa-arrow-left group-hover:-translate-x-1 transition-transform"></i>
                            <span>Back to Profile</span>
                        </a>
                    </div>
                </div>
            </div>
            
            <!-- Security Badges -->
            <div class="flex items-center justify-center gap-4 mt-6 text-[10px] text-gray-400">
                <span class="flex items-center gap-1">
                    <i class="fas fa-shield-alt text-primary"></i> 256-bit SSL
                </span>
                <span class="w-1 h-1 bg-gray-300 rounded-full"></span>
                <span class="flex items-center gap-1">
                    <i class="fas fa-lock text-primary"></i> Encrypted
                </span>
                <span class="w-1 h-1 bg-gray-300 rounded-full"></span>
                <span class="flex items-center gap-1">
                    <i class="fas fa-clock text-primary"></i> 24/7 Support
                </span>
            </div>
        </div>
    </div>

    <!-- JavaScript for interactivity -->
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            // Auto-focus current password field
            const currentPasswordField = document.getElementById('current_password');
            if (currentPasswordField) {
                currentPasswordField.focus();
            }

            // Get DOM elements
            const newPassword = document.getElementById('new_password');
            const confirmPassword = document.getElementById('new_password_confirmation');
            const strengthBars = [
                document.getElementById('strength-bar-1'),
                document.getElementById('strength-bar-2'),
                document.getElementById('strength-bar-3')
            ];
            const strengthText = document.getElementById('password-strength-text');
            
            // Requirement elements
            const reqLength = document.getElementById('req-length');
            const reqUppercase = document.getElementById('req-uppercase');
            const reqLowercase = document.getElementById('req-lowercase');
            const reqNumber = document.getElementById('req-number');
            
            // Match indicator elements
            const matchContainer = document.getElementById('password-match-container');
            const matchElement = document.getElementById('password-match');

            // Password strength checker
            function checkPasswordStrength() {
                const val = newPassword.value;
                if (!val) {
                    // Reset
                    strengthBars.forEach(bar => {
                        bar.className = 'flex-1 rounded-full bg-gray-200 transition-all';
                    });
                    strengthText.innerHTML = '<i class="fas fa-info-circle text-gray-400"></i> <span>Enter a password to see strength</span>';
                    
                    // Reset requirements
                    [reqLength, reqUppercase, reqLowercase, reqNumber].forEach(el => {
                        el.className = 'flex items-center gap-1.5 text-gray-500';
                        el.querySelector('i').className = 'fas fa-circle text-[6px]';
                    });
                    return;
                }

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

                // Calculate strength
                const requirements = [hasLength, hasUppercase, hasLowercase, hasNumber];
                const metCount = requirements.filter(Boolean).length;
                
                // Update strength bars
                strengthBars.forEach((bar, index) => {
                    bar.className = `flex-1 rounded-full transition-all ${
                        index < metCount ? getStrengthColor(metCount) : 'bg-gray-200'
                    }`;
                });

                // Update strength text
                const strengthLevels = ['Very Weak', 'Weak', 'Fair', 'Good', 'Strong'];
                strengthText.innerHTML = `<i class="fas fa-info-circle"></i> <span>Password strength: ${strengthLevels[metCount]}</span>`;
                strengthText.className = `text-xs flex items-center gap-1 ${getStrengthTextColor(metCount)}`;
            }

            function updateRequirement(element, met) {
                if (met) {
                    element.className = 'flex items-center gap-1.5 text-green-600';
                    element.querySelector('i').className = 'fas fa-check-circle text-xs';
                } else {
                    element.className = 'flex items-center gap-1.5 text-gray-500';
                    element.querySelector('i').className = 'fas fa-circle text-[6px]';
                }
            }

            function getStrengthColor(count) {
                switch(count) {
                    case 0: return 'bg-red-500';
                    case 1: return 'bg-orange-500';
                    case 2: return 'bg-yellow-500';
                    case 3: return 'bg-green-500';
                    case 4: return 'bg-emerald-500';
                    default: return 'bg-gray-200';
                }
            }

            function getStrengthTextColor(count) {
                switch(count) {
                    case 0: return 'text-red-600';
                    case 1: return 'text-orange-600';
                    case 2: return 'text-yellow-600';
                    case 3: return 'text-green-600';
                    case 4: return 'text-emerald-600';
                    default: return 'text-gray-500';
                }
            }

            // Simple password match checker (match or no match only)
            function checkPasswordMatch() {
                if (confirmPassword.value && newPassword.value) {
                    matchContainer.style.display = 'block';
                    
                    if (newPassword.value === confirmPassword.value) {
                        // Passwords match
                        matchElement.innerHTML = `
                            <div class="flex items-center gap-2 p-2 bg-green-50 rounded-lg border border-green-200">
                                <div class="w-5 h-5 bg-green-100 rounded-full flex items-center justify-center">
                                    <i class="fas fa-check-circle text-green-600 text-xs"></i>
                                </div>
                                <span class="text-green-700 font-medium">✓ Passwords match</span>
                            </div>
                        `;
                        
                        // Update input styling
                        confirmPassword.classList.remove('border-red-300', 'bg-red-50/30');
                        confirmPassword.classList.add('border-green-300', 'bg-green-50/30');
                        
                    } else {
                        // Passwords don't match
                        matchElement.innerHTML = `
                            <div class="flex items-center gap-2 p-2 bg-red-50 rounded-lg border border-red-200">
                                <div class="w-5 h-5 bg-red-100 rounded-full flex items-center justify-center">
                                    <i class="fas fa-exclamation-circle text-red-600 text-xs"></i>
                                </div>
                                <span class="text-red-700 font-medium">✗ Passwords do not match</span>
                            </div>
                        `;
                        
                        // Update input styling
                        confirmPassword.classList.remove('border-green-300', 'bg-green-50/30');
                        confirmPassword.classList.add('border-red-300', 'bg-red-50/30');
                    }
                } else if (confirmPassword.value) {
                    // Only confirm password has value
                    matchContainer.style.display = 'block';
                    matchElement.innerHTML = `
                        <div class="flex items-center gap-2 p-2 bg-yellow-50 rounded-lg border border-yellow-200">
                            <div class="w-5 h-5 bg-yellow-100 rounded-full flex items-center justify-center">
                                <i class="fas fa-hourglass-half text-yellow-600 text-xs"></i>
                            </div>
                            <span class="text-yellow-700 font-medium">⏳ Enter new password first</span>
                        </div>
                    `;
                    
                    // Update input styling
                    confirmPassword.classList.remove('border-green-300', 'border-red-300', 'bg-green-50/30', 'bg-red-50/30');
                    confirmPassword.classList.add('border-yellow-300', 'bg-yellow-50/30');
                    
                } else {
                    // No value in confirm password
                    matchContainer.style.display = 'none';
                    confirmPassword.classList.remove('border-green-300', 'border-red-300', 'border-yellow-300', 'bg-green-50/30', 'bg-red-50/30', 'bg-yellow-50/30');
                    confirmPassword.classList.add('border-gray-200', 'bg-gray-50/50');
                }
            }

            // Add real-time input listeners
            if (newPassword && confirmPassword) {
                ['input', 'keyup', 'change', 'paste'].forEach(eventType => {
                    newPassword.addEventListener(eventType, function() {
                        checkPasswordStrength();
                        checkPasswordMatch();
                    });
                    
                    confirmPassword.addEventListener(eventType, function() {
                        checkPasswordMatch();
                    });
                });

                // Also check on blur
                newPassword.addEventListener('blur', checkPasswordMatch);
                confirmPassword.addEventListener('blur', checkPasswordMatch);
            }

            // Check when password visibility is toggled
            function togglePasswordVisibility(inputId, button) {
                const input = document.getElementById(inputId);
                const icon = button.querySelector('i');
                
                if (input.type === 'password') {
                    input.type = 'text';
                    icon.className = 'fas fa-eye-slash text-sm';
                } else {
                    input.type = 'password';
                    icon.className = 'fas fa-eye text-sm';
                }
                
                // Re-check match after toggle
                setTimeout(checkPasswordMatch, 50);
            }

            // Make toggle function globally available
            window.togglePasswordVisibility = togglePasswordVisibility;

            // Form submission with loading state and validation
            const changeForm = document.getElementById('changePasswordForm');
            const submitButton = document.getElementById('submitButton');
            
            if (changeForm) {
                changeForm.addEventListener('submit', function(e) {
                    // Check if passwords match
                    if (newPassword.value !== confirmPassword.value) {
                        e.preventDefault();
                        
                        // Show custom alert
                        const errorDiv = document.createElement('div');
                        errorDiv.className = 'mb-4 p-4 bg-red-50 text-red-700 rounded-xl border border-red-200 text-sm shake';
                        errorDiv.innerHTML = `
                            <div class="flex items-center space-x-2">
                                <div class="w-8 h-8 bg-red-100 rounded-full flex items-center justify-center">
                                    <i class="fas fa-exclamation-circle text-red-600"></i>
                                </div>
                                <div>
                                    <span class="font-medium block">Error!</span>
                                    <span class="text-xs">New passwords do not match!</span>
                                </div>
                            </div>
                        `;
                        
                        // Insert at top of form
                        const formCard = document.querySelector('.bg-white.rounded-2xl');
                        formCard.insertBefore(errorDiv, formCard.firstChild);
                        
                        // Scroll to error
                        errorDiv.scrollIntoView({ behavior: 'smooth', block: 'center' });
                        
                        // Remove after 5 seconds
                        setTimeout(() => {
                            errorDiv.remove();
                        }, 5000);
                        
                        return;
                    }
                    
                    if (!changeForm.checkValidity()) {
                        e.preventDefault();
                        return;
                    }
                    
                    // Show loading state
                    submitButton.disabled = true;
                    submitButton.innerHTML = `
                        <div class="loading-spinner mr-2"></div>
                        <span>Updating password...</span>
                    `;
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

            // Initial check if there are values
            if (newPassword && confirmPassword) {
                if (newPassword.value || confirmPassword.value) {
                    checkPasswordMatch();
                }
            }
        });
    </script>
</body>
</html>