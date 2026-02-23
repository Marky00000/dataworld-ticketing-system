<!DOCTYPE html>
<html lang="en">
<head>
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Client Support Portal - Dataworld Ticketing System</title>
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
        
        .animate-float {
            animation: float 6s ease-in-out infinite;
        }
        
        @keyframes float {
            0%, 100% { transform: translateY(0px); }
            50% { transform: translateY(-20px); }
        }
        
        /* Modal Styles - Centered */
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
            margin: auto;
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
        
        /* Loading spinner */
        .loading-spinner {
            width: 1.25rem;
            height: 1.25rem;
            border: 2px solid transparent;
            border-top-color: currentColor;
            border-radius: 50%;
            animation: spin 0.75s linear infinite;
        }
        
        @keyframes spin {
            to { transform: rotate(360deg); }
        }
        
        /* Fix for button disabled state */
        button:disabled {
            opacity: 0.5;
            cursor: not-allowed;
        }
        
        /* Fade in animation */
        @keyframes fadeIn {
            from { opacity: 0; transform: translateY(10px); }
            to { opacity: 1; transform: translateY(0); }
        }
        
        .animate-fadeIn {
            animation: fadeIn 0.5s ease-out;
        }
        
        /* Ensure body doesn't scroll when modal is open */
        body.modal-open {
            overflow: hidden;
        }
    </style>
</head>
<body class="bg-gray-50 min-h-screen flex flex-col">
    
    <!-- Background Elements -->
    <div class="fixed inset-0 overflow-hidden pointer-events-none">
        <div class="absolute -top-40 -right-40 w-80 h-80 bg-primary/10 rounded-full blur-3xl animate-float"></div>
        <div class="absolute -bottom-40 -left-40 w-80 h-80 bg-purple-300/10 rounded-full blur-3xl animate-float" style="animation-delay: 2s;"></div>
    </div>

<!-- Top Navigation with Breadcrumb - Solid White with higher z-index -->
<div class="w-full bg-white border-b border-gray-200 sticky top-0 z-50 shadow-sm">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 py-3">
        <div class="flex items-center text-sm">
                <a href="/" class="text-gray-500 hover:text-primary transition flex items-center gap-1">
                <i class="fas fa-home text-xs"></i>
                <span>Dashboard</span>
            </a>
            <i class="fas fa-chevron-right mx-2 text-xs text-gray-400"></i>
            <span class="text-primary font-medium">Sign Up</span>
        </div>
    </div>
