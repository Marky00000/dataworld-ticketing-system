<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Create New Ticket - Dataworld Support</title>
    <link rel="icon" type="image/png" href="{{ asset('images/logo.png') }}">
    
    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    
    <!-- Tailwind CSS -->
    <script src="https://cdn.tailwindcss.com"></script>
    
    <script>
        tailwind.config = {
            theme: {
                extend: {
                    colors: {
                        primary: '#6366f1',
                        primaryDark: '#4f46e5',
                        primaryLight: '#e0e7ff',
                        support: '#10b981',
                        warning: '#f59e0b',
                        critical: '#ef4444'
                    }
                }
            }
        }
    </script>
    
    <style>
        .sidebar {
            transition: all 0.3s ease;
        }
        
        .dashboard-card {
            transition: transform 0.3s ease, box-shadow 0.3s ease;
        }
        
        .dashboard-card:hover {
            transform: translateY(-5px);
            box-shadow: 0 20px 25px -5px rgba(0, 0, 0, 0.1), 0 10px 10px -5px rgba(0, 0, 0, 0.04);
        }
        
        .status-badge {
            display: inline-flex;
            align-items: center;
            padding: 0.25rem 0.75rem;
            border-radius: 9999px;
            font-size: 0.75rem;
            font-weight: 500;
        }
        
        .status-open { background: #dcfce7; color: #166534; }
        .status-in-progress { background: #dbeafe; color: #1e40af; }
        .status-resolved { background: #f0f9ff; color: #0c4a6e; }
        .status-critical { background: #fee2e2; color: #991b1b; }
        
        .priority-high { border-left: 4px solid #ef4444; }
        .priority-medium { border-left: 4px solid #f59e0b; }
        .priority-low { border-left: 4px solid #10b981; }
        
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
        
        /* Smooth transitions */
        .transition-all {
            transition: all 0.3s ease;
        }
        
        /* Custom scrollbar */
        .custom-scrollbar::-webkit-scrollbar {
            width: 6px;
        }
        
        .custom-scrollbar::-webkit-scrollbar-track {
            background: #f1f1f1;
            border-radius: 10px;
        }
        
        .custom-scrollbar::-webkit-scrollbar-thumb {
            background: #c1c1c1;
            border-radius: 10px;
        }
        
        .custom-scrollbar::-webkit-scrollbar-thumb:hover {
            background: #a1a1a1;
        }
        
        .error-message {
            color: #ef4444;
            font-size: 0.75rem;
            margin-top: 0.25rem;
        }
        
        .is-invalid {
            border-color: #ef4444 !important;
        }
        
        .is-invalid:focus {
            ring-color: #ef4444 !important;
        }
        
        /* Form styles */
        .form-input {
            transition: all 0.2s ease;
        }
        
        .form-input:focus {
            border-color: #6366f1;
            box-shadow: 0 0 0 3px rgba(99, 102, 241, 0.1);
        }
        
        /* Contact info card */
        .contact-card {
            background: linear-gradient(135deg, #f9fafb 0%, #f3f4f6 100%);
            border: 1px solid #e5e7eb;
        }
        
        /* Step Wizard Styles */
        .step-indicator {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 2.5rem;
            position: relative;
            padding: 0 1rem;
        }
        
        .step-indicator::before {
            content: '';
            position: absolute;
            top: 50%;
            left: 2rem;
            right: 2rem;
            height: 2px;
            background: linear-gradient(to right, #e5e7eb, #e5e7eb);
            transform: translateY(-50%);
            z-index: 1;
        }
        
        .step {
            position: relative;
            z-index: 2;
            background: white;
            padding: 0.75rem 1.5rem;
            border-radius: 9999px;
            font-weight: 600;
            color: #6b7280;
            border: 2px solid #e5e7eb;
            transition: all 0.3s ease;
            display: flex;
            align-items: center;
            gap: 0.5rem;
            font-size: 0.95rem;
            box-shadow: 0 2px 4px rgba(0,0,0,0.05);
        }
        
        .step.active {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            color: white;
            border-color: transparent;
            transform: scale(1.05);
            box-shadow: 0 10px 15px -3px rgba(99, 102, 241, 0.3);
        }
        
        .step.completed {
            background: #10b981;
            color: white;
            border-color: transparent;
        }
        
        .step-number {
            display: inline-flex;
            align-items: center;
            justify-content: center;
            width: 28px;
            height: 28px;
            border-radius: 50%;
            background: rgba(255, 255, 255, 0.2);
            font-size: 0.875rem;
            font-weight: 600;
        }
        
        .step.active .step-number,
        .step.completed .step-number {
            background: rgba(255, 255, 255, 0.25);
        }
        
        .form-step {
            display: none;
            animation: fadeIn 0.5s ease-out;
        }
        
        .form-step.active-step {
            display: block;
        }
        
        @keyframes fadeIn {
            from { opacity: 0; transform: translateX(20px); }
            to { opacity: 1; transform: translateX(0); }
        }
        
        .nav-buttons {
            display: flex;
            justify-content: space-between;
            margin-top: 2rem;
            padding-top: 1.5rem;
            border-top: 2px solid #f3f4f6;
        }
        
        .btn-next, .btn-prev, .btn-submit {
            padding: 0.875rem 2rem;
            border-radius: 9999px;
            font-weight: 600;
            display: flex;
            align-items: center;
            gap: 0.75rem;
            transition: all 0.3s ease;
            font-size: 0.95rem;
            letter-spacing: 0.025em;
        }
        
        .btn-next {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            color: white;
            margin-left: auto;
            box-shadow: 0 4px 6px -1px rgba(99, 102, 241, 0.2);
        }
        
        .btn-next:hover {
            transform: translateX(5px);
            box-shadow: 0 10px 15px -3px rgba(99, 102, 241, 0.4);
        }
        
        .btn-prev {
            background: white;
            color: #4b5563;
            border: 2px solid #e5e7eb;
        }
        
        .btn-prev:hover {
            border-color: #6366f1;
            color: #6366f1;
            transform: translateX(-5px);
            background: #f9fafb;
        }
        
        .btn-submit {
            background: linear-gradient(135deg, #10b981 0%, #059669 100%);
            color: white;
            margin-left: auto;
            box-shadow: 0 4px 6px -1px rgba(16, 185, 129, 0.2);
        }
        
        .btn-submit:hover {
            transform: scale(1.05);
            box-shadow: 0 10px 15px -3px rgba(16, 185, 129, 0.4);
        }
        
        .step-icon {
            width: 40px;
            height: 40px;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            background: #f3f4f6;
            color: #9ca3af;
            transition: all 0.3s ease;
        }
        
        .validation-summary {
            background: #fef2f2;
            border: 1px solid #fee2e2;
            border-radius: 1rem;
            padding: 1.25rem;
            margin-bottom: 1.5rem;
            display: none;
        }
        
        .validation-summary.show {
            display: block;
            animation: slideDown 0.3s ease-out;
        }
        
        @keyframes slideDown {
            from { opacity: 0; transform: translateY(-10px); }
            to { opacity: 1; transform: translateY(0); }
        }
        
        .validation-item {
            display: flex;
            align-items: center;
            gap: 0.75rem;
            color: #dc2626;
            font-size: 0.875rem;
            padding: 0.5rem 0;
        }
        
        .validation-item i {
            font-size: 0.875rem;
        }
        
        /* Priority radio cards */
        .priority-card {
            transition: all 0.3s ease;
            cursor: pointer;
        }
        
        .priority-card:hover {
            transform: translateY(-2px);
        }
        
        /* Gradient text */
        .gradient-text {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            background-clip: text;
        }
        
        /* Breadcrumb styling */
        .breadcrumb-hover {
            transition: color 0.2s ease;
        }
        
        /* File upload zone */
        .file-drop-zone {
            transition: all 0.3s ease;
        }
        
        .file-drop-zone:hover {
            border-color: #6366f1;
            background: #e0e7ff;
        }
        
        /* Summary card */
        .summary-card {
            background: linear-gradient(135deg, #f9fafb 0%, #f3f4f6 100%);
            border: 1px solid #e5e7eb;
        }
        
        /* Pulse animation for active step */
        @keyframes pulse {
            0%, 100% { opacity: 1; }
            50% { opacity: 0.7; }
        }
        
        .step.active {
            animation: pulse 2s infinite;
        }
    </style>
</head>
<body class="bg-gradient-to-br from-gray-50 to-gray-100 min-h-screen">
 <!-- Top Navigation Bar - Enhanced with active state -->
    <nav class="bg-white/80 backdrop-blur-md shadow-lg border-b border-primary/10 sticky top-0 z-50 transition-all duration-300" 
     x-data="{ 
        mobileMenuOpen: false, 
        scrolled: false,
        init() {
            window.addEventListener('scroll', () => {
                this.scrolled = window.scrollY > 20;
            });
        }
     }"
     :class="{ 'shadow-xl bg-white/95': scrolled }">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex justify-between h-16">
            <!-- Logo with animation -->
            <div class="flex items-center">
                <a href="/dashboard" class="flex items-center space-x-2 group">
                    <img src="{{ asset('images/logo.png') }}" alt="Dataworld Logo" 
                         class="h-8 w-auto transform group-hover:scale-110 transition-transform duration-300">
                    <div class="flex flex-col">
                        <span class="text-xs text-primary font-medium">
                            Dataworld Computer Center
                        </span>
                    </div>
                </a>
            </div>
            
            <!-- Desktop Navigation -->
            <div class="hidden md:flex items-center space-x-8">
                <!-- Navigation Links with active states -->
                <a href="/dashboard" 
                class="{{ request()->is('dashboard') ? 'text-primary' : 'text-gray-700 hover:text-primary' }} font-medium transition-all duration-300 flex items-center space-x-2 relative group">
                    <i class="fas fa-home"></i>
                    <span>Dashboard</span>
                    <span class="absolute -bottom-1 left-0 w-0 h-0.5 bg-primary group-hover:w-full transition-all duration-300"></span>
                </a>

<a href="/tickets" 
   class="{{ request()->is('tickets') || request()->is('tickets/*') ? 'text-gray-900' : 'text-gray-700 hover:text-primary' }} font-medium transition-all duration-300 flex items-center space-x-2 relative group">
    <i class="fas fa-ticket-alt"></i>
    <span>My Tickets</span>
    <span class="absolute -bottom-1 left-0 w-0 h-0.5 bg-primary group-hover:w-full transition-all duration-300"></span>
</a>

                <!-- New Ticket Button with shine effect -->
                <a href="/tickets/create" 
                   class="relative overflow-hidden group bg-gradient-to-r from-primary to-primaryDark text-white px-4 py-2 rounded-full text-sm font-medium hover:shadow-lg hover:shadow-primary/30 transition-all duration-300 flex items-center space-x-2">
                    <i class="fas fa-plus-circle"></i>
                    <span>New Ticket</span>
                    <div class="absolute inset-0 bg-white/20 transform -skew-x-12 -translate-x-full group-hover:translate-x-full transition-transform duration-700"></div>
                </a>

                <div class="h-6 w-px bg-gradient-to-b from-transparent via-gray-300 to-transparent"></div>

                <!-- User Dropdown - Working hover functionality -->
                <div class="relative group">
                    <!-- Dropdown Button -->
                    <button class="flex items-center space-x-3 focus:outline-none group cursor-pointer">
                        <div class="flex items-center space-x-3">
                            <!-- User avatar with gradient and enhanced effects -->
                            <div class="relative">
                                <div class="w-10 h-10 bg-gradient-to-r from-primary to-primaryDark rounded-full flex items-center justify-center text-white font-semibold shadow-md group-hover:shadow-lg transition-all duration-300">
                                    {{ substr(auth()->user()->name, 0, 1) }}
                                </div>
                                <div class="absolute -bottom-1 -right-1 w-3 h-3 bg-green-500 rounded-full border-2 border-white"></div>
                            </div>
                            <div class="text-left hidden lg:block">
                                <p class="text-sm font-medium text-gray-900">{{ auth()->user()->name }}</p>
                            </div>
                        </div>
                        <i class="fas fa-chevron-down text-gray-400 text-sm transition-transform duration-300 group-hover:rotate-180"></i>
                    </button>
                    
                    <!-- Dropdown Menu - Using hover functionality -->
                    <div class="absolute right-0 mt-2 w-64 bg-white rounded-xl shadow-2xl py-2 z-50 opacity-0 invisible group-hover:opacity-100 group-hover:visible transition-all duration-300 border border-primary/10 transform origin-top-right scale-95 group-hover:scale-100">
                        
                        <!-- User info header with enhanced design -->
                        <div class="px-4 py-4 border-b border-gray-100">
                            <div class="flex items-center space-x-3">
                                <div class="w-12 h-12 bg-gradient-to-br from-primary to-primaryDark rounded-full flex items-center justify-center text-white font-bold text-lg shadow-md">
                                    {{ substr(auth()->user()->name, 0, 1) }}
                                </div>
                                <div class="flex-1 min-w-0">
                                    <p class="text-sm font-bold text-gray-900 truncate">{{ auth()->user()->name }}</p>
                                    <p class="text-xs text-gray-500 truncate">{{ auth()->user()->email }}</p>
                                    <span class="inline-flex items-center mt-1 px-2 py-0.5 rounded-full text-xs font-medium 
                                        @if(auth()->user()->user_type === 'admin') bg-blue-100 text-blue-700
                                        @elseif(auth()->user()->user_type === 'tech') bg-purple-100 text-purple-700
                                        @else bg-primary/10 text-primary
                                        @endif">
                                        <i class="fas 
                                            @if(auth()->user()->user_type === 'admin') fa-crown
                                            @elseif(auth()->user()->user_type === 'tech') fa-tools
                                            @else fa-user
                                            @endif mr-1 text-[8px]"></i>
                                        @if(auth()->user()->user_type === 'admin')
                                            Admin Account
                                        @elseif(auth()->user()->user_type === 'tech')
                                            Tech Account
                                        @else
                                            Client Account
                                        @endif
                                    </span>
                                </div>
                            </div>
                        </div>
                        
                        <!-- Menu items with icons and hover effects -->
                        <a href="{{ route('profile.dashboard') }}" 
                           class="flex items-center space-x-3 px-4 py-3 text-sm text-gray-700 hover:bg-primary/5 transition-all duration-300 group">
                            <div class="w-8 h-8 rounded-lg bg-gray-100 group-hover:bg-primary/10 flex items-center justify-center transition-colors duration-300">
                                <i class="fas fa-user text-gray-500 group-hover:text-primary"></i>
                            </div>
                            <span class="flex-1">My Profile</span>
                            <i class="fas fa-chevron-right text-xs text-gray-400 group-hover:text-primary group-hover:translate-x-1 transition-all"></i>
                        </a>

                        @if(auth()->user()->user_type === 'admin')
                        <a href="{{ route('admin.tech.create') }}" 
                           class="flex items-center space-x-3 px-4 py-3 text-sm text-blue-600 hover:bg-blue-50 transition-all duration-300 group">
                            <div class="w-8 h-8 rounded-lg bg-blue-100 group-hover:bg-blue-200 flex items-center justify-center transition-colors duration-300">
                                <i class="fas fa-user-plus text-blue-600"></i>
                            </div>
                            <span class="flex-1 font-medium">Create Tech Account</span>
                            <span class="text-xs bg-blue-100 text-blue-800 px-2 py-0.5 rounded-full">Admin</span>
                        </a>
                        @endif
                        
                        <div class="border-t border-gray-100 my-1"></div>
                        
                        <!-- Sign Out Form -->
                        <form method="POST" action="{{ route('sign-out') }}" class="w-full">
                            @csrf
                            <button type="submit" 
                                    class="flex items-center space-x-3 px-4 py-3 text-sm text-red-600 hover:bg-red-50 transition-all duration-300 w-full text-left group">
                                <div class="w-8 h-8 rounded-lg bg-red-50 group-hover:bg-red-100 flex items-center justify-center transition-colors duration-300">
                                    <i class="fas fa-sign-out-alt text-red-500"></i>
                                </div>
                                <span class="flex-1">Sign Out</span>
                                <i class="fas fa-arrow-right-from-bracket text-xs text-red-400 group-hover:translate-x-1 transition-all"></i>
                            </button>
                        </form>
                    </div>
                </div>
            </div>
            
            <!-- Mobile menu button with animation -->
            <div class="md:hidden flex items-center">
                <button @click="mobileMenuOpen = !mobileMenuOpen" 
                        class="text-gray-500 hover:text-gray-700 focus:outline-none p-2 rounded-lg hover:bg-primary/5 transition-all duration-300"
                        :class="{ 'text-primary': mobileMenuOpen }">
                    <i :class="mobileMenuOpen ? 'fas fa-times text-xl' : 'fas fa-bars text-xl'"></i>
                </button>
            </div>
        </div>
    </div>
    
    <!-- Mobile Menu - Modern Slide Down -->
    <div x-show="mobileMenuOpen" 
         x-cloak
         x-transition:enter="transition ease-out duration-200"
         x-transition:enter-start="opacity-0 -translate-y-2"
         x-transition:enter-end="opacity-100 translate-y-0"
         x-transition:leave="transition ease-in duration-150"
         x-transition:leave-start="opacity-100 translate-y-0"
         x-transition:leave-end="opacity-0 -translate-y-2"
         class="md:hidden bg-white/95 backdrop-blur-md border-t border-primary/10">
        
        <div class="px-4 py-4 space-y-3">
            <!-- User Profile Header -->
            <div class="flex items-center space-x-4 px-3 py-4 bg-gradient-to-r from-primary/5 to-transparent rounded-xl border border-primary/10">
                <div class="relative">
                    <div class="w-14 h-14 bg-gradient-to-br from-primary to-primaryDark rounded-full flex items-center justify-center text-white font-bold text-xl shadow-lg">
                        {{ substr(auth()->user()->name, 0, 1) }}
                    </div>
                    <div class="absolute bottom-0 right-0 w-3.5 h-3.5 bg-green-500 rounded-full border-2 border-white"></div>
                </div>
                <div class="flex-1">
                    <p class="text-base font-bold text-gray-900">{{ auth()->user()->name }}</p>
                    <p class="text-xs text-gray-500">{{ auth()->user()->email }}</p>
                    <div class="flex items-center mt-1 space-x-2">
                        <span class="inline-flex items-center px-2 py-0.5 rounded-full text-xs font-medium 
                            @if(auth()->user()->user_type === 'admin') bg-blue-100 text-blue-700
                            @elseif(auth()->user()->user_type === 'tech') bg-purple-100 text-purple-700
                            @else bg-primary/10 text-primary
                            @endif">
                            <i class="fas 
                                @if(auth()->user()->user_type === 'admin') fa-crown
                                @elseif(auth()->user()->user_type === 'tech') fa-tools
                                @else fa-user
                                @endif mr-1 text-[8px]"></i>
                            {{ ucfirst(auth()->user()->user_type) }} Account
                        </span>
                        <span class="inline-flex items-center text-xs text-gray-500">
                            <i class="fas fa-circle text-green-500 text-[6px] mr-1"></i>
                            Online
                        </span>
                    </div>
                </div>
            </div>
            
            <!-- Navigation Items with improved design and active states -->
            <a href="/dashboard" 
               class="flex items-center space-x-3 px-4 py-3 {{ request()->is('dashboard') ? 'text-primary bg-primary/5 border border-primary/20' : 'text-gray-700 hover:bg-gray-50' }} rounded-xl transition-all duration-300 group">
                <div class="w-10 h-10 {{ request()->is('dashboard') ? 'bg-primary/10' : 'bg-gray-100 group-hover:bg-primary/10' }} rounded-xl flex items-center justify-center transition-colors">
                    <i class="fas fa-home {{ request()->is('dashboard') ? 'text-primary' : 'text-gray-500 group-hover:text-primary' }}"></i>
                </div>
                <div class="flex-1">
                    <p class="font-medium {{ request()->is('dashboard') ? 'text-primary' : 'text-gray-900' }}">Dashboard</p>
                    <p class="text-xs text-gray-500">Overview & statistics</p>
                </div>
                @if(request()->is('dashboard'))
                    <i class="fas fa-check-circle text-primary"></i>
                @endif
            </a>
            
            <a href="/tickets" 
               class="flex items-center space-x-3 px-4 py-3 {{ request()->is('tickets') || request()->is('tickets/*') ? 'text-primary bg-primary/5 border border-primary/20' : 'text-gray-700 hover:bg-gray-50' }} rounded-xl transition-all duration-300 group">
                <div class="w-10 h-10 {{ request()->is('tickets') || request()->is('tickets/*') ? 'bg-primary/10' : 'bg-gray-100 group-hover:bg-primary/10' }} rounded-xl flex items-center justify-center transition-colors">
                    <i class="fas fa-ticket-alt {{ request()->is('tickets') || request()->is('tickets/*') ? 'text-primary' : 'text-gray-500 group-hover:text-primary' }}"></i>
                </div>
                <div class="flex-1">
                    <div class="flex items-center justify-between">
                        <p class="font-medium {{ request()->is('tickets') || request()->is('tickets/*') ? 'text-primary' : 'text-gray-900' }}">My Tickets</p>
                        <span class="text-xs bg-primary/10 text-primary px-2 py-0.5 rounded-full">3</span>
                    </div>
                    <p class="text-xs text-gray-500">View your support tickets</p>
                </div>
            </a>
            
            <a href="/tickets/create" 
               class="flex items-center space-x-3 px-4 py-3 {{ request()->is('tickets/create') ? 'text-primary bg-primary/5 border border-primary/20' : 'text-gray-700 hover:bg-gray-50' }} rounded-xl transition-all duration-300 group">
                <div class="w-10 h-10 {{ request()->is('tickets/create') ? 'bg-primary/10' : 'bg-gray-100 group-hover:bg-primary/10' }} rounded-xl flex items-center justify-center transition-colors">
                    <i class="fas fa-plus-circle {{ request()->is('tickets/create') ? 'text-primary' : 'text-gray-500 group-hover:text-primary' }}"></i>
                </div>
                <div class="flex-1">
                    <p class="font-medium {{ request()->is('tickets/create') ? 'text-primary' : 'text-gray-900' }}">New Ticket</p>
                    <p class="text-xs text-gray-500">Create a support request</p>
                </div>
            </a>
            
            <a href="/knowledge-base" 
               class="flex items-center space-x-3 px-4 py-3 text-gray-700 hover:bg-gray-50 rounded-xl transition-all duration-300 group">
                <div class="w-10 h-10 bg-gray-100 group-hover:bg-primary/10 rounded-xl flex items-center justify-center transition-colors">
                    <i class="fas fa-book text-gray-500 group-hover:text-primary"></i>
                </div>
                <div class="flex-1">
                    <p class="font-medium text-gray-900">Knowledge Base</p>
                    <p class="text-xs text-gray-500">Guides & articles</p>
                </div>
            </a>
            
            @if(auth()->user()->user_type === 'admin')
            <div class="border-t border-gray-200 pt-4 mt-2">
                <a href="{{ route('admin.tech.create') }}" 
                   class="flex items-center space-x-3 px-4 py-3 text-blue-600 hover:bg-blue-50 rounded-xl transition-all duration-300 group border border-blue-100">
                    <div class="w-10 h-10 bg-blue-100 group-hover:bg-blue-200 rounded-xl flex items-center justify-center transition-colors">
                        <i class="fas fa-user-plus text-blue-600"></i>
                    </div>
                    <div class="flex-1">
                        <p class="font-medium text-blue-600">Create Tech Account</p>
                        <p class="text-xs text-blue-500">Add new technician</p>
                    </div>
                    <span class="text-xs bg-blue-100 text-blue-800 px-2 py-0.5 rounded-full">Admin</span>
                </a>
            </div>
            @endif
            
            <div class="border-t border-gray-200 pt-4 mt-2"></div>
            
            <!-- Profile & Settings -->
            <a href="{{ route('profile.dashboard') }}" 
               class="flex items-center space-x-3 px-4 py-3 text-gray-700 hover:bg-gray-50 rounded-xl transition-all duration-300 group">
                <div class="w-10 h-10 bg-gray-100 group-hover:bg-primary/10 rounded-xl flex items-center justify-center transition-colors">
                    <i class="fas fa-user text-gray-500 group-hover:text-primary"></i>
                </div>
                <div class="flex-1">
                    <p class="font-medium text-gray-900">My Profile</p>
                    <p class="text-xs text-gray-500">Manage your account</p>
                </div>
            </a>
            
            <!-- Sign Out Button -->
            <form method="POST" action="{{ route('sign-out') }}" class="mt-4">
                @csrf
                <button type="submit" 
                        class="flex items-center space-x-3 px-4 py-3 text-red-600 hover:bg-red-50 rounded-xl transition-all duration-300 w-full group border border-red-100">
                    <div class="w-10 h-10 bg-red-50 group-hover:bg-red-100 rounded-xl flex items-center justify-center transition-colors">
                        <i class="fas fa-sign-out-alt text-red-500"></i>
                    </div>
                    <div class="flex-1 text-left">
                        <p class="font-medium">Sign Out</p>
                        <p class="text-xs text-red-400">End your session</p>
                    </div>
                    <i class="fas fa-arrow-right-from-bracket text-xs text-red-400 group-hover:translate-x-1 transition-all"></i>
                </button>
            </form>
            
            <!-- Version Info -->
            <div class="px-4 py-3 mt-2">
                <p class="text-xs text-center text-gray-400">
                    Dataworld Ticketing System v2.0
                </p>
            </div>
        </div>
    </div>
</nav>

    <!-- Main Content -->
    <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
        <!-- Header with Breadcrumb -->
        <div class="mb-8">
            <div class="flex items-center text-sm text-gray-500 mb-4 bg-white/80 backdrop-blur-sm px-4 py-2 rounded-full shadow-sm inline-flex">
                <a href="/dashboard" class="hover:text-primary transition breadcrumb-hover flex items-center">
                    <i class="fas fa-home mr-1"></i>
                    <span>Dashboard</span>
                </a>
                <i class="fas fa-chevron-right mx-3 text-xs text-gray-400"></i>
                <a href="/tickets" class="hover:text-primary transition breadcrumb-hover flex items-center">
                    <i class="fas fa-ticket-alt mr-1"></i>
                    <span>My Tickets</span>
                </a>
                <i class="fas fa-chevron-right mx-3 text-xs text-gray-400"></i>
                <span class="text-primary font-medium flex items-center">
                    <i class="fas fa-plus-circle mr-1"></i>
                    Create New Ticket
                </span>
            </div>
            
            <div class="flex items-center justify-between">
                <div>
                    <h1 class="text-3xl md:text-4xl font-bold gradient-text">Create New Support Ticket</h1>
                    <p class="text-gray-600 mt-2">Complete the 3-step form below to submit your support request.</p>
                </div>
                <div class="hidden md:block">
                    <div class="bg-white/80 backdrop-blur-sm rounded-full px-4 py-2 shadow-sm">
                        <i class="fas fa-headset text-primary mr-2"></i>
                        <span class="text-sm text-gray-600">Need help? <a href="#" class="text-primary hover:underline">Contact support</a></span>
                    </div>
                </div>
            </div>
        </div>

        <!-- Success/Error Messages -->
        @if(session('success'))
            <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded-xl mb-6 flex items-center justify-between shadow-lg">
                <div class="flex items-center">
                    <div class="w-8 h-8 bg-green-200 rounded-full flex items-center justify-center mr-3">
                        <i class="fas fa-check-circle text-green-600"></i>
                    </div>
                    <span>{{ session('success') }}</span>
                </div>
                <button type="button" class="text-green-700 hover:text-green-900 p-1 hover:bg-green-200 rounded-full transition" onclick="this.parentElement.remove()">
                    <i class="fas fa-times"></i>
                </button>
            </div>
        @endif

        <!-- Validation Summary -->
        <div id="validationSummary" class="validation-summary">
            <div class="flex items-center gap-2 mb-2">
                <div class="w-8 h-8 bg-red-100 rounded-full flex items-center justify-center">
                    <i class="fas fa-exclamation-circle text-red-600"></i>
                </div>
                <span class="font-medium text-red-800">Please complete all required fields:</span>
            </div>
            <div id="validationList" class="space-y-1 ml-10">
                <!-- Validation items will be added here dynamically -->
            </div>
        </div>

        <!-- Form -->
        <div class="bg-white/80 backdrop-blur-sm rounded-2xl shadow-xl p-8 border border-gray-100">
            <!-- Step Indicator -->
            <div class="step-indicator">
                <div class="step active" data-step="1">
                    <span class="step-number">1</span>
                    <span class="hidden sm:inline">Ticket Details</span>
                    <span class="sm:hidden">Details</span>
                </div>
                <div class="step" data-step="2">
                    <span class="step-number">2</span>
                    <span class="hidden sm:inline">Device Info</span>
                    <span class="sm:hidden">Device</span>
                </div>
                <div class="step" data-step="3">
                    <span class="step-number">3</span>
                    <span class="hidden sm:inline">Review & Submit</span>
                    <span class="sm:hidden">Submit</span>
                </div>
            </div>

            <form action="{{ route('tickets.store') }}" method="POST" enctype="multipart/form-data" id="ticketForm">
                @csrf
                
                <!-- Step 1: Ticket Details -->
                <div class="form-step active-step" id="step1">
                    <div class="space-y-6">
                        <!-- Subject -->
                        <div>
                            <label for="subject" class="block text-sm font-medium text-gray-700 mb-2">
                                <div class="flex items-center">
                                    <div class="w-6 h-6 bg-primary/10 rounded-full flex items-center justify-center mr-2">
                                        <i class="fas fa-heading text-primary text-xs"></i>
                                    </div>
                                    Subject <span class="text-red-500 ml-1">*</span>
                                </div>
                            </label>
                            <input type="text" 
                                   id="subject" 
                                   name="subject" 
                                   value="{{ old('subject') }}"
                                   required
                                   class="w-full px-4 py-3 border border-gray-200 rounded-xl focus:outline-none focus:ring-2 focus:ring-primary/20 focus:border-primary transition-all bg-gray-50/50 hover:bg-white focus:bg-white @error('subject') is-invalid @enderror"
                                   placeholder="e.g., Network connectivity issue in office">
                            @error('subject')
                                <p class="error-message">{{ $message }}</p>
                            @enderror
                            <p class="text-xs text-gray-500 mt-2 flex items-center">
                                <i class="fas fa-info-circle text-primary mr-1"></i>
                                Be specific about the problem you're experiencing
                            </p>
                        </div>

                       <!-- Category - Dynamic from Database -->
<div>
    <div class="flex items-end justify-between mb-2">
        <label for="category" class="block text-sm font-medium text-gray-700">
            <div class="flex items-center">
                <div class="w-6 h-6 bg-primary/10 rounded-full flex items-center justify-center mr-2">
                    <i class="fas fa-folder text-primary text-xs"></i>
                </div>
                Category <span class="text-red-500 ml-1">*</span>
            </div>
        </label>
        
        <!-- Admin Add Category Button - Only visible to admin -->
        @if(auth()->user()->user_type === 'admin')
            <a href="{{ route('admin.ticket-categories') }}" 
               class="text-primary hover:text-primaryDark text-sm font-medium flex items-center space-x-1 transition group">
                <i class="fas fa-plus-circle group-hover:scale-110 transition"></i>
                <span>Add Category</span>
            </a>
        @endif
    </div>
    
    <select id="category" 
            name="category" 
            required
            class="w-full px-4 py-3 border border-gray-200 rounded-xl focus:outline-none focus:ring-2 focus:ring-primary/20 focus:border-primary transition-all bg-gray-50/50 hover:bg-white focus:bg-white @error('category') is-invalid @enderror">
        <option value="">Select a category</option>
        
        {{-- Regular categories sorted alphabetically --}}
        @php
            $regularCategories = $categories->filter(function($cat) {
                return strtolower($cat->name) !== 'other';
            })->sortBy('name');
            
            $otherCategory = $categories->filter(function($cat) {
                return strtolower($cat->name) === 'other';
            })->first();
        @endphp
        
        {{-- Display regular categories first --}}
        @foreach($regularCategories as $category)
            <option value="{{ $category->id }}" {{ old('category') == $category->id ? 'selected' : '' }}>
                {{ ucfirst(strtolower($category->name)) }}
            </option>
        @endforeach
        
        {{-- Display "Other" at the bottom if it exists --}}
        @if($otherCategory)
            <option value="{{ $otherCategory->id }}" {{ old('category') == $otherCategory->id ? 'selected' : '' }}>
                {{ ucfirst(strtolower($otherCategory->name)) }}
            </option>
        @else
            {{-- If "Other" doesn't exist in database, add it as a static option --}}
            <option value="other" {{ old('category') == 'other' ? 'selected' : '' }}>Other</option>
        @endif
    </select>
    @error('category')
        <p class="error-message">{{ $message }}</p>
    @enderror
</div>

                        <!-- Priority -->
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-3">
                                <div class="flex items-center">
                                    <div class="w-6 h-6 bg-primary/10 rounded-full flex items-center justify-center mr-2">
                                        <i class="fas fa-flag text-primary text-xs"></i>
                                    </div>
                                    Priority <span class="text-red-500 ml-1">*</span>
                                </div>
                            </label>
                            <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                                <label class="relative cursor-pointer priority-card">
                                    <input type="radio" name="priority" value="low" {{ old('priority', 'medium') == 'low' ? 'checked' : '' }} class="sr-only peer">
                                    <div class="p-4 border-2 border-gray-200 rounded-xl peer-checked:border-green-500 peer-checked:bg-green-50 hover:shadow-lg transition-all">
                                        <div class="flex items-center">
                                            <div class="w-10 h-10 bg-green-100 rounded-full flex items-center justify-center mr-3">
                                                <i class="fas fa-arrow-down text-green-600"></i>
                                            </div>
                                            <div>
                                                <p class="font-semibold">Low</p>
                                                <p class="text-xs text-gray-500">Minor issue</p>
                                            </div>
                                        </div>
                                    </div>
                                </label>
                                
                                <label class="relative cursor-pointer priority-card">
                                    <input type="radio" name="priority" value="medium" {{ old('priority', 'medium') == 'medium' ? 'checked' : '' }} class="sr-only peer">
                                    <div class="p-4 border-2 border-gray-200 rounded-xl peer-checked:border-yellow-500 peer-checked:bg-yellow-50 hover:shadow-lg transition-all">
                                        <div class="flex items-center">
                                            <div class="w-10 h-10 bg-yellow-100 rounded-full flex items-center justify-center mr-3">
                                                <i class="fas fa-minus text-yellow-600"></i>
                                            </div>
                                            <div>
                                                <p class="font-semibold">Medium</p>
                                                <p class="text-xs text-gray-500">Standard priority</p>
                                            </div>
                                        </div>
                                    </div>
                                </label>
                                
                                <label class="relative cursor-pointer priority-card">
                                    <input type="radio" name="priority" value="high" {{ old('priority') == 'high' ? 'checked' : '' }} class="sr-only peer">
                                    <div class="p-4 border-2 border-gray-200 rounded-xl peer-checked:border-red-500 peer-checked:bg-red-50 hover:shadow-lg transition-all">
                                        <div class="flex items-center">
                                            <div class="w-10 h-10 bg-red-100 rounded-full flex items-center justify-center mr-3">
                                                <i class="fas fa-arrow-up text-red-600"></i>
                                            </div>
                                            <div>
                                                <p class="font-semibold">High</p>
                                                <p class="text-xs text-gray-500">Urgent issue</p>
                                            </div>
                                        </div>
                                    </div>
                                </label>
                            </div>
                            @error('priority')
                                <p class="error-message">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Description -->
                        <div>
                            <label for="description" class="block text-sm font-medium text-gray-700 mb-2">
                                <div class="flex items-center">
                                    <div class="w-6 h-6 bg-primary/10 rounded-full flex items-center justify-center mr-2">
                                        <i class="fas fa-align-left text-primary text-xs"></i>
                                    </div>
                                    Description <span class="text-red-500 ml-1">*</span>
                                </div>
                            </label>
                            <textarea id="description" 
                                      name="description" 
                                      rows="6"
                                      required
                                      class="w-full px-4 py-3 border border-gray-200 rounded-xl focus:outline-none focus:ring-2 focus:ring-primary/20 focus:border-primary transition-all bg-gray-50/50 hover:bg-white focus:bg-white @error('description') is-invalid @enderror"
                                      placeholder="Please provide detailed information about your issue. Include steps to reproduce, error messages, and any troubleshooting you've already tried.">{{ old('description') }}</textarea>
                            <div class="flex justify-between text-xs text-gray-500 mt-2">
                                <span class="flex items-center"><i class="fas fa-info-circle text-primary mr-1"></i>Be as detailed as possible</span>
                                <span id="charCount" class="bg-primary/10 text-primary px-3 py-1 rounded-full font-medium">{{ strlen(old('description', '')) }}/5000</span>
                            </div>
                            @error('description')
                                <p class="error-message">{{ $message }}</p>
                            @enderror
                        </div>
                    </div>
                </div>

                <!-- Step 2: Device Information -->
                <div class="form-step" id="step2">
                    <div class="bg-gradient-to-br from-primary/5 to-indigo-500/5 rounded-xl p-6 border border-primary/10">
                        <h3 class="text-lg font-semibold text-gray-800 mb-4 flex items-center">
                            <div class="w-8 h-8 bg-primary/20 rounded-full flex items-center justify-center mr-3">
                                <i class="fas fa-microchip text-primary"></i>
                            </div>
                            Device Information
                        </h3>
                        <p class="text-sm text-gray-600 mb-6 bg-white/50 p-3 rounded-lg border border-gray-200">
                            <i class="fas fa-info-circle text-primary mr-2"></i>
                            Please provide details about the device you're having issues with. This helps our support team provide faster assistance.
                        </p>
                        
                        <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                            <div>
                                <label for="model" class="block text-sm font-medium text-gray-700 mb-2">
                                    <i class="fas fa-tag text-primary mr-2"></i>Model
                                </label>
                                <input type="text" 
                                       id="model" 
                                       name="model" 
                                       value="{{ old('model') }}"
                                       class="w-full px-4 py-3 border border-gray-200 rounded-xl focus:outline-none focus:ring-2 focus:ring-primary/20 focus:border-primary transition-all bg-gray-50/50 hover:bg-white focus:bg-white @error('model') is-invalid @enderror"
                                       placeholder="e.g., RT-AC68U">
                                @error('model')
                                    <p class="error-message">{{ $message }}</p>
                                @enderror
                                <p class="text-xs text-gray-500 mt-1">Device model number</p>
                            </div>
                            
                            <div>
                                <label for="firmware_version" class="block text-sm font-medium text-gray-700 mb-2">
                                    <i class="fas fa-code-branch text-primary mr-2"></i>Firmware Version
                                </label>
                                <input type="text" 
                                       id="firmware_version" 
                                       name="firmware_version" 
                                       value="{{ old('firmware_version') }}"
                                       class="w-full px-4 py-3 border border-gray-200 rounded-xl focus:outline-none focus:ring-2 focus:ring-primary/20 focus:border-primary transition-all bg-gray-50/50 hover:bg-white focus:bg-white @error('firmware_version') is-invalid @enderror"
                                       placeholder="e.g., 3.0.0.4.386_48247">
                                @error('firmware_version')
                                    <p class="error-message">{{ $message }}</p>
                                @enderror
                                <p class="text-xs text-gray-500 mt-1">Current firmware version</p>
                            </div>
                            
                            <div>
                                <label for="serial_number" class="block text-sm font-medium text-gray-700 mb-2">
                                    <i class="fas fa-barcode text-primary mr-2"></i>Serial Number
                                </label>
                                <input type="text" 
                                       id="serial_number" 
                                       name="serial_number" 
                                       value="{{ old('serial_number') }}"
                                       class="w-full px-4 py-3 border border-gray-200 rounded-xl focus:outline-none focus:ring-2 focus:ring-primary/20 focus:border-primary transition-all bg-gray-50/50 hover:bg-white focus:bg-white @error('serial_number') is-invalid @enderror"
                                       placeholder="e.g., ABC12345678">
                                @error('serial_number')
                                    <p class="error-message">{{ $message }}</p>
                                @enderror
                                <p class="text-xs text-gray-500 mt-1">Device serial number</p>
                            </div>
                        </div>
                    </div>

                    <!-- Attachments -->
                    <div class="mt-8">
                        <label class="block text-sm font-medium text-gray-700 mb-3">
                            <div class="flex items-center">
                                <div class="w-6 h-6 bg-primary/10 rounded-full flex items-center justify-center mr-2">
                                    <i class="fas fa-paperclip text-primary text-xs"></i>
                                </div>
                                Attachments (Optional)
                            </div>
                        </label>
                        <div class="border-2 border-dashed border-gray-300 rounded-xl p-8 text-center hover:border-primary hover:bg-primary/5 transition-all cursor-pointer file-drop-zone" id="dropZone">
                            <div class="flex flex-col items-center">
                                <div class="w-20 h-20 bg-primary/10 rounded-full flex items-center justify-center mb-4">
                                    <i class="fas fa-cloud-upload-alt text-primary text-3xl"></i>
                                </div>
                                <p class="text-sm text-gray-700 mb-1 font-medium">Drag and drop files here, or click to browse</p>
                                <p class="text-xs text-gray-500 mb-4">Max file size: 10MB • Supported: images, docs, logs</p>
                                <input type="file" 
                                       name="attachments[]" 
                                       multiple 
                                       class="hidden" 
                                       id="fileInput"
                                       accept=".jpg,.jpeg,.png,.gif,.pdf,.doc,.docx,.txt,.log">
                                <button type="button" 
                                        onclick="document.getElementById('fileInput').click()"
                                        class="bg-gradient-to-r from-primary to-primaryDark hover:from-primaryDark hover:to-primary text-white px-6 py-3 rounded-xl text-sm font-medium transition-all shadow-md hover:shadow-lg flex items-center space-x-2">
                                    <i class="fas fa-folder-open"></i>
                                    <span>Browse Files</span>
                                </button>
                            </div>
                        </div>
                        <div id="fileList" class="mt-4 space-y-2 hidden">
                            <h4 class="text-xs font-medium text-gray-700 mb-2 flex items-center bg-gray-50 px-3 py-2 rounded-lg">
                                <i class="fas fa-paperclip text-primary mr-2"></i>
                                Selected Files
                            </h4>
                            <!-- Files will be listed here -->
                        </div>
                        @error('attachments.*')
                            <p class="error-message">{{ $message }}</p>
                        @enderror
                    </div>
                </div>

                <!-- Step 3: Review & Submit -->
                <div class="form-step" id="step3">
                    <div class="space-y-6">
                        <!-- Contact Information -->
                        <div class="bg-gradient-to-br from-gray-50 to-gray-100 rounded-xl p-6 border border-gray-200">
                            <h3 class="text-lg font-semibold text-gray-800 mb-4 flex items-center">
                                <div class="w-8 h-8 bg-primary/20 rounded-full flex items-center justify-center mr-3">
                                    <i class="fas fa-address-card text-primary"></i>
                                </div>
                                Contact Information
                            </h3>
                            <p class="text-sm text-gray-600 mb-6 bg-white/50 p-3 rounded-lg border border-gray-200">
                                <i class="fas fa-info-circle text-primary mr-2"></i>
                                Review your contact details before submitting.
                            </p>
                            
                            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                                <div>
                                    <label for="contact_name" class="block text-sm font-medium text-gray-700 mb-2">
                                        <i class="fas fa-user text-primary mr-2"></i>Full Name <span class="text-red-500">*</span>
                                    </label>
                                    <input type="text" 
                                           id="contact_name" 
                                           name="contact_name" 
                                           value="{{ old('contact_name', auth()->user()->name) }}"
                                           class="w-full px-4 py-3 border border-gray-200 rounded-xl focus:outline-none focus:ring-2 focus:ring-primary/20 focus:border-primary transition-all bg-white"
                                           placeholder="Your full name">
                                    @error('contact_name')
                                        <p class="error-message">{{ $message }}</p>
                                    @enderror
                                </div>
                                
                                <div>
                                    <label for="contact_email" class="block text-sm font-medium text-gray-700 mb-2">
                                        <i class="fas fa-envelope text-primary mr-2"></i>Email Address <span class="text-red-500">*</span>
                                    </label>
                                    <input type="email" 
                                           id="contact_email" 
                                           name="contact_email" 
                                           value="{{ old('contact_email', auth()->user()->email) }}"
                                           class="w-full px-4 py-3 border border-gray-200 rounded-xl focus:outline-none focus:ring-2 focus:ring-primary/20 focus:border-primary transition-all bg-white"
                                           placeholder="your@email.com">
                                    @error('contact_email')
                                        <p class="error-message">{{ $message }}</p>
                                    @enderror
                                </div>
                                
                                <div>
                                    <label for="contact_phone" class="block text-sm font-medium text-gray-700 mb-2">
                                        <i class="fas fa-phone text-primary mr-2"></i>Phone Number
                                    </label>
                                    <input type="tel" 
                                           id="contact_phone" 
                                           name="contact_phone" 
                                           value="{{ old('contact_phone', auth()->user()->phone) }}"
                                           class="w-full px-4 py-3 border border-gray-200 rounded-xl focus:outline-none focus:ring-2 focus:ring-primary/20 focus:border-primary transition-all bg-white"
                                           placeholder="+63 912 345 6789">
                                    @error('contact_phone')
                                        <p class="error-message">{{ $message }}</p>
                                    @enderror
                                </div>
                                
                                <div>
                                    <label for="contact_company" class="block text-sm font-medium text-gray-700 mb-2">
                                        <i class="fas fa-building text-primary mr-2"></i>Company
                                    </label>
                                    <input type="text" 
                                           id="contact_company" 
                                           name="contact_company" 
                                           value="{{ old('contact_company', auth()->user()->company) }}"
                                           class="w-full px-4 py-3 border border-gray-200 rounded-xl focus:outline-none focus:ring-2 focus:ring-primary/20 focus:border-primary transition-all bg-white"
                                           placeholder="Company name">
                                    @error('contact_company')
                                        <p class="error-message">{{ $message }}</p>
                                    @enderror
                                </div>
                            </div>
                        </div>

                        <!-- Summary Card -->
                        <div class="bg-gradient-to-br from-primary/5 to-indigo-500/5 rounded-xl p-6 border border-primary/20">
                            <h4 class="font-semibold text-gray-800 mb-4 flex items-center">
                                <div class="w-6 h-6 bg-primary/20 rounded-full flex items-center justify-center mr-2">
                                    <i class="fas fa-clipboard-check text-primary text-xs"></i>
                                </div>
                                Ticket Summary
                            </h4>
                            <div class="space-y-3 text-sm bg-white/50 p-4 rounded-lg" id="summaryContent">
                                <div class="flex justify-between py-2 border-b border-gray-200">
                                    <span class="text-gray-600">Subject:</span>
                                    <span class="font-medium text-gray-900" id="summarySubject">-</span>
                                </div>
                                <div class="flex justify-between py-2 border-b border-gray-200">
                                    <span class="text-gray-600">Category:</span>
                                    <span class="font-medium text-gray-900" id="summaryCategory">-</span>
                                </div>
                                <div class="flex justify-between py-2 border-b border-gray-200">
                                    <span class="text-gray-600">Priority:</span>
                                    <span class="font-medium" id="summaryPriority">-</span>
                                </div>
                                <div class="flex justify-between py-2 border-b border-gray-200">
                                    <span class="text-gray-600">Device Model:</span>
                                    <span class="font-medium text-gray-900" id="summaryModel">-</span>
                                </div>
                                <div class="flex justify-between py-2 border-b border-gray-200">
                                    <span class="text-gray-600">Firmware:</span>
                                    <span class="font-medium text-gray-900" id="summaryFirmware">-</span>
                                </div>
                                <div class="flex justify-between py-2 border-b border-gray-200">
                                    <span class="text-gray-600">Contact:</span>
                                    <span class="font-medium text-gray-900" id="summaryContact">-</span>
                                </div>
                                <div class="flex justify-between py-2">
                                    <span class="text-gray-600">Attachments:</span>
                                    <span class="font-medium text-gray-900" id="summaryAttachments">0 files</span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Navigation Buttons -->
                <div class="nav-buttons">
                    <button type="button" class="btn-prev" id="prevBtn" style="visibility: hidden;">
                        <i class="fas fa-arrow-left"></i>
                        Previous
                    </button>
                    <button type="button" class="btn-next" id="nextBtn">
                        Next
                        <i class="fas fa-arrow-right"></i>
                    </button>
                    <button type="submit" class="btn-submit" id="submitBtn" style="display: none;">
                        <i class="fas fa-check-circle"></i>
                        Submit Ticket
                    </button>
                </div>
            </form>
        </div>
    </div>

   <!-- Footer - Enhanced -->
    <footer class="bg-gray-900 text-gray-400 py-8">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="border-t border-gray-800 pt-8 text-center text-sm">
                <p>© {{ date('Y') }} Dataworld Computer Center. All rights reserved.</p>
                <p class="mt-2 text-xs text-gray-600">
                    <i class="fas fa-ticket-alt mr-1"></i>
                    Support Ticket System v1.0
                </p>
            </div>
        </div>
    </footer>


    <script>
    // Auto-hide success message after 3 seconds
    document.addEventListener('DOMContentLoaded', function() {
        const successMessage = document.querySelector('.bg-green-100');
        
        if (successMessage) {
            setTimeout(function() {
                successMessage.style.transition = 'opacity 0.5s ease';
                successMessage.style.opacity = '0';
                
                setTimeout(function() {
                    successMessage.style.display = 'none';
                }, 500);
            }, 3000);
        }
    });
</script>

    <script>
        // Your existing JavaScript remains exactly the same
        document.addEventListener('DOMContentLoaded', function() {
            console.log('DOM loaded - initializing wizard');
            
            // Step wizard functionality
            let currentStep = 1;
            const totalSteps = 3;
            
            const steps = document.querySelectorAll('.step');
            const formSteps = document.querySelectorAll('.form-step');
            const prevBtn = document.getElementById('prevBtn');
            const nextBtn = document.getElementById('nextBtn');
            const submitBtn = document.getElementById('submitBtn');
            
            console.log('Elements found:', {
                steps: steps.length,
                formSteps: formSteps.length,
                prevBtn: !!prevBtn,
                nextBtn: !!nextBtn,
                submitBtn: !!submitBtn
            });
            
            // Store auth user name for summary
            const authUserName = "{{ auth()->user()->name }}";
            
            // Required field IDs for validation
            const requiredFields = {
                1: ['subject', 'category', 'description'],
                2: [],
                3: ['contact_name', 'contact_email']
            };
            
            function updateStepIndicator() {
                steps.forEach((step, index) => {
                    const stepNum = index + 1;
                    step.classList.remove('active', 'completed');
                    
                    if (stepNum === currentStep) {
                        step.classList.add('active');
                    } else if (stepNum < currentStep) {
                        step.classList.add('completed');
                    }
                });
            }
            
            function showStep(step) {
                console.log('Showing step:', step);
                
                formSteps.forEach((formStep, index) => {
                    if (index + 1 === step) {
                        formStep.classList.add('active-step');
                    } else {
                        formStep.classList.remove('active-step');
                    }
                });
                
                // Update navigation buttons
                if (prevBtn) {
                    prevBtn.style.visibility = step === 1 ? 'hidden' : 'visible';
                }
                
                if (nextBtn && submitBtn) {
                    if (step === totalSteps) {
                        nextBtn.style.display = 'none';
                        submitBtn.style.display = 'flex';
                        updateSummary();
                    } else {
                        nextBtn.style.display = 'flex';
                        submitBtn.style.display = 'none';
                    }
                }
                
                updateStepIndicator();
            }
            
            function validateStep(step) {
                const fields = requiredFields[step] || [];
                const missingFields = [];
                
                if (fields.length > 0) {
                    fields.forEach(fieldId => {
                        const field = document.getElementById(fieldId);
                        if (field && !field.value.trim()) {
                            missingFields.push(fieldId);
                            field.classList.add('is-invalid');
                        } else if (field) {
                            field.classList.remove('is-invalid');
                        }
                    });
                }
                
                if (step === 1) {
                    const prioritySelected = document.querySelector('input[name="priority"]:checked');
                    if (!prioritySelected) {
                        missingFields.push('priority');
                        document.querySelectorAll('input[name="priority"]').forEach(radio => {
                            radio.closest('label')?.classList.add('is-invalid');
                        });
                    } else {
                        document.querySelectorAll('input[name="priority"]').forEach(radio => {
                            radio.closest('label')?.classList.remove('is-invalid');
                        });
                    }
                }
                
                return missingFields.length === 0;
            }
            
            function showValidationSummary(missingFields) {
                const summary = document.getElementById('validationSummary');
                const list = document.getElementById('validationList');
                
                if (!summary || !list) return;
                
                list.innerHTML = '';
                missingFields.forEach(field => {
                    const item = document.createElement('div');
                    item.className = 'validation-item';
                    
                    let fieldLabel = field;
                    switch(field) {
                        case 'subject': fieldLabel = 'Subject'; break;
                        case 'category': fieldLabel = 'Category'; break;
                        case 'priority': fieldLabel = 'Priority'; break;
                        case 'description': fieldLabel = 'Description'; break;
                        case 'contact_name': fieldLabel = 'Full Name'; break;
                        case 'contact_email': fieldLabel = 'Email Address'; break;
                    }
                    
                    item.innerHTML = `<i class="fas fa-exclamation-circle"></i> ${fieldLabel} is required`;
                    list.appendChild(item);
                });
                
                summary.classList.add('show');
                
                setTimeout(() => {
                    summary.classList.remove('show');
                }, 5000);
            }
            
            function updateSummary() {
                const subject = document.getElementById('subject')?.value || '-';
                const summarySubject = document.getElementById('summarySubject');
                if (summarySubject) summarySubject.textContent = subject;
                
                const categorySelect = document.getElementById('category');
                const categoryText = categorySelect?.options[categorySelect.selectedIndex]?.text || '-';
                const summaryCategory = document.getElementById('summaryCategory');
                if (summaryCategory) summaryCategory.textContent = categoryText;
                
                const priority = document.querySelector('input[name="priority"]:checked')?.value || 'medium';
                const priorityElem = document.getElementById('summaryPriority');
                if (priorityElem) {
                    priorityElem.textContent = priority.charAt(0).toUpperCase() + priority.slice(1);
                    priorityElem.className = 'font-medium ' + 
                        (priority === 'high' ? 'text-red-600' : 
                         priority === 'medium' ? 'text-yellow-600' : 'text-green-600');
                }
                
                const summaryModel = document.getElementById('summaryModel');
                if (summaryModel) summaryModel.textContent = document.getElementById('model')?.value || '-';
                
                const summaryFirmware = document.getElementById('summaryFirmware');
                if (summaryFirmware) summaryFirmware.textContent = document.getElementById('firmware_version')?.value || '-';
                
                const contactName = document.getElementById('contact_name')?.value || authUserName;
                const summaryContact = document.getElementById('summaryContact');
                if (summaryContact) summaryContact.textContent = contactName;
                
                const fileInput = document.getElementById('fileInput');
                const fileCount = fileInput?.files.length || 0;
                const summaryAttachments = document.getElementById('summaryAttachments');
                if (summaryAttachments) {
                    summaryAttachments.textContent = fileCount + ' file' + (fileCount !== 1 ? 's' : '');
                }
            }
            
            // Next button click
            if (nextBtn) {
                console.log('Adding click listener to next button');
                
                nextBtn.addEventListener('click', function(e) {
                    e.preventDefault();
                    console.log('Next button clicked - current step:', currentStep);
                    
                    if (validateStep(currentStep)) {
                        console.log('Step validation passed');
                        if (currentStep < totalSteps) {
                            currentStep++;
                            console.log('Moving to step:', currentStep);
                            showStep(currentStep);
                        }
                    } else {
                        console.log('Step validation failed');
                        const missingFields = [];
                        
                        if (requiredFields[currentStep] && requiredFields[currentStep].length > 0) {
                            requiredFields[currentStep].forEach(fieldId => {
                                const field = document.getElementById(fieldId);
                                if (field && !field.value.trim()) {
                                    missingFields.push(fieldId);
                                }
                            });
                        }
                        
                        if (currentStep === 1) {
                            const prioritySelected = document.querySelector('input[name="priority"]:checked');
                            if (!prioritySelected) {
                                missingFields.push('priority');
                            }
                        }
                        
                        if (missingFields.length > 0) {
                            console.log('Missing fields:', missingFields);
                            showValidationSummary(missingFields);
                        }
                    }
                });
            } else {
                console.error('Next button not found!');
            }
            
            // Previous button click
            if (prevBtn) {
                prevBtn.addEventListener('click', function(e) {
                    e.preventDefault();
                    console.log('Previous button clicked');
                    if (currentStep > 1) {
                        currentStep--;
                        showStep(currentStep);
                    }
                });
            }
            
            // Character counter for description
            const description = document.getElementById('description');
            const charCount = document.getElementById('charCount');
            const maxChars = 5000;
            
            if (description && charCount) {
                description.addEventListener('input', function() {
                    const currentLength = this.value.length;
                    charCount.textContent = currentLength + '/' + maxChars;
                    
                    if (currentLength > maxChars) {
                        this.value = this.value.substring(0, maxChars);
                        charCount.textContent = maxChars + '/' + maxChars;
                    }
                    
                    if (currentLength > maxChars * 0.9) {
                        charCount.classList.add('text-orange-600', 'bg-orange-100');
                        charCount.classList.remove('bg-primary/10', 'text-primary');
                    } else {
                        charCount.classList.remove('text-orange-600', 'bg-orange-100');
                        charCount.classList.add('bg-primary/10', 'text-primary');
                    }
                });
            }
            
            // File upload preview
            const fileInput = document.getElementById('fileInput');
            const fileList = document.getElementById('fileList');
            const dropZone = document.getElementById('dropZone');
            
            if (fileInput && fileList) {
                fileInput.addEventListener('change', function() {
                    fileList.innerHTML = '<h4 class="text-xs font-medium text-gray-700 mb-2 flex items-center bg-gray-50 px-3 py-2 rounded-lg"><i class="fas fa-paperclip text-primary mr-2"></i>Selected Files</h4>';
                    
                    if (this.files.length > 0) {
                        fileList.classList.remove('hidden');
                        
                        Array.from(this.files).forEach((file, index) => {
                            if (file.size > 10 * 1024 * 1024) {
                                alert(`File "${file.name}" exceeds 10MB limit and will not be uploaded.`);
                                return;
                            }
                            
                            let fileIcon = 'fa-file';
                            let iconColor = 'text-gray-500';
                            
                            if (file.type.includes('image')) {
                                fileIcon = 'fa-file-image';
                                iconColor = 'text-green-500';
                            } else if (file.type.includes('pdf')) {
                                fileIcon = 'fa-file-pdf';
                                iconColor = 'text-red-500';
                            } else if (file.type.includes('word')) {
                                fileIcon = 'fa-file-word';
                                iconColor = 'text-blue-500';
                            } else if (file.type.includes('text') || file.name.endsWith('.log')) {
                                fileIcon = 'fa-file-alt';
                                iconColor = 'text-gray-600';
                            }
                            
                            let fileSize = file.size < 1024 * 1024 
                                ? (file.size / 1024).toFixed(1) + ' KB'
                                : (file.size / (1024 * 1024)).toFixed(2) + ' MB';
                            
                            const div = document.createElement('div');
                            div.className = 'flex items-center justify-between bg-gray-50 p-3 rounded-lg border border-gray-200 hover:bg-gray-100 transition';
                            div.innerHTML = `
                                <div class="flex items-center flex-1 min-w-0">
                                    <i class="fas ${fileIcon} ${iconColor} mr-3 text-lg"></i>
                                    <div class="text-left flex-1 min-w-0">
                                        <p class="text-sm font-medium text-gray-800 truncate max-w-xs" title="${file.name}">${file.name}</p>
                                        <p class="text-xs text-gray-500">${fileSize}</p>
                                    </div>
                                </div>
                                <button type="button" 
                                        class="remove-file ml-2 text-red-500 hover:text-red-700 p-1 hover:bg-red-50 rounded transition"
                                        data-index="${index}"
                                        title="Remove file">
                                    <i class="fas fa-times-circle"></i>
                                </button>
                            `;
                            fileList.appendChild(div);
                        });
                        
                        updateFileCount();
                    } else {
                        fileList.classList.add('hidden');
                    }
                });
                
                fileList.addEventListener('click', function(e) {
                    const removeBtn = e.target.closest('.remove-file');
                    if (removeBtn) {
                        e.preventDefault();
                        const index = parseInt(removeBtn.dataset.index);
                        const dt = new DataTransfer();
                        const files = Array.from(fileInput.files);
                        
                        files.splice(index, 1);
                        files.forEach(file => dt.items.add(file));
                        fileInput.files = dt.files;
                        
                        fileInput.dispatchEvent(new Event('change'));
                    }
                });
            }
            
            function updateFileCount() {
                if (!fileInput) return;
                
                const fileCount = fileInput.files.length;
                let fileCountBadge = document.getElementById('fileCountBadge');
                
                if (fileCount > 0) {
                    if (!fileCountBadge) {
                        fileCountBadge = document.createElement('span');
                        fileCountBadge.id = 'fileCountBadge';
                        fileCountBadge.className = 'ml-2 px-2 py-1 bg-primary text-white text-xs rounded-full';
                        fileInput.parentElement.appendChild(fileCountBadge);
                    }
                    fileCountBadge.textContent = fileCount + ' file' + (fileCount > 1 ? 's' : '');
                } else if (fileCountBadge) {
                    fileCountBadge.remove();
                }
            }
            
            // Drag and drop
            if (dropZone && fileInput) {
                ['dragenter', 'dragover', 'dragleave', 'drop'].forEach(eventName => {
                    dropZone.addEventListener(eventName, preventDefaults, false);
                });
                
                function preventDefaults(e) {
                    e.preventDefault();
                    e.stopPropagation();
                }
                
                ['dragenter', 'dragover'].forEach(eventName => {
                    dropZone.addEventListener(eventName, () => {
                        dropZone.classList.add('border-primary', 'bg-primary/5');
                    });
                });
                
                ['dragleave', 'drop'].forEach(eventName => {
                    dropZone.addEventListener(eventName, () => {
                        dropZone.classList.remove('border-primary', 'bg-primary/5');
                    });
                });
                
                dropZone.addEventListener('drop', function(e) {
                    const dt = e.dataTransfer;
                    const files = dt.files;
                    fileInput.files = files;
                    fileInput.dispatchEvent(new Event('change'));
                });
            }
            
            // Form submission with loading state
            const form = document.getElementById('ticketForm');
            
            if (form && submitBtn) {
                form.addEventListener('submit', function(e) {
                    if (!validateStep(3)) {
                        e.preventDefault();
                        
                        const missingFields = [];
                        if (requiredFields[3] && requiredFields[3].length > 0) {
                            requiredFields[3].forEach(fieldId => {
                                const field = document.getElementById(fieldId);
                                if (field && !field.value.trim()) {
                                    missingFields.push(fieldId);
                                }
                            });
                        }
                        
                        showValidationSummary(missingFields);
                        currentStep = 3;
                        showStep(3);
                        return;
                    }
                    
                    submitBtn.disabled = true;
                    submitBtn.innerHTML = `
                        <i class="fas fa-spinner fa-spin mr-2"></i>
                        Submitting...
                    `;
                    
                    const overlay = document.createElement('div');
                    overlay.id = 'loadingOverlay';
                    overlay.className = 'fixed inset-0 bg-gray-900 bg-opacity-50 flex items-center justify-center z-50';
                    overlay.innerHTML = `
                        <div class="bg-white rounded-2xl p-8 flex flex-col items-center shadow-2xl">
                            <div class="w-16 h-16 border-4 border-primary border-t-transparent rounded-full animate-spin"></div>
                            <p class="mt-4 text-gray-700 font-medium text-lg">Creating your ticket...</p>
                            <p class="text-sm text-gray-500 mt-2">Please wait</p>
                        </div>
                    `;
                    document.body.appendChild(overlay);
                });
            }
            
            // Mobile menu toggle
            const mobileMenuButton = document.getElementById('mobileMenuButton');
            const mobileMenu = document.getElementById('mobileMenu');
            
            if (mobileMenuButton && mobileMenu) {
                mobileMenuButton.addEventListener('click', function() {
                    mobileMenu.classList.toggle('hidden');
                });
            }
            
            // Initialize
            showStep(1);
            
            // Update summary when fields change
            ['subject', 'category', 'model', 'firmware_version', 'contact_name'].forEach(id => {
                const element = document.getElementById(id);
                if (element) {
                    element.addEventListener('input', updateSummary);
                }
            });
            
            document.querySelectorAll('input[name="priority"]').forEach(radio => {
                if (radio) {
                    radio.addEventListener('change', updateSummary);
                }
            });
            
            console.log('Wizard initialization complete');
        });
    </script>
</body>
</html>