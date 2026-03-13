<!DOCTYPE html>
<html lang="en">
<head>
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Create Account - Dataworld Support Portal</title>
    <link rel="icon" type="image/png" href="{{ asset('images/logo.png') }}">

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
                        darkBlue: '#1e2b4f', // Flat dark blue for right column
                        darkerBlue: '#152238', // Even darker for accents
                    }
                }
            }
        }
    </script>
    
    <style>
        .password-strength {
            height: 4px;
            border-radius: 2px;
            transition: all 0.3s ease;
        }
        
        .strength-0 { width: 0%; background-color: #ef4444; }
        .strength-1 { width: 25%; background-color: #f59e0b; }
        .strength-2 { width: 50%; background-color: #f59e0b; }
        .strength-3 { width: 75%; background-color: #10b981; }
        .strength-4 { width: 100%; background-color: #10b981; }
        
        /* Modal Styles */
        .modal-overlay {
            position: fixed;
            inset: 0;
            background: rgba(0, 0, 0, 0.5);
            backdrop-filter: blur(4px);
            -webkit-backdrop-filter: blur(4px);
            z-index: 1000;
            display: none;
            opacity: 0;
            transition: opacity 0.3s ease;
            align-items: center;
            justify-content: center;
            padding: 1rem;
        }
        
        .modal-overlay.active {
            display: flex;
            opacity: 1;
        }
        
        .modal-container {
            background: white;
            border-radius: 1rem;
            box-shadow: 0 20px 60px rgba(0, 0, 0, 0.3);
            max-width: 800px;
            width: 100%;
            max-height: 85vh;
            overflow: hidden;
            transform: translateY(20px) scale(0.95);
            transition: transform 0.3s ease;
        }
        
        .modal-overlay.active .modal-container {
            transform: translateY(0) scale(1);
        }
        
        .modal-header {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            color: white;
            padding: 1.5rem 2rem;
            position: sticky;
            top: 0;
            z-index: 10;
        }
        
        .modal-body {
            padding: 2rem;
            overflow-y: auto;
            max-height: calc(85vh - 80px);
        }
        
        /* Loading spinner */
        .loading-spinner {
            width: 1.25rem;
            height: 1.25rem;
            border: 2px solid rgba(255,255,255,0.3);
            border-top-color: white;
            border-radius: 50%;
            animation: spin 0.75s linear infinite;
        }
        
        @keyframes spin {
            to { transform: rotate(360deg); }
        }
        
        /* Custom scrollbar */
        .modal-body::-webkit-scrollbar {
            width: 6px;
        }
        .modal-body::-webkit-scrollbar-track {
            background: #f1f5f9;
            border-radius: 3px;
        }
        .modal-body::-webkit-scrollbar-thumb {
            background: #cbd5e1;
            border-radius: 3px;
        }
        .modal-body::-webkit-scrollbar-thumb:hover {
            background: #94a3b8;
        }
        
        .terms-section {
            margin-bottom: 2rem;
        }
        
        .terms-section:last-child {
            margin-bottom: 0;
        }
        
        .terms-section h3 {
            color: #1e293b;
            font-weight: 600;
            margin-bottom: 0.75rem;
            font-size: 1.125rem;
        }
        
        .terms-section p {
            color: #475569;
            line-height: 1.6;
            margin-bottom: 0.75rem;
        }
        
        .terms-section ul {
            list-style-type: disc;
            padding-left: 1.5rem;
            color: #475569;
            margin-bottom: 0.75rem;
        }
        
        .terms-section li {
            margin-bottom: 0.5rem;
            line-height: 1.5;
        }

        /* Social button hover (kept for potential future use) */
        .social-btn {
            transition: all 0.2s ease;
        }
        .social-btn:hover {
            background: #f8fafc;
            border-color: #6366f1;
            color: #6366f1;
        }

        /* Feature check icon */
        .feature-check {
            color: #4ade80;
        }
    </style>
</head>
<body class="min-h-screen flex">
    <!-- Left Column - Sign Up Form -->
    <div class="w-full lg:w-1/2 flex items-center justify-center p-8 bg-white overflow-y-auto" style="max-height: 100vh;">
        <div class="w-full max-w-md py-8">
            
            <!-- Logo & Header -->
            <div class="mb-8">
                <h1 class="text-2xl font-bold text-gray-900">Create your account</h1>
                <p class="text-gray-500 text-sm mt-1">Get started with our free support portal</p>
            </div>

            <!-- Error Messages -->
            @if($errors->has('database'))
                <div class="mb-6 p-4 bg-red-50 text-red-700 rounded-xl border border-red-200">
                    <p class="text-sm">{{ $errors->first('database') }}</p>
                </div>
            @endif

            @if($errors->any() && !$errors->has('database'))
                <div class="mb-6 p-4 bg-red-50 text-red-700 rounded-xl border border-red-200">
                    <ul class="list-disc list-inside text-sm">
                        @foreach($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            @if(session('error'))
                <div class="mb-6 p-4 bg-red-50 text-red-700 rounded-xl border border-red-200">
                    <p class="text-sm">{{ session('error') }}</p>
                </div>
            @endif

            <!-- Sign Up Form -->
            <form action="{{ route('sign-up.post') }}" method="POST" id="signupForm">
                @csrf
                
                <div class="space-y-5">
                    <!-- Full Name -->
                    <div>
                        <label for="name" class="block text-sm font-medium text-gray-700 mb-1">
                            Full name
                        </label>
                        <input type="text" 
                               id="name" 
                               name="name" 
                               value="{{ old('name') }}"
                               required
                               class="w-full px-4 py-3 rounded-lg border border-gray-300 focus:outline-none focus:ring-2 focus:ring-primary/20 focus:border-primary transition-all text-sm"
                               placeholder="John Doe">
                    </div>

                    <!-- Company -->
                    <div>
                        <label for="company" class="block text-sm font-medium text-gray-700 mb-1">
                            Company
                        </label>
                        <input type="text" 
                               id="company" 
                               name="company" 
                               value="{{ old('company') }}"
                               required
                               class="w-full px-4 py-3 rounded-lg border border-gray-300 focus:outline-none focus:ring-2 focus:ring-primary/20 focus:border-primary transition-all text-sm"
                               placeholder="Acme Inc.">
                    </div>

                    <!-- Work Email -->
                    <div>
                        <label for="email" class="block text-sm font-medium text-gray-700 mb-1">
                            Work email
                        </label>
                        <input type="email" 
                               id="email" 
                               name="email" 
                               value="{{ old('email') }}"
                               required
                               class="w-full px-4 py-3 rounded-lg border border-gray-300 focus:outline-none focus:ring-2 focus:ring-primary/20 focus:border-primary transition-all text-sm"
                               placeholder="you@company.com">
                    </div>

                    <!-- Phone Number (New) -->
                    <div>
                        <label for="phone" class="block text-sm font-medium text-gray-700 mb-1">
                            Phone number
                        </label>
                        <input type="tel" 
                               id="phone" 
                               name="phone" 
                               value="{{ old('phone') }}"
                               required
                               class="w-full px-4 py-3 rounded-lg border border-gray-300 focus:outline-none focus:ring-2 focus:ring-primary/20 focus:border-primary transition-all text-sm"
                               placeholder="+63 912 345 6789">
                        <p class="text-xs text-gray-500 mt-1">For support notifications</p>
                    </div>

                    <!-- Password -->
                    <div>
                        <label for="password" class="block text-sm font-medium text-gray-700 mb-1">
                            Password
                        </label>
                        <div class="relative">
                            <input type="password" 
                                   id="password" 
                                   name="password" 
                                   required
                                   class="w-full px-4 py-3 pr-12 rounded-lg border border-gray-300 focus:outline-none focus:ring-2 focus:ring-primary/20 focus:border-primary transition-all text-sm"
                                   placeholder="Create a strong password">
                            <button type="button" 
                                    id="togglePasswordBtn"
                                    class="absolute right-3 top-3 text-gray-400 hover:text-primary transition-colors">
                                <i class="fas fa-eye"></i>
                            </button>
                        </div>
                        
                        <!-- Password Strength Meter -->
                        <div class="mt-2">
                            <div id="passwordStrengthBar" class="password-strength strength-0"></div>
                            <p class="text-xs text-gray-500 mt-2">Must be at least 8 characters</p>
                        </div>
                    </div>

                    <!-- Confirm Password -->
                    <div>
                        <div class="relative">
                            <input type="password" 
                                   id="password_confirmation" 
                                   name="password_confirmation" 
                                   required
                                   class="w-full px-4 py-3 pr-12 rounded-lg border border-gray-300 focus:outline-none focus:ring-2 focus:ring-primary/20 focus:border-primary transition-all text-sm"
                                   placeholder="Confirm password">
                            <button type="button" 
                                    id="toggleConfirmPasswordBtn"
                                    class="absolute right-3 top-3 text-gray-400 hover:text-primary transition-colors">
                                <i class="fas fa-eye"></i>
                            </button>
                        </div>
                        <div id="passwordMatchContainer" class="mt-2 hidden">
                            <p class="text-xs text-red-600">Passwords don't match</p>
                        </div>
                        <div id="passwordMatchSuccess" class="mt-2 hidden">
                            <p class="text-xs text-green-600">Passwords match</p>
                        </div>
                    </div>

                    <!-- Terms and Conditions -->
                    <div class="flex items-start">
                        <input type="checkbox" 
                               id="terms" 
                               name="terms"
                               required
                               class="h-4 w-4 text-primary rounded border-gray-300 focus:ring-primary/20 mt-0.5">
                        <label for="terms" class="ml-3 text-sm text-gray-600">
                            I agree to the 
                            <button type="button" 
                                    id="openTermsModal"
                                    class="text-primary font-medium hover:text-primaryDark transition hover:underline">
                                Terms of Service
                            </button> 
                            and 
                            <button type="button" 
                                    id="openPrivacyModal"
                                    class="text-primary font-medium hover:text-primaryDark transition hover:underline">
                                Privacy Policy
                            </button>
                        </label>
                    </div>

                    <!-- Submit Button -->
                    <button type="submit"
                            id="submitButton"
                            class="w-full bg-primary hover:bg-primaryDark text-white py-3 px-4 rounded-lg font-medium transition-all duration-300 flex items-center justify-center space-x-2 disabled:opacity-50 disabled:cursor-not-allowed text-base">
                        <span>Create account</span>
                    </button>

                    <!-- Sign In Link -->
                    <p class="text-center text-sm text-gray-600">
                        Already have an account?
                        <a href="{{ route('sign-in') }}" class="font-medium text-primary hover:text-primaryDark">
                            Sign in
                        </a>
                    </p>
                </div>
            </form>
        </div>
    </div>

    <!-- Right Column - Free Trial Features (Flat dark blue background) -->
    <div class="hidden lg:flex lg:w-1/2 bg-darkBlue p-12 flex-col justify-center">
       <div class="max-w-md mx-auto text-white">
    <h2 class="text-2xl font-bold text-white mb-3">Dataworld Ticketing System</h2>
    <p class="text-gray-300 mb-8">Exclusive access for Dataworld clients. Submit and track support tickets with ease.</p>
    
    <div class="space-y-4">
        <div class="flex items-start">
            <div class="flex-shrink-0">
                <i class="fas fa-check-circle text-green-400 text-xl"></i>
            </div>
            <p class="ml-3 text-gray-200">Unlimited support tickets</p>
        </div>
        <div class="flex items-start">
            <div class="flex-shrink-0">
                <i class="fas fa-check-circle text-green-400 text-xl"></i>
            </div>
            <p class="ml-3 text-gray-200">24/7 ticket submission</p>
        </div>
        <div class="flex items-start">
            <div class="flex-shrink-0">
                <i class="fas fa-check-circle text-green-400 text-xl"></i>
            </div>
            <p class="ml-3 text-gray-200">Real-time status updates</p>
        </div>
        <div class="flex items-start">
            <div class="flex-shrink-0">
                <i class="fas fa-check-circle text-green-400 text-xl"></i>
            </div>
            <p class="ml-3 text-gray-200">Direct access to support team</p>
        </div>
    </div>

    <!-- Trust badge with client avatars -->
    <div class="mt-12 pt-8 border-t border-gray-600">
        <div class="flex items-center space-x-4">
            <div class="flex -space-x-2">
                <div class="w-8 h-8 bg-blue-300 rounded-full border-2 border-darkBlue flex items-center justify-center text-xs font-bold text-darkBlue">AC</div>
                <div class="w-8 h-8 bg-blue-400 rounded-full border-2 border-darkBlue flex items-center justify-center text-xs font-bold text-darkBlue">MJ</div>
                <div class="w-8 h-8 bg-blue-500 rounded-full border-2 border-darkBlue flex items-center justify-center text-xs font-bold text-white">RT</div>
            </div>
            <p class="text-sm text-gray-300">Trusted by <span class="font-semibold text-white">Partner</span> companies</p>
        </div>
    </div>

    <!-- Additional trust indicators -->
    <div class="mt-8 flex items-center space-x-6 text-sm text-gray-400">
        <span class="flex items-center">
            <i class="fas fa-clock mr-2 text-green-400"></i> 24/7 Availability
        </span>
        <span class="flex items-center">
            <i class="fas fa-headset mr-2 text-green-400"></i> Free Support
        </span>
    </div>
</div>
    </div>

    <!-- Terms of Service Modal (keep same) -->
    <div id="termsModal" class="modal-overlay" aria-hidden="true">
        <div class="modal-container">
            <div class="modal-header">
                <div class="flex items-center justify-between">
                    <div class="flex items-center space-x-3">
                        <div class="w-10 h-10 bg-white/20 rounded-lg flex items-center justify-center">
                            <i class="fas fa-file-contract text-white"></i>
                        </div>
                        <div>
                            <h2 class="text-xl font-bold">Terms of Service</h2>
                            <p class="text-white/80 text-sm">Client Support Portal Agreement</p>
                        </div>
                    </div>
                    <button id="closeTermsModal" class="text-white hover:text-white/80 transition" aria-label="Close modal">
                        <i class="fas fa-times text-xl"></i>
                    </button>
                </div>
            </div>
            <div class="modal-body">
                <!-- Terms content remains the same -->
                <div class="terms-section">
                    <h3>1. Acceptance of Terms</h3>
                    <p>By accessing and using Dataworld Client Support Portal ("Service"), you accept and agree to be bound by the terms and provision of this agreement.</p>
                </div>
                
                <div class="terms-section">
                    <h3>2. Description of Service</h3>
                    <p>Dataworld Client Support Portal provides technical support ticketing system for our clients including but not limited to:</p>
                    <ul>
                        <li>Technical issue reporting and tracking</li>
                        <li>Support ticket management</li>
                        <li>Communication with support team</li>
                        <li>Service request submissions</li>
                        <li>Support documentation access</li>
                    </ul>
                </div>
                
                <div class="terms-section">
                    <h3>3. User Accounts</h3>
                    <p>When you create an account with us, you must provide accurate, complete, and current information. You are responsible for:</p>
                    <ul>
                        <li>Maintaining the confidentiality of your account</li>
                        <li>All activities under your account</li>
                        <li>Notifying us immediately of any unauthorized use</li>
                        <li>Ensuring you exit from your account at the end of each session</li>
                    </ul>
                </div>
                
                <div class="terms-section">
                    <h3>4. Service Purpose</h3>
                    <p>This portal is provided free of charge to Dataworld clients for submitting technical support requests related to our products and services including servers, network devices, CCTV systems, access points, and other Dataworld products.</p>
                </div>
                
                <div class="terms-section">
                    <h3>5. Data Protection</h3>
                    <p>We implement industry-standard security measures to protect your data. However, no method of transmission over the Internet is 100% secure.</p>
                </div>
                
                <div class="terms-section">
                    <h3>6. Service Availability</h3>
                    <p>We strive to maintain 99.9% uptime but do not guarantee uninterrupted service. We may perform maintenance that could temporarily interrupt the Service.</p>
                </div>
                
                <div class="terms-section">
                    <h3>7. Termination</h3>
                    <p>We may terminate or suspend access to our Service immediately, without prior notice, for conduct that we believe violates these Terms.</p>
                </div>
                
                <div class="terms-section">
                    <h3>8. Changes to Terms</h3>
                    <p>We reserve the right to modify these terms at any time. We will notify users of any material changes via email or through the Service.</p>
                </div>
                
                <div class="mt-8 p-4 bg-blue-50 rounded-lg border border-blue-100">
                    <p class="text-sm text-blue-800">
                        <i class="fas fa-info-circle mr-2"></i>
                        For questions about these Terms of Service, please contact our support team at 
                        <a href="mailto:support@dataworld.com" class="font-medium hover:underline">support@dataworld.com</a>
                    </p>
                </div>
            </div>
        </div>
    </div>

    <!-- Privacy Policy Modal (keep same) -->
    <div id="privacyModal" class="modal-overlay" aria-hidden="true">
        <div class="modal-container">
            <div class="modal-header">
                <div class="flex items-center justify-between">
                    <div class="flex items-center space-x-3">
                        <div class="w-10 h-10 bg-white/20 rounded-lg flex items-center justify-center">
                            <i class="fas fa-shield-alt text-white"></i>
                        </div>
                        <div>
                            <h2 class="text-xl font-bold">Privacy Policy</h2>
                            <p class="text-white/80 text-sm">Data Protection for Client Support</p>
                        </div>
                    </div>
                    <button id="closePrivacyModal" class="text-white hover:text-white/80 transition" aria-label="Close modal">
                        <i class="fas fa-times text-xl"></i>
                    </button>
                </div>
            </div>
            <div class="modal-body">
                <!-- Privacy content remains the same -->
                <div class="terms-section">
                    <h3>1. Information We Collect</h3>
                    <p>We collect information that you provide directly to us, including:</p>
                    <ul>
                        <li><strong>Account Information:</strong> Name, email address, phone number, company details</li>
                        <li><strong>Support Data:</strong> Technical issues, error reports, system information</li>
                        <li><strong>Technical Data:</strong> IP address, browser type, device information</li>
                        <li><strong>Communication History:</strong> Ticket conversations, resolutions</li>
                    </ul>
                </div>
                
                <div class="terms-section">
                    <h3>2. How We Use Your Information</h3>
                    <p>We use the information we collect to:</p>
                    <ul>
                        <li>Provide technical support for our products</li>
                        <li>Respond to your support requests and questions</li>
                        <li>Send technical notices, updates, security alerts</li>
                        <li>Improve our products and services</li>
                        <li>Monitor and analyze support trends</li>
                        <li>Detect, prevent, and address technical issues</li>
                    </ul>
                </div>
                
                <div class="terms-section">
                    <h3>3. Data Security</h3>
                    <p>We implement appropriate technical and organizational measures to protect your personal information, including:</p>
                    <ul>
                        <li>256-bit SSL encryption for data in transit</li>
                        <li>AES-256 encryption for data at rest</li>
                        <li>Regular security audits and penetration testing</li>
                        <li>Role-based access controls</li>
                        <li>Multi-factor authentication options</li>
                    </ul>
                </div>
                
                <div class="terms-section">
                    <h3>4. Data Retention</h3>
                    <p>We retain your personal information for as long as your account is active or as needed to provide you services. We may retain certain information as required by law or for legitimate business purposes.</p>
                </div>
                
                <div class="terms-section">
                    <h3>5. Third-Party Services</h3>
                    <p>We may use third-party service providers to help us operate our business and the Service, such as:</p>
                    <ul>
                        <li>Cloud hosting providers (AWS, Google Cloud)</li>
                        <li>Email service providers</li>
                        <li>Analytics services</li>
                    </ul>
                </div>
                
                <div class="terms-section">
                    <h3>6. Your Rights</h3>
                    <p>Depending on your location, you may have the right to:</p>
                    <ul>
                        <li>Access your personal information</li>
                        <li>Correct inaccurate data</li>
                        <li>Request deletion of your data</li>
                        <li>Object to or restrict processing</li>
                        <li>Data portability</li>
                    </ul>
                    <p class="mt-2">To exercise these rights, contact us at privacy@dataworld.com</p>
                </div>
                
                <div class="terms-section">
                    <h3>7. Cookies and Tracking</h3>
                    <p>We use cookies and similar tracking technologies to track activity on our Service and hold certain information. You can instruct your browser to refuse all cookies or to indicate when a cookie is being sent.</p>
                </div>
                
                <div class="terms-section">
                    <h3>8. International Data Transfers</h3>
                    <p>Your information may be transferred to — and maintained on — computers located outside of your state, province, country, or other governmental jurisdiction where the data protection laws may differ.</p>
                </div>
                
                <div class="mt-8 p-4 bg-green-50 rounded-lg border border-green-100">
                    <p class="text-sm text-green-800">
                        <i class="fas fa-lock mr-2"></i>
                        For privacy-related inquiries, please contact our Data Protection Officer at 
                        <a href="mailto:dpo@dataworld.com" class="font-medium hover:underline">dpo@dataworld.com</a>
                    </p>
                </div>
            </div>
        </div>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            // Cache DOM elements
            const elements = {
                passwordInput: document.getElementById('password'),
                confirmPasswordInput: document.getElementById('password_confirmation'),
                togglePasswordBtn: document.getElementById('togglePasswordBtn'),
                toggleConfirmPasswordBtn: document.getElementById('toggleConfirmPasswordBtn'),
                passwordStrengthBar: document.getElementById('passwordStrengthBar'),
                passwordMatchContainer: document.getElementById('passwordMatchContainer'),
                passwordMatchSuccess: document.getElementById('passwordMatchSuccess'),
                submitButton: document.getElementById('submitButton'),
                termsCheckbox: document.getElementById('terms'),
                
                // Modal elements
                termsModal: document.getElementById('termsModal'),
                privacyModal: document.getElementById('privacyModal'),
                openTermsModalBtn: document.getElementById('openTermsModal'),
                openPrivacyModalBtn: document.getElementById('openPrivacyModal'),
                closeTermsModalBtn: document.getElementById('closeTermsModal'),
                closePrivacyModalBtn: document.getElementById('closePrivacyModal')
            };

            // Password strength configuration
            const strengthClasses = ['strength-0', 'strength-1', 'strength-2', 'strength-3', 'strength-4'];
            
            // Initialize
            function init() {
                setupPasswordToggles();
                setupPasswordValidation();
                setupModals();
                autoFocusName();
            }

            // Setup password toggle
            function setupPasswordToggles() {
                setupToggle(elements.togglePasswordBtn, elements.passwordInput);
                setupToggle(elements.toggleConfirmPasswordBtn, elements.confirmPasswordInput);
            }

            function setupToggle(toggleBtn, inputField) {
                toggleBtn.addEventListener('click', function() {
                    const type = inputField.type === 'password' ? 'text' : 'password';
                    inputField.type = type;
                    const icon = this.querySelector('i');
                    icon.className = type === 'password' ? 'fas fa-eye' : 'fas fa-eye-slash';
                });
            }

            // Setup password validation
            function setupPasswordValidation() {
                elements.passwordInput.addEventListener('input', handlePasswordInput);
                elements.confirmPasswordInput.addEventListener('input', checkPasswordMatch);
                elements.termsCheckbox.addEventListener('change', validateForm);
                document.getElementById('name').addEventListener('input', validateForm);
                document.getElementById('email').addEventListener('input', validateForm);
                document.getElementById('company').addEventListener('input', validateForm);
                document.getElementById('phone').addEventListener('input', validateForm);
                
                // Initialize button state
                elements.submitButton.disabled = true;
            }

            // Handle password input
            function handlePasswordInput() {
                const password = elements.passwordInput.value;
                const strength = checkPasswordStrength(password);
                
                updateStrengthDisplay(strength);
                checkPasswordMatch();
                validateForm();
            }

            // Check password strength
            function checkPasswordStrength(password) {
                if (!password) return 0;
                
                let strength = 0;
                if (password.length >= 8) strength++;
                if (/[A-Z]/.test(password)) strength++;
                if (/[a-z]/.test(password)) strength++;
                if (/[0-9]/.test(password)) strength++;
                
                return Math.min(strength, 4);
            }
            
            // Update strength display
            function updateStrengthDisplay(strength) {
                elements.passwordStrengthBar.className = `password-strength ${strengthClasses[strength]}`;
            }

            // Check if passwords match
            function checkPasswordMatch() {
                const password = elements.passwordInput.value;
                const confirmPassword = elements.confirmPasswordInput.value;
                
                elements.passwordMatchContainer.classList.add('hidden');
                elements.passwordMatchSuccess.classList.add('hidden');
                
                if (password && confirmPassword) {
                    if (password === confirmPassword) {
                        elements.passwordMatchSuccess.classList.remove('hidden');
                        return true;
                    } else {
                        elements.passwordMatchContainer.classList.remove('hidden');
                        return false;
                    }
                }
                return false;
            }

            // Check if form is valid
            function validateForm() {
                const password = elements.passwordInput.value;
                const strength = checkPasswordStrength(password);
                const passwordsMatch = checkPasswordMatch();
                const termsAccepted = elements.termsCheckbox.checked;
                const nameValid = document.getElementById('name').value.trim().length > 0;
                const emailValid = document.getElementById('email').value.trim().length > 0 && 
                                   document.getElementById('email').value.includes('@');
                const companyValid = document.getElementById('company').value.trim().length > 0;
                const phoneValid = document.getElementById('phone').value.trim().length > 0;
                
                const isValid = strength >= 1 && 
                               passwordsMatch && 
                               termsAccepted && 
                               nameValid && 
                               emailValid &&
                               companyValid &&
                               phoneValid;
                
                elements.submitButton.disabled = !isValid;
                
                return isValid;
            }

            // Setup modal functionality
            function setupModals() {
                // Open modals
                elements.openTermsModalBtn.addEventListener('click', function(e) {
                    e.preventDefault();
                    openModal(elements.termsModal);
                });

                elements.openPrivacyModalBtn.addEventListener('click', function(e) {
                    e.preventDefault();
                    openModal(elements.privacyModal);
                });

                // Close buttons
                elements.closeTermsModalBtn.addEventListener('click', function() {
                    closeModal(elements.termsModal);
                });

                elements.closePrivacyModalBtn.addEventListener('click', function() {
                    closeModal(elements.privacyModal);
                });

                // Close on overlay click
                elements.termsModal.addEventListener('click', function(e) {
                    if (e.target === this) {
                        closeModal(this);
                    }
                });

                elements.privacyModal.addEventListener('click', function(e) {
                    if (e.target === this) {
                        closeModal(this);
                    }
                });

                // Close on Escape key
                document.addEventListener('keydown', function(e) {
                    if (e.key === 'Escape') {
                        closeModal(elements.termsModal);
                        closeModal(elements.privacyModal);
                    }
                });
            }

            // Modal functions
            function openModal(modal) {
                modal.classList.add('active');
                document.body.style.overflow = 'hidden';
            }

            function closeModal(modal) {
                modal.classList.remove('active');
                document.body.style.overflow = 'auto';
            }

            // Auto-focus name field
            function autoFocusName() {
                const nameField = document.getElementById('name');
                if (nameField && !nameField.value) {
                    nameField.focus();
                }
            }

            // Form submission
            const signupForm = document.getElementById('signupForm');
            if (signupForm) {
                signupForm.addEventListener('submit', function(e) {
                    if (elements.submitButton.disabled) {
                        e.preventDefault();
                        return;
                    }

                    // Show loading state
                    elements.submitButton.disabled = true;
                    elements.submitButton.innerHTML = `
                        <div class="loading-spinner mr-2"></div>
                        <span>Creating your account...</span>
                    `;
                });
            }

            // Initialize
            init();
        });
    </script>

</body>
</html>