</div>

    <!-- Main Content Container -->
    <div class="flex-1 flex items-center justify-center p-4">
        <div class="w-full max-w-2xl relative z-10 animate-fadeIn">
            
            <!-- Logo -->
            <div class="text-center mb-8">
                <a href="/" class="inline-flex items-center space-x-2 hover-lift">
                    <img src="{{ asset('images/dwcc.png') }}" 
                         alt="Dataworld Logo" 
                         class="h-10 w-auto">
                    <span class="text-xl font-bold text-primary">Dataworld</span>
                </a>
                <h1 class="text-2xl font-bold text-gray-800 mt-4">Support Portal Registration</h1>
            </div>

            @if($errors->any())
                <div class="mb-6 p-4 bg-red-50 text-red-700 rounded-lg border border-red-200">
                    <div class="flex items-center space-x-2 mb-2">
                        <i class="fas fa-exclamation-circle"></i>
                        <span class="font-medium">Please fix the following errors:</span>
                    </div>
                    <ul class="list-disc list-inside text-sm">
                        @foreach($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <!-- Sign Up Form -->
            <div class="bg-white rounded-2xl shadow-xl p-8 hover-lift">
                <form action="{{ route('sign-up.post') }}" method="POST" id="signupForm">
                    @csrf
                    
                    <div class="grid md:grid-cols-2 gap-6">
                        <!-- Name -->
                        <div>
                            <label for="name" class="block text-sm font-medium text-gray-700 mb-2">
                                <i class="fas fa-user text-gray-400 mr-2"></i>
                                Full Name *
                            </label>
                            <input type="text" 
                                   id="name" 
                                   name="name" 
                                   value="{{ old('name') }}"
                                   required
                                   class="w-full px-4 py-3 rounded-xl border border-gray-300 focus:outline-none focus:ring-2 focus:ring-primary focus:border-transparent transition input-focus"
                                   placeholder="John Doe">
                        </div>

                        <!-- Email -->
                        <div>
                            <label for="email" class="block text-sm font-medium text-gray-700 mb-2">
                                <i class="fas fa-envelope text-gray-400 mr-2"></i>
                                Email Address *
                            </label>
                            <input type="email" 
                                   id="email" 
                                   name="email" 
                                   value="{{ old('email') }}"
                                   required
                                   class="w-full px-4 py-3 rounded-xl border border-gray-300 focus:outline-none focus:ring-2 focus:ring-primary focus:border-transparent transition input-focus"
                                   placeholder="you@company.com">
                        </div>

                        <!-- Company -->
                        <div>
                            <label for="company" class="block text-sm font-medium text-gray-700 mb-2">
                                <i class="fas fa-building text-gray-400 mr-2"></i>
                                Company *
                            </label>
                            <input type="text" 
                                   id="company" 
                                   name="company" 
                                   value="{{ old('company') }}"
                                   required
                                   class="w-full px-4 py-3 rounded-xl border border-gray-300 focus:outline-none focus:ring-2 focus:ring-primary focus:border-transparent transition input-focus"
                                   placeholder="Your Company">
                            <p class="text-xs text-gray-500 mt-1">Please enter your organization name</p>
                        </div>

                        <!-- Phone -->
                        <div>
                            <label for="phone" class="block text-sm font-medium text-gray-700 mb-2">
                                <i class="fas fa-phone text-gray-400 mr-2"></i>
                                Phone Number *
                            </label>
                            <input type="tel" 
                                   id="phone" 
                                   name="phone" 
                                   value="{{ old('phone') }}"
                                   required
                                   class="w-full px-4 py-3 rounded-xl border border-gray-300 focus:outline-none focus:ring-2 focus:ring-primary focus:border-transparent transition input-focus"
                                   placeholder="+1 (555) 123-4567">
                        </div>

                        <!-- Password -->
                        <div>
                            <label for="password" class="block text-sm font-medium text-gray-700 mb-2">
                                <i class="fas fa-lock text-gray-400 mr-2"></i>
                                Password *
                            </label>
                            <div class="relative">
                                <input type="password" 
                                       id="password" 
                                       name="password" 
                                       required
                                       class="w-full px-4 py-3 pr-10 rounded-xl border border-gray-300 focus:outline-none focus:ring-2 focus:ring-primary focus:border-transparent transition input-focus"
                                       placeholder="Create a strong password">
                                <button type="button" 
                                        id="togglePasswordBtn"
                                        class="absolute right-3 top-3 text-gray-400 hover:text-gray-600">
                                    <i class="fas fa-eye"></i>
                                </button>
                            </div>
                            <!-- Password Strength Meter -->
                            <div class="mt-2">
                                <div class="flex justify-between text-xs text-gray-500 mb-1">
                                    <span>Password strength:</span>
                                    <span id="strengthTextDisplay" class="text-gray-500">None</span>
                                </div>
                                <div id="passwordStrengthBar" class="password-strength strength-0"></div>
                                <ul class="mt-2 text-xs text-gray-600 space-y-1" id="passwordCriteriaList">
                                    <li><i class="fas fa-times text-gray-300 mr-1"></i> At least 8 characters</li>
                                    <li><i class="fas fa-times text-gray-300 mr-1"></i> At least one uppercase letter</li>
                                    <li><i class="fas fa-times text-gray-300 mr-1"></i> At least one lowercase letter</li>
                                    <li><i class="fas fa-times text-gray-300 mr-1"></i> At least one number</li>
                                </ul>
                            </div>
                        </div>

                        <!-- Confirm Password -->
                        <div>
                            <label for="password_confirmation" class="block text-sm font-medium text-gray-700 mb-2">
                                <i class="fas fa-lock text-gray-400 mr-2"></i>
                                Confirm Password *
                            </label>
                            <div class="relative">
                                <input type="password" 
                                       id="password_confirmation" 
                                       name="password_confirmation" 
                                       required
                                       class="w-full px-4 py-3 pr-10 rounded-xl border border-gray-300 focus:outline-none focus:ring-2 focus:ring-primary focus:border-transparent transition input-focus"
                                       placeholder="Confirm your password">
                                <button type="button" 
                                        id="toggleConfirmPasswordBtn"
                                        class="absolute right-3 top-3 text-gray-400 hover:text-gray-600">
                                    <i class="fas fa-eye"></i>
                                </button>
                            </div>
                            <div id="passwordMatchContainer" class="mt-2 hidden">
                                <p id="passwordMatchMessage" class="text-xs text-red-600">
                                    <i class="fas fa-times mr-1"></i> Passwords don't match
                                </p>
                            </div>
                            <div id="passwordMatchSuccess" class="mt-2 hidden">
                                <p class="text-xs text-green-600">
                                    <i class="fas fa-check mr-1"></i> Passwords match
                                </p>
                            </div>
                        </div>
                    </div>

                    <!-- Terms and Conditions -->
                    <div class="mt-6">
                        <div class="flex items-start">
                            <input type="checkbox" 
                                   id="terms" 
                                   name="terms"
                                   required
                                   class="h-4 w-4 text-primary rounded focus:ring-primary border-gray-300 mt-1">
                            <label for="terms" class="ml-2 text-sm text-gray-600">
                                I agree to the 
                                <button type="button" 
                                        id="openTermsModal"
                                        class="text-primary hover:text-primaryDark transition font-medium hover:underline">
                                    Terms of Service
                                </button> 
                                and 
                                <button type="button" 
                                        id="openPrivacyModal"
                                        class="text-primary hover:text-primaryDark transition font-medium hover:underline">
                                    Privacy Policy
                                </button>.
                                I understand that my data will be processed in accordance with Dataworld's privacy practices.
                            </label>
                        </div>
                    </div>

                    <!-- Submit Button -->
                    <div class="mt-8">
                        <button type="submit"
                                id="submitButton"
                                class="w-full bg-gradient-to-r from-primary to-primaryDark text-white py-3 px-4 rounded-lg font-medium transition hover:opacity-90 disabled:opacity-50 disabled:cursor-not-allowed flex items-center justify-center space-x-2">
                            <i class="fas fa-user-plus"></i>
                            <span>Create Account</span>
                        </button>
                        
                        <p class="text-center text-xs text-gray-500 mt-3">
                            <i class="fas fa-shield-alt mr-1"></i>
                            Free support portal for Dataworld clients • No charges apply
                        </p>
                    </div>
                </form>

                <!-- Sign In Link -->
                <div class="mt-8 pt-6 border-t border-gray-200 text-center">
                    <p class="text-gray-600">
                        Already have a support account?
                        <a href="{{ route('sign-in') }}" class="text-primary font-medium hover:text-primaryDark transition ml-1">
                            Sign in
                        </a>
                    </p>
                </div>
            </div>
        </div>
    </div>

    <!-- Terms of Service Modal -->
    <div id="termsModal" class="modal-overlay" aria-hidden="true">
        <!-- Modal content (unchanged) -->
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

    <!-- Privacy Policy Modal -->
    <div id="privacyModal" class="modal-overlay" aria-hidden="true">
        <!-- Modal content (unchanged) -->
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

    <!-- Vanilla JavaScript -->
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            // Cache DOM elements
            const elements = {
                passwordInput: document.getElementById('password'),
                confirmPasswordInput: document.getElementById('password_confirmation'),
                togglePasswordBtn: document.getElementById('togglePasswordBtn'),
                toggleConfirmPasswordBtn: document.getElementById('toggleConfirmPasswordBtn'),
                strengthTextDisplay: document.getElementById('strengthTextDisplay'),
                passwordStrengthBar: document.getElementById('passwordStrengthBar'),
                passwordCriteriaList: document.getElementById('passwordCriteriaList'),
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
            const strengthConfig = {
                texts: ['Very Weak', 'Weak', 'Fair', 'Good', 'Strong'],
                colors: ['text-red-600', 'text-orange-600', 'text-yellow-600', 'text-green-600', 'text-green-700'],
                classes: ['strength-0', 'strength-1', 'strength-2', 'strength-3', 'strength-4']
            };
            
            // Criteria list items
            const criteriaItems = elements.passwordCriteriaList.querySelectorAll('li');
            
            // Initialize everything
            function init() {
                setupPasswordToggles();
                setupPasswordValidation();
                setupModals();
                autoFocusName();
            }

            // Setup password toggle functionality
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
                const { strength, criteria } = checkPasswordStrength(password);
                
                updateStrengthDisplay(strength);
                updateCriteriaDisplay(criteria);
                checkPasswordMatch();
                validateForm();
            }

            // Check password strength
            function checkPasswordStrength(password) {
                if (!password) {
                    return {
                        strength: 0,
                        criteria: [false, false, false, false]
                    };
                }
                
                const criteria = [
                    password.length >= 8,
                    /[A-Z]/.test(password),
                    /[a-z]/.test(password),
                    /\d/.test(password)
                ];
                
                const metCriteria = criteria.filter(Boolean).length;
                const strength = Math.min(metCriteria, 4);
                
                return {
                    strength: strength,
                    criteria: criteria
                };
            }

            // Update password criteria display
            function updateCriteriaDisplay(criteria) {
                criteriaItems.forEach((item, index) => {
                    const icon = item.querySelector('i');
                    if (criteria[index]) {
                        icon.className = 'fas fa-check text-green-500 mr-1';
                        icon.style.color = '#10b981';
                    } else {
                        icon.className = 'fas fa-times text-gray-300 mr-1';
                        icon.style.color = '#d1d5db';
                    }
                });
            }
            
            // Update strength display
            function updateStrengthDisplay(strength) {
                elements.passwordStrengthBar.className = `password-strength ${strengthConfig.classes[strength]}`;
                elements.strengthTextDisplay.textContent = strengthConfig.texts[strength];
                elements.strengthTextDisplay.className = strengthConfig.colors[strength];
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
                const { strength } = checkPasswordStrength(password);
                const passwordsMatch = checkPasswordMatch();
                const termsAccepted = elements.termsCheckbox.checked;
                const nameValid = document.getElementById('name').value.trim().length > 0;
                const emailValid = document.getElementById('email').value.trim().length > 0 && 
                                   document.getElementById('email').value.includes('@');
                const companyValid = document.getElementById('company').value.trim().length > 0;
                const phoneValid = document.getElementById('phone').value.trim().length > 0;
                
                const isValid = strength >= 2 && 
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
                // Open Terms Modal
                elements.openTermsModalBtn.addEventListener('click', function(e) {
                    e.preventDefault();
                    openModal(elements.termsModal);
                });

                // Open Privacy Modal
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
                document.body.classList.add('modal-open');
            }

            function closeModal(modal) {
                modal.classList.remove('active');
                document.body.classList.remove('modal-open');
            }

            // Auto-focus name field
            function autoFocusName() {
                const nameField = document.getElementById('name');
                if (nameField && !nameField.value) {
                    nameField.focus();
                }
            }

                // Form submission - REPLACE the existing form submission code with this
            const signupForm = document.getElementById('signupForm');
            if (signupForm) {
                signupForm.addEventListener('submit', function(e) {
                    // Don't prevent default - let the form submit normally
                    if (elements.submitButton.disabled) {
                        e.preventDefault();
                        return;
                    }

                    // Show loading state but let the form submit
                    elements.submitButton.disabled = true;
                    elements.submitButton.innerHTML = `
                        <div class="loading-spinner mr-2"></div>
                        <span>Creating Support Account...</span>
                    `;
                    
                    // The form will now submit normally to the server
                    return true;
                });
            }

            // Initialize
            init();
        });
    </script>

</body>
</html>