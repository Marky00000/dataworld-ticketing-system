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
    <div class="w-full bg-white/80 backdrop-blur-sm border-b border-gray-200 sticky top-0 z-50">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 py-4">
            <div class="flex items-center text-sm">
                <a href="/" class="text-gray-500 hover:text-primary transition flex items-center gap-1.5 group">
                    <i class="fas fa-home text-xs group-hover:text-primary"></i>
                    <span>Dashboard</span>
                </a>
                <i class="fas fa-chevron-right mx-2 text-xs text-gray-400"></i>
                <span class="text-primary font-medium bg-primary/5 px-2.5 py-1 rounded-full">Create Account</span>
            </div>
        </div>
    </div>

    <!-- Main Content Container -->
    <div class="flex-grow flex items-center justify-center p-4">
        <div class="w-full max-w-2xl relative z-10 animate-fadeIn">
            
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
                <h1 class="text-3xl font-bold text-gray-800 mt-6">Create Your Account</h1>
                <p class="text-gray-500 text-sm mt-1">Join Dataworld's free support portal</p>
            </div>

           <!-- Error Messages -->
            @if($errors->has('database'))
                <div class="mb-6 p-4 bg-red-50 text-red-700 rounded-xl border border-red-200">
                    <div class="flex items-center space-x-2 mb-3">
                        <div class="w-8 h-8 bg-red-100 rounded-full flex items-center justify-center">
                            <i class="fas fa-database text-red-600"></i>
                        </div>
                        <span class="font-medium text-base">Database Connection Error</span>
                    </div>
                    <p class="text-sm mb-3">{{ $errors->first('database') }}</p>
                </div>
            @endif

            @if($errors->any() && !$errors->has('database'))
                <div class="mb-6 p-4 bg-red-50 text-red-700 rounded-xl border border-red-200">
                    <div class="flex items-center space-x-2 mb-2">
                        <div class="w-6 h-6 bg-red-100 rounded-full flex items-center justify-center">
                            <i class="fas fa-exclamation-circle text-red-600 text-xs"></i>
                        </div>
                        <span class="font-medium">Please fix the following errors:</span>
                    </div>
                    <ul class="list-disc list-inside text-sm ml-8">
                        @foreach($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            @if(session('error'))
                <div class="mb-6 p-4 bg-red-50 text-red-700 rounded-xl border border-red-200">
                    <div class="flex items-center space-x-2">
                        <div class="w-6 h-6 bg-red-100 rounded-full flex items-center justify-center">
                            <i class="fas fa-exclamation-circle text-red-600 text-xs"></i>
                        </div>
                        <span>{{ session('error') }}</span>
                    </div>
                </div>
            @endif

            @if(session('success'))
                <div class="mb-6 p-4 bg-green-50 text-green-700 rounded-xl border border-green-200">
                    <div class="flex items-center space-x-2">
                        <div class="w-6 h-6 bg-green-100 rounded-full flex items-center justify-center">
                            <i class="fas fa-check-circle text-green-600 text-xs"></i>
                        </div>
                        <span>{{ session('success') }}</span>
                    </div>
                </div>
            @endif

            <!-- Sign Up Form -->
            <div class="bg-white rounded-2xl shadow-xl p-8 border border-gray-100 card-gradient-border relative">
                <!-- Decorative element -->
                <div class="absolute -top-3 left-1/2 -translate-x-1/2 w-20 h-1.5 bg-gradient-to-r from-primary to-primaryDark rounded-full"></div>
                
                <form action="{{ route('sign-up.post') }}" method="POST" id="signupForm">
                    @csrf
                    
                    <div class="grid md:grid-cols-2 gap-6">
                        <!-- Name -->
                        <div>
                            <label for="name" class="block text-xs font-semibold text-gray-700 uppercase tracking-wider mb-1.5 flex items-center">
                                <div class="w-5 h-5 bg-primary/10 rounded-full flex items-center justify-center mr-1.5">
                                    <i class="fas fa-user text-primary text-[10px]"></i>
                                </div>
                                Full Name *
                            </label>
                            <input type="text" 
                                   id="name" 
                                   name="name" 
                                   value="{{ old('name') }}"
                                   required
                                   class="w-full px-4 py-3 rounded-xl border border-gray-200 focus:outline-none focus:ring-2 focus:ring-primary/20 focus:border-primary transition-all text-sm bg-gray-50/50 hover:bg-white focus:bg-white"
                                   placeholder="John Doe">
                        </div>

                        <!-- Email -->
                        <div>
                            <label for="email" class="block text-xs font-semibold text-gray-700 uppercase tracking-wider mb-1.5 flex items-center">
                                <div class="w-5 h-5 bg-primary/10 rounded-full flex items-center justify-center mr-1.5">
                                    <i class="fas fa-envelope text-primary text-[10px]"></i>
                                </div>
                                Email Address *
                            </label>
                            <input type="email" 
                                   id="email" 
                                   name="email" 
                                   value="{{ old('email') }}"
                                   required
                                   class="w-full px-4 py-3 rounded-xl border border-gray-200 focus:outline-none focus:ring-2 focus:ring-primary/20 focus:border-primary transition-all text-sm bg-gray-50/50 hover:bg-white focus:bg-white"
                                   placeholder="you@company.com">
                        </div>

                        <!-- Company -->
                        <div>
                            <label for="company" class="block text-xs font-semibold text-gray-700 uppercase tracking-wider mb-1.5 flex items-center">
                                <div class="w-5 h-5 bg-primary/10 rounded-full flex items-center justify-center mr-1.5">
                                    <i class="fas fa-building text-primary text-[10px]"></i>
                                </div>
                                Company *
                            </label>
                            <input type="text" 
                                   id="company" 
                                   name="company" 
                                   value="{{ old('company') }}"
                                   required
                                   class="w-full px-4 py-3 rounded-xl border border-gray-200 focus:outline-none focus:ring-2 focus:ring-primary/20 focus:border-primary transition-all text-sm bg-gray-50/50 hover:bg-white focus:bg-white"
                                   placeholder="Your Company">
                            <p class="text-xs text-gray-500 mt-1">Organization name</p>
                        </div>

                        <!-- Phone -->
                        <div>
                            <label for="phone" class="block text-xs font-semibold text-gray-700 uppercase tracking-wider mb-1.5 flex items-center">
                                <div class="w-5 h-5 bg-primary/10 rounded-full flex items-center justify-center mr-1.5">
                                    <i class="fas fa-phone text-primary text-[10px]"></i>
                                </div>
                                Phone Number *
                            </label>
                            <input type="tel" 
                                   id="phone" 
                                   name="phone" 
                                   value="{{ old('phone') }}"
                                   required
                                   class="w-full px-4 py-3 rounded-xl border border-gray-200 focus:outline-none focus:ring-2 focus:ring-primary/20 focus:border-primary transition-all text-sm bg-gray-50/50 hover:bg-white focus:bg-white"
                                   placeholder="+63 912 345 6789">
                        </div>

                        <!-- Password -->
                        <div class="md:col-span-2 grid md:grid-cols-2 gap-6">
                            <div>
                                <label for="password" class="block text-xs font-semibold text-gray-700 uppercase tracking-wider mb-1.5 flex items-center">
                                    <div class="w-5 h-5 bg-primary/10 rounded-full flex items-center justify-center mr-1.5">
                                        <i class="fas fa-lock text-primary text-[10px]"></i>
                                    </div>
                                    Password *
                                </label>
                                <div class="relative">
                                    <input type="password" 
                                           id="password" 
                                           name="password" 
                                           required
                                           class="w-full px-4 py-3 pr-12 rounded-xl border border-gray-200 focus:outline-none focus:ring-2 focus:ring-primary/20 focus:border-primary transition-all text-sm bg-gray-50/50 hover:bg-white focus:bg-white"
                                           placeholder="Create a strong password">
                                    <button type="button" 
                                            id="togglePasswordBtn"
                                            class="absolute right-3 top-3 text-gray-400 hover:text-primary transition-colors focus:outline-none">
                                        <i class="fas fa-eye text-sm"></i>
                                    </button>
                                </div>
                                
                                <!-- Password Strength Meter -->
                                <div class="mt-3">
                                    <div class="flex justify-between text-xs text-gray-500 mb-1">
                                        <span>Password strength:</span>
                                        <span id="strengthTextDisplay" class="text-gray-500 font-medium">None</span>
                                    </div>
                                    <div id="passwordStrengthBar" class="password-strength strength-0"></div>
                                    <ul class="mt-2 text-xs text-gray-600 space-y-1" id="passwordCriteriaList">
                                        <li><i class="fas fa-times text-gray-300 mr-1.5"></i> At least 8 characters</li>
                                        <li><i class="fas fa-times text-gray-300 mr-1.5"></i> At least one uppercase letter</li>
                                        <li><i class="fas fa-times text-gray-300 mr-1.5"></i> At least one lowercase letter</li>
                                        <li><i class="fas fa-times text-gray-300 mr-1.5"></i> At least one number</li>
                                    </ul>
                                </div>
                            </div>

                            <!-- Confirm Password -->
                            <div>
                                <label for="password_confirmation" class="block text-xs font-semibold text-gray-700 uppercase tracking-wider mb-1.5 flex items-center">
                                    <div class="w-5 h-5 bg-primary/10 rounded-full flex items-center justify-center mr-1.5">
                                        <i class="fas fa-lock text-primary text-[10px]"></i>
                                    </div>
                                    Confirm Password *
                                </label>
                                <div class="relative">
                                    <input type="password" 
                                           id="password_confirmation" 
                                           name="password_confirmation" 
                                           required
                                           class="w-full px-4 py-3 pr-12 rounded-xl border border-gray-200 focus:outline-none focus:ring-2 focus:ring-primary/20 focus:border-primary transition-all text-sm bg-gray-50/50 hover:bg-white focus:bg-white"
                                           placeholder="Confirm your password">
                                    <button type="button" 
                                            id="toggleConfirmPasswordBtn"
                                            class="absolute right-3 top-3 text-gray-400 hover:text-primary transition-colors focus:outline-none">
                                        <i class="fas fa-eye text-sm"></i>
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
                        </div>
                    </div>

                    <!-- Terms and Conditions -->
                    <div class="mt-8">
                        <div class="flex items-start bg-gray-50 p-4 rounded-xl border border-gray-200">
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
                                </button>.
                                <span class="block text-xs text-gray-500 mt-1">
                                    Your data will be processed in accordance with Dataworld's privacy practices.
                                </span>
                            </label>
                        </div>
                    </div>

                    <!-- Submit Button -->
                    <div class="mt-8">
                        <button type="submit"
                                id="submitButton"
                                class="w-full bg-gradient-to-r from-primary to-primaryDark text-white py-4 px-4 rounded-xl font-medium hover:shadow-xl hover:shadow-primary/20 transition-all duration-300 flex items-center justify-center space-x-2 disabled:opacity-50 disabled:cursor-not-allowed text-base group relative overflow-hidden">
                            <span class="absolute inset-0 bg-white/10 translate-y-full group-hover:translate-y-0 transition-transform"></span>
                            <i class="fas fa-user-plus relative z-10"></i>
                            <span class="relative z-10">Create Account</span>
                        </button>
                        
                        <!-- Trust badges -->
                        <div class="flex items-center justify-center gap-4 mt-4 text-xs text-gray-400">
                            <span class="flex items-center gap-1">
                                <i class="fas fa-shield-alt text-primary"></i> No cost
                            </span>
                            <span class="w-1 h-1 bg-gray-300 rounded-full"></span>
                            <span class="flex items-center gap-1">
                                <i class="fas fa-clock text-primary"></i> 2-min setup
                            </span>
                            <span class="w-1 h-1 bg-gray-300 rounded-full"></span>
                            <span class="flex items-center gap-1">
                                <i class="fas fa-headset text-primary"></i> Free support
                            </span>
                        </div>
                    </div>
                </form>

                <!-- Sign In Link -->
                <div class="mt-8 pt-6 border-t border-gray-100 text-center">
                    <p class="text-sm text-gray-600">
                        Already have an account?
                        <a href="{{ route('sign-in') }}" class="text-primary font-semibold hover:text-primaryDark transition ml-1 group">
                            Sign in
                            <i class="fas fa-arrow-right text-xs ml-1 group-hover:translate-x-1 transition-transform"></i>
                        </a>
                    </p>
                </div>
            </div>
            
            <!-- Footer note -->
            <p class="text-center text-xs text-gray-400 mt-6 flex items-center justify-center gap-2">
                <i class="fas fa-shield-alt text-primary"></i>
                Free portal exclusively for Dataworld clients
            </p>
        </div>
    </div>

    <!-- Terms of Service Modal -->
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

    <!-- JavaScript -->
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
                    icon.className = type === 'password' ? 'fas fa-eye text-sm' : 'fas fa-eye-slash text-sm';
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
                        icon.className = 'fas fa-check text-green-500 mr-1.5';
                        icon.style.color = '#10b981';
                    } else {
                        icon.className = 'fas fa-times text-gray-300 mr-1.5';
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
                    
                    return true;
                });
            }

            // Initialize
            init();
        });
    </script>

</body>
</html>