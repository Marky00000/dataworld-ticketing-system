<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Ticket #{{ $ticket->ticket_number }} - Dataworld Support</title>
    <link rel="icon" type="image/png" href="{{ asset('images/logo.png') }}">
    
    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    
    <!-- Tailwind CSS -->
    <script src="https://cdn.tailwindcss.com"></script>
    
    <!-- Vue 3 -->
    <script src="https://cdn.jsdelivr.net/npm/vue@3.5.13/dist/vue.global.min.js"></script>
    
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
        /* Copy all your existing styles from create.blade.php */
        .sidebar { transition: all 0.3s ease; }
        .dashboard-card { transition: transform 0.3s ease, box-shadow 0.3s ease; }
        .dashboard-card:hover { transform: translateY(-5px); box-shadow: 0 20px 25px -5px rgba(0, 0, 0, 0.1), 0 10px 10px -5px rgba(0, 0, 0, 0.04); }
        .error-message { color: #ef4444; font-size: 0.75rem; margin-top: 0.25rem; }
        .is-invalid { border-color: #ef4444 !important; }
        .form-input:focus { border-color: #6366f1; box-shadow: 0 0 0 3px rgba(99, 102, 241, 0.1); }
        
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
        }
        
        .btn-next {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            color: white;
            margin-left: auto;
        }
        
        .btn-next:hover {
            transform: translateX(5px);
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
        }
        
        .btn-submit {
            background: linear-gradient(135deg, #10b981 0%, #059669 100%);
            color: white;
            margin-left: auto;
        }
        
        .btn-submit:hover {
            transform: scale(1.05);
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
        }
        
        .validation-item {
            display: flex;
            align-items: center;
            gap: 0.75rem;
            color: #dc2626;
            font-size: 0.875rem;
            padding: 0.5rem 0;
        }
        
        .priority-card {
            transition: all 0.3s ease;
            cursor: pointer;
        }
        
        .priority-card:hover {
            transform: translateY(-2px);
        }
        
        .gradient-text {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            background-clip: text;
        }
        
        .breadcrumb-hover {
            transition: color 0.2s ease;
        }
        
        .file-drop-zone {
            transition: all 0.3s ease;
        }
        
        .file-drop-zone:hover {
            border-color: #6366f1;
            background: #e0e7ff;
        }
        
        /* Mobile menu transitions */
        .mobile-menu-enter-active,
        .mobile-menu-leave-active {
            transition: all 0.3s ease;
        }
        
        .mobile-menu-enter-from,
        .mobile-menu-leave-to {
            opacity: 0;
            transform: translateY(-10px);
        }
        
        .mobile-menu-enter-to,
        .mobile-menu-leave-from {
            opacity: 1;
            transform: translateY(0);
        }

        /* Existing attachments */
        .existing-attachment {
            transition: all 0.2s ease;
        }
        
        .existing-attachment:hover {
            transform: translateY(-2px);
            box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.1);
        }
        
        .delete-attachment {
            transition: all 0.2s ease;
        }
        
        .delete-attachment:hover {
            background: #ef4444;
            color: white;
        }
    </style>
</head>
<body class="bg-gradient-to-br from-gray-50 to-gray-100 min-h-screen">

<div id="app" class="min-h-screen flex flex-col">
    
    <!-- Top Navigation Bar - Same as create.blade.php -->
    <nav class="bg-white/80 backdrop-blur-md shadow-lg border-b border-primary/10 sticky top-0 z-50 transition-all duration-300" 
     :class="{ 'shadow-xl bg-white/95': scrolled }">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex justify-between h-16">
            <!-- Logo with modern typography -->
            <div class="flex items-center">
                <a href="/dashboard" class="flex items-center space-x-2 group">
                    <img src="{{ asset('images/logo.png') }}" alt="Dataworld Logo" 
                         class="h-8 w-auto transform group-hover:scale-110 transition-transform duration-300">
                    <div class="flex flex-col">
                        <span class="text-xs font-light tracking-wider text-gray-600 group-hover:text-primary transition-colors duration-300 uppercase">
                            Dataworld
                        </span>
                        <span class="text-[10px] font-light tracking-wide text-gray-400 group-hover:text-primary/70 transition-colors duration-300 uppercase">
                            Computer Center
                        </span>
                    </div>
                </a>
            </div>
            
            <!-- Desktop Navigation -->
            <div class="hidden md:flex items-center space-x-6">
                <!-- Dashboard Link -->
                <a href="/dashboard" 
                   class="{{ request()->is('dashboard') ? 'text-primary' : 'text-gray-600 hover:text-primary' }} transition-all duration-300 flex items-center space-x-3 relative group py-2">
                    <div class="w-8 h-8 rounded-lg {{ request()->is('dashboard') ? 'bg-primary/10' : 'bg-gray-100 group-hover:bg-primary/10' }} flex items-center justify-center transition-colors duration-300">
                        <i class="fas fa-home text-sm {{ request()->is('dashboard') ? 'text-primary' : 'text-gray-500 group-hover:text-primary' }}"></i>
                    </div>
                    <span class="text-sm font-medium">Dashboard</span>
                </a>

                <!-- My Tickets Link -->
                <a href="/tickets" 
                   class="{{ request()->is('tickets') || request()->is('tickets/*') ? 'text-primary' : 'text-gray-600 hover:text-primary' }} transition-all duration-300 flex items-center space-x-3 relative group py-2">
                    <div class="w-8 h-8 rounded-lg {{ request()->is('tickets') || request()->is('tickets/*') ? 'bg-primary/10' : 'bg-gray-100 group-hover:bg-primary/10' }} flex items-center justify-center transition-colors duration-300">
                        <i class="fas fa-ticket-alt text-sm {{ request()->is('tickets') || request()->is('tickets/*') ? 'text-primary' : 'text-gray-500 group-hover:text-primary' }}"></i>
                    </div>
                    <span class="text-sm font-medium">My Tickets</span>
                </a>

                <!-- New Ticket Button with shine effect -->
                <a href="/tickets/create" 
                   class="relative overflow-hidden group bg-gradient-to-r from-primary to-primaryDark text-white px-5 py-2.5 rounded-full text-sm font-medium hover:shadow-lg hover:shadow-primary/30 transition-all duration-300 flex items-center space-x-2">
                    <span>New Ticket</span>
                    <div class="absolute inset-0 bg-white/20 transform -skew-x-12 -translate-x-full group-hover:translate-x-full transition-transform duration-700"></div>
                </a>

                <!-- Divider -->
                <div class="h-8 w-0.5 bg-gradient-to-b from-transparent via-gray-400 to-transparent"></div>

                <!-- User Dropdown with Profile Image -->
                <div class="relative group">
                    <button class="flex items-center space-x-3 focus:outline-none group cursor-pointer py-2">
                        <div class="flex items-center space-x-3">
                            <!-- Profile Image instead of icon -->
                            <div class="relative">
                                <img src="{{ asset('images/profile.png') }}" 
                                     alt="{{ auth()->user()->name }}" 
                                     class="w-10 h-10 rounded-full object-cover border-2 border-transparent group-hover:border-primary transition-all duration-200 shadow-md group-hover:shadow-lg">
                                <!-- Online status indicator -->
                                <span class="absolute -bottom-1 -right-1 w-3 h-3 bg-green-500 rounded-full border-2 border-white"></span>
                            </div>
                            <div class="text-left hidden lg:block">
                                <p class="text-sm font-medium text-gray-900">{{ auth()->user()->name }}</p>
                            </div>
                        </div>
                        <i class="fas fa-chevron-down text-gray-400 text-sm transition-transform duration-300 group-hover:rotate-180"></i>
                    </button>
                    
                    <!-- Dropdown Menu -->
                    <div class="absolute right-0 mt-2 w-64 bg-white rounded-xl shadow-xl py-3 z-50 opacity-0 invisible group-hover:opacity-100 group-hover:visible transition-all duration-300 border border-gray-200 transform origin-top-right scale-95 group-hover:scale-100">
                        
                        <!-- User info header with profile image -->
                        <div class="px-5 py-3 flex items-center space-x-3">
                            <img src="{{ asset('images/profile.png') }}" 
                                 alt="{{ auth()->user()->name }}" 
                                 class="w-12 h-12 rounded-full object-cover border-2 border-primary shadow-md">
                            <div>
                                <p class="text-sm font-semibold text-gray-900">{{ auth()->user()->name }}</p>
                                <p class="text-xs text-gray-500 mt-0.5">{{ auth()->user()->email }}</p>
                            </div>
                        </div>
                        <div class="px-5 pb-2">
                            <span class="inline-flex items-center px-2.5 py-1 rounded-md text-xs font-medium text-blue-700">
                                @if(auth()->user()->user_type === 'admin')
                                    <i class="fas fa-crown mr-1.5 text-xs text-blue-600"></i>
                                @elseif(auth()->user()->user_type === 'tech')
                                    <i class="fas fa-tools mr-1.5 text-xs text-blue-600"></i>
                                @else
                                    <i class="fas fa-user mr-1.5 text-xs text-blue-600"></i>
                                @endif
                                @if(auth()->user()->user_type === 'admin')
                                    Administrator Account
                                @elseif(auth()->user()->user_type === 'tech')
                                    Technician Account
                                @else
                                    Client Account
                                @endif
                            </span>
                        </div>
                        
                        <!-- Menu items -->
                        <div class="border-t border-gray-100 my-1"></div>
                        
                        <a href="{{ route('profile.dashboard') }}" 
                           class="flex items-center px-5 py-3 text-sm text-gray-700 hover:bg-gray-50 transition-all duration-200">
                            <i class="fas fa-user-circle w-5 text-gray-500 mr-3"></i>
                            <span class="flex-1">My Profile</span>
                        </a>

                        @if(auth()->user()->user_type === 'admin')
                        <a href="{{ route('admin.tech.create') }}" 
                           class="flex items-center px-5 py-3 text-sm text-gray-700 hover:bg-gray-50 transition-all duration-200">
                            <i class="fas fa-user-plus w-5 text-gray-500 mr-3"></i>
                            <span class="flex-1">Create Tech Account</span>
                        </a>
                        @endif
                        
                        <!-- Sign Out Form -->
                        <form method="POST" action="{{ route('sign-out') }}">
                            @csrf
                            <button type="submit" 
                                    class="flex items-center px-5 py-3 text-sm text-red-600 hover:bg-red-50 transition-all duration-200 w-full text-left border-t border-gray-100 mt-1">
                                <i class="fas fa-sign-out-alt w-5 text-red-500 mr-3"></i>
                                <span class="flex-1">Sign Out</span>
                            </button>
                        </form>
                    </div>
                </div>
            </div>
            
            <!-- Mobile menu button with Vue -->
            <div class="md:hidden flex items-center">
                <button @click="mobileMenuOpen = !mobileMenuOpen" 
                        class="relative w-10 h-10 flex items-center justify-center text-gray-600 hover:text-primary focus:outline-none transition-colors duration-200"
                        :class="{ 'text-primary': mobileMenuOpen }"
                        aria-label="Toggle menu">
                    <i :class="mobileMenuOpen ? 'fas fa-times text-xl' : 'fas fa-bars text-xl'"></i>
                </button>
            </div>
        </div>
    </div>
    
    <!-- Mobile Menu - Modern Design -->
    <transition name="mobile-menu">
        <div v-if="mobileMenuOpen" 
             class="md:hidden bg-white/95 backdrop-blur-md border-t border-primary/10 absolute left-0 right-0 top-full shadow-xl z-40"
             style="max-height: calc(100vh - 64px); overflow-y: auto;">
            
            <div class="px-4 py-4 space-y-3">
                <!-- User Profile Header with Profile Image -->
                <div class="flex items-center space-x-4 px-3 py-4 bg-gradient-to-r from-primary/5 to-transparent rounded-xl border border-primary/10">
                    <div class="relative">
                    </div>
                    <div class="flex-1">
                        <p class="text-base font-bold text-gray-900">{{ auth()->user()->name }}</p>
                        <p class="text-xs text-gray-500">{{ auth()->user()->email }}</p>
                       
                    </div>
                     <div class="flex items-center mt-1 space-x-2">
                            <span class="inline-flex items-center px-2 py-0.5 rounded-full text-xs font-medium 
                                 @if(auth()->user()->user_type === 'admin') bg-blue-100 text-blue-700 
                                    <i class="fas fa-crown mr-1.5 text-xs text-blue-600"></i>
                                    @elseif(auth()->user()->user_type === 'tech') bg-blue-100 text-blue-700                 
                                        <i class="fas fa-tools mr-1.5 text-xs text-blue-600"></i>
                                    @else
                                        <i class="fas fa-user mr-1.5 text-xs text-blue-600"></i>
                                    @endif
                                    @if(auth()->user()->user_type === 'admin')
                                        Administrator Account
                                    @elseif(auth()->user()->user_type === 'tech')
                                        Technician Account
                                    @else
                                        Client Account
                                    @endif
                            </span>
                        </div>
                </div>
                
                <!-- Navigation Items -->
                <a href="/dashboard" @click="mobileMenuOpen = false"
                   class="flex items-center space-x-3 px-4 py-3 {{ request()->is('dashboard') ? 'text-primary bg-primary/5 border border-primary/20' : 'text-gray-700 hover:bg-gray-50' }} rounded-xl transition-all duration-300 group">
                    <div class="w-10 h-10 {{ request()->is('dashboard') ? 'bg-primary/10' : 'bg-gray-100 group-hover:bg-primary/10' }} rounded-xl flex items-center justify-center transition-colors">
                        <i class="fas fa-home {{ request()->is('dashboard') ? 'text-primary' : 'text-gray-500 group-hover:text-primary' }}"></i>
                    </div>
                    <div class="flex-1">
                        <p class="font-medium {{ request()->is('dashboard') ? 'text-primary' : 'text-gray-900' }}">Dashboard</p>
                        <p class="text-xs text-gray-500">Overview & statistics</p>
                    </div>
                </a>
                
                <a href="/tickets" @click="mobileMenuOpen = false"
                   class="flex items-center space-x-3 px-4 py-3 {{ request()->is('tickets') || request()->is('tickets/*') ? 'text-primary bg-primary/5 border border-primary/20' : 'text-gray-700 hover:bg-gray-50' }} rounded-xl transition-all duration-300 group">
                    <div class="w-10 h-10 {{ request()->is('tickets') || request()->is('tickets/*') ? 'bg-primary/10' : 'bg-gray-100 group-hover:bg-primary/10' }} rounded-xl flex items-center justify-center transition-colors">
                        <i class="fas fa-ticket-alt {{ request()->is('tickets') || request()->is('tickets/*') ? 'text-primary' : 'text-gray-500 group-hover:text-primary' }}"></i>
                    </div>
                    <div class="flex-1">
                        <p class="font-medium {{ request()->is('tickets') || request()->is('tickets/*') ? 'text-primary' : 'text-gray-900' }}">My Tickets</p>
                        <p class="text-xs text-gray-500">View your support tickets</p>
                    </div>
                </a>
                
                <a href="/tickets/create" @click="mobileMenuOpen = false"
                   class="flex items-center space-x-3 px-4 py-3 {{ request()->is('tickets/create') ? 'text-primary bg-primary/5 border border-primary/20' : 'text-gray-700 hover:bg-gray-50' }} rounded-xl transition-all duration-300 group">
                    <div class="w-10 h-10 {{ request()->is('tickets/create') ? 'bg-primary/10' : 'bg-gray-100 group-hover:bg-primary/10' }} rounded-xl flex items-center justify-center transition-colors">
                        <i class="fas fa-plus-circle {{ request()->is('tickets/create') ? 'text-primary' : 'text-gray-500 group-hover:text-primary' }}"></i>
                    </div>
                    <div class="flex-1">
                        <p class="font-medium {{ request()->is('tickets/create') ? 'text-primary' : 'text-gray-900' }}">New Ticket</p>
                        <p class="text-xs text-gray-500">Create a support request</p>
                    </div>
                </a>
                
                @if(auth()->user()->user_type === 'admin')
                <div class="border-t border-gray-200 pt-4 mt-2">
                    <a href="{{ route('admin.tech.create') }}" @click="mobileMenuOpen = false"
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
                
                <!-- Profile & Sign Out -->
                <a href="{{ route('profile.dashboard') }}" @click="mobileMenuOpen = false"
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
    </transition>
</nav>

    <!-- Main Content -->
    <main class="flex-1">
        <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
            <!-- Header with Breadcrumb -->
            <div class="mb-8">
                <div class="flex items-center text-sm text-gray-500 mb-4 bg-white/80 backdrop-blur-sm px-4 py-2 rounded-full shadow-sm inline-flex">
                    <a href="/dashboard" class="hover:text-primary">Dashboard</a>
                    <i class="fas fa-chevron-right mx-3 text-xs"></i>
                    <a href="/tickets" class="hover:text-primary">My Tickets</a>
                    <i class="fas fa-chevron-right mx-3 text-xs"></i>
                    <a href="{{ route('tickets.my_tickets_view', $ticket->id) }}" class="hover:text-primary">#{{ $ticket->ticket_number }}</a>
                    <i class="fas fa-chevron-right mx-3 text-xs"></i>
                    <span class="text-primary font-medium">Edit</span>
                </div>
                
                <div class="flex items-center justify-between">
                    <div>
                        <h1 class="text-3xl md:text-4xl font-bold gradient-text">Edit Ticket #{{ $ticket->ticket_number }}</h1>
                        <p class="text-gray-600 mt-2">Update your support request details.</p>
                    </div>
                </div>
            </div>

            <!-- Validation Summary -->
            <div id="validationSummary" class="validation-summary">
                <div class="flex items-center gap-2 mb-2">
                    <div class="w-8 h-8 bg-red-100 rounded-full flex items-center justify-center">
                        <i class="fas fa-exclamation-circle text-red-600"></i>
                    </div>
                    <span class="font-medium text-red-800">Please complete all required fields:</span>
                </div>
                <div id="validationList" class="space-y-1 ml-10"></div>
            </div>

            <!-- Form -->
            <div class="bg-white/80 backdrop-blur-sm rounded-2xl shadow-xl p-8 border border-gray-100">
                <!-- Step Indicator -->
                <div class="step-indicator flex justify-between items-center mb-6 relative">
                    <div class="absolute top-1/2 left-0 w-full h-0.5 bg-gray-200 -translate-y-1/2 z-0"></div>
                    
                    <div class="step active relative z-10" data-step="1">
                        <span class="step-number">1</span>
                        <span class="hidden sm:inline ml-2">Ticket Details</span>
                    </div>
                    
                    <div class="step relative z-10" data-step="2">
                        <span class="step-number">2</span>
                        <span class="hidden sm:inline ml-2">Device Info</span>
                    </div>
                    
                    <div class="step relative z-10" data-step="3">
                        <span class="step-number">3</span>
                        <span class="hidden sm:inline ml-2">Review & Update</span>
                    </div>
                </div>

                <form action="{{ route('tickets.update', $ticket->id) }}" method="POST" enctype="multipart/form-data" id="ticketForm">
                    @csrf
                    @method('PUT')
                    
                    <!-- Step 1: Ticket Details - PRE-FILLED WITH TICKET DATA -->
                    <div class="form-step active-step" id="step1">
                        <div class="space-y-6">
                            <!-- Subject -->
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-2">
                                    <div class="flex items-center">
                                        <div class="w-6 h-6 bg-primary/10 rounded-full flex items-center justify-center mr-2">
                                            <i class="fas fa-heading text-primary text-xs"></i>
                                        </div>
                                        Subject <span class="text-red-500">*</span>
                                    </div>
                                </label>
                                <input type="text" name="subject" id="subject" value="{{ old('subject', $ticket->subject) }}" required
                                       class="w-full px-4 py-3 border border-gray-200 rounded-xl focus:outline-none focus:ring-2 focus:ring-primary/20 @error('subject') is-invalid @enderror">
                                @error('subject')<p class="error-message">{{ $message }}</p>@enderror
                            </div>

                            <!-- Category -->
                            <div>
                                <div class="flex items-center mb-2">
                                    <div class="w-6 h-6 bg-primary/10 rounded-full flex items-center justify-center mr-2">
                                        <i class="fas fa-folder text-primary text-xs"></i>
                                    </div>
                                    <label class="block text-sm font-medium text-gray-700">Category <span class="text-red-500">*</span></label>
                                </div>
                                <select name="category" id="category" required class="w-full px-4 py-3 border border-gray-200 rounded-xl">
                                    <option value="">Select a category</option>
                                    @foreach($categories as $category)
                                        <option value="{{ $category->id }}" {{ old('category', $ticket->category_id) == $category->id ? 'selected' : '' }}>
                                            {{ $category->name }}
                                        </option>
                                    @endforeach
                                </select>
                                @error('category')<p class="error-message">{{ $message }}</p>@enderror
                            </div>

                            <!-- Priority -->
                            <div>
                                <div class="flex items-center mb-3">
                                    <div class="w-6 h-6 bg-primary/10 rounded-full flex items-center justify-center mr-2">
                                        <i class="fas fa-flag text-primary text-xs"></i>
                                    </div>
                                    <label class="block text-sm font-medium text-gray-700">Priority <span class="text-red-500">*</span></label>
                                </div>
                                <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                                    <label class="priority-card">
                                        <input type="radio" name="priority" value="low" class="sr-only peer" 
                                               {{ old('priority', $ticket->priority) == 'low' ? 'checked' : '' }}>
                                        <div class="p-4 border-2 border-gray-200 rounded-xl peer-checked:border-green-500 peer-checked:bg-green-50">
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
                                    
                                    <label class="priority-card">
                                        <input type="radio" name="priority" value="medium" class="sr-only peer"
                                               {{ old('priority', $ticket->priority) == 'medium' ? 'checked' : '' }}>
                                        <div class="p-4 border-2 border-gray-200 rounded-xl peer-checked:border-yellow-500 peer-checked:bg-yellow-50">
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
                                    
                                    <label class="priority-card">
                                        <input type="radio" name="priority" value="high" class="sr-only peer"
                                               {{ old('priority', $ticket->priority) == 'high' ? 'checked' : '' }}>
                                        <div class="p-4 border-2 border-gray-200 rounded-xl peer-checked:border-red-500 peer-checked:bg-red-50">
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
                                @error('priority')<p class="error-message">{{ $message }}</p>@enderror
                            </div>

                            <!-- Description -->
                            <div>
                                <div class="flex items-center mb-2">
                                    <div class="w-6 h-6 bg-primary/10 rounded-full flex items-center justify-center mr-2">
                                        <i class="fas fa-align-left text-primary text-xs"></i>
                                    </div>
                                    <label class="block text-sm font-medium text-gray-700">Description <span class="text-red-500">*</span></label>
                                </div>
                                <textarea name="description" id="description" rows="6" required 
                                          class="w-full px-4 py-3 border border-gray-200 rounded-xl">{{ old('description', $ticket->description) }}</textarea>
                                <div class="flex justify-between text-xs text-gray-500 mt-2">
                                    <span class="flex items-center"><i class="fas fa-info-circle text-primary mr-1"></i>Be as detailed as possible</span>
                                    <span id="charCount" class="bg-primary/10 text-primary px-3 py-1 rounded-full font-medium">{{ strlen(old('description', $ticket->description)) }}/5000</span>
                                </div>
                                @error('description')<p class="error-message">{{ $message }}</p>@enderror
                            </div>
                        </div>
                    </div>

                    <!-- Step 2: Device Information and Attachments -->
                    <div class="form-step" id="step2">
                        <div class="bg-gradient-to-br from-primary/5 to-indigo-500/5 rounded-xl p-6 border border-primary/10">
                            <h3 class="text-lg font-semibold text-gray-800 mb-4 flex items-center">
                                <div class="w-8 h-8 bg-primary/20 rounded-full flex items-center justify-center mr-3">
                                    <i class="fas fa-microchip text-primary"></i>
                                </div>
                                Device Information
                            </h3>
                            
                            <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                                <div>
                                    <label class="block text-sm font-medium text-gray-700 mb-2">Model</label>
                                    <input type="text" name="model" id="model" value="{{ old('model', $ticket->model) }}"
                                           class="w-full px-4 py-3 border border-gray-200 rounded-xl"
                                           placeholder="e.g., RT-AC68U">
                                </div>
                                
                                <div>
                                    <label class="block text-sm font-medium text-gray-700 mb-2">Firmware Version</label>
                                    <input type="text" name="firmware_version" id="firmware_version" value="{{ old('firmware_version', $ticket->firmware_version) }}"
                                           class="w-full px-4 py-3 border border-gray-200 rounded-xl"
                                           placeholder="e.g., 3.0.0.4.386_48247">
                                </div>
                                
                                <div>
                                    <label class="block text-sm font-medium text-gray-700 mb-2">Serial Number</label>
                                    <input type="text" name="serial_number" id="serial_number" value="{{ old('serial_number', $ticket->serial_number) }}"
                                           class="w-full px-4 py-3 border border-gray-200 rounded-xl"
                                           placeholder="e.g., ABC12345678">
                                </div>
                            </div>
                        </div>

                        <!-- Attachments Section with Existing Files -->
                        <div class="mt-8">
                            <div class="flex items-center mb-3">
                                <div class="w-6 h-6 bg-primary/10 rounded-full flex items-center justify-center mr-2">
                                    <i class="fas fa-paperclip text-primary text-xs"></i>
                                </div>
                                <label class="block text-sm font-medium text-gray-700">Attachments</label>
                            </div>
                            
                            <!-- Existing Attachments -->
                            <!-- Existing Attachments -->
@if($ticket->attachments)
    @php 
        $attachmentsArray = json_decode($ticket->attachments, true) ?: []; 
    @endphp
    @if(!empty($attachmentsArray) && count($attachmentsArray) > 0)
        <div class="mb-6">
            <h4 class="text-xs font-medium text-gray-600 mb-3 flex items-center bg-gray-50 px-3 py-2 rounded-lg">
                <i class="fas fa-paperclip text-primary mr-2"></i>
                Current Attachments ({{ count($attachmentsArray) }})
            </h4>
            <div class="grid grid-cols-2 sm:grid-cols-4 gap-4">
                @foreach($attachmentsArray as $index => $attachment)
                    @if(is_array($attachment) && isset($attachment['path']))
                    <div class="existing-attachment relative bg-gray-50 rounded-lg border border-gray-200 p-3" id="attachment-{{ $index }}" data-path="{{ $attachment['path'] }}">
                        <div class="flex flex-col items-center">
                            @php
                                $fileExtension = pathinfo($attachment['path'], PATHINFO_EXTENSION);
                                $imageExtensions = ['jpg', 'jpeg', 'png', 'gif', 'bmp', 'webp', 'svg', 'JPG', 'JPEG', 'PNG', 'GIF'];
                                $isImage = in_array($fileExtension, $imageExtensions);
                                
                                if(!$isImage && isset($attachment['type'])) {
                                    $isImage = str_contains(strtolower($attachment['type']), 'image');
                                }
                            @endphp
                            
                            @if($isImage)
                                <img src="{{ asset('storage/' . $attachment['path']) }}" 
                                     alt="{{ $attachment['name'] ?? 'Attachment' }}" 
                                     class="w-16 h-16 object-cover rounded-lg mb-2"
                                     onerror="this.onerror=null; this.src='{{ asset('images/file-placeholder.png') }}';">
                            @else
                                <div class="w-16 h-16 bg-gray-200 rounded-lg flex items-center justify-center mb-2">
                                    @php
                                        $ext = strtolower(pathinfo($attachment['name'] ?? $attachment['path'], PATHINFO_EXTENSION));
                                    @endphp
                                    @if($ext == 'pdf' || (isset($attachment['type']) && str_contains($attachment['type'] ?? '', 'pdf')))
                                        <i class="fas fa-file-pdf text-red-500 text-2xl"></i>
                                    @elseif(in_array($ext, ['doc', 'docx']) || (isset($attachment['type']) && str_contains($attachment['type'] ?? '', 'word')))
                                        <i class="fas fa-file-word text-blue-500 text-2xl"></i>
                                    @elseif(in_array($ext, ['txt', 'log']) || (isset($attachment['type']) && str_contains($attachment['type'] ?? '', 'text')))
                                        <i class="fas fa-file-alt text-gray-500 text-2xl"></i>
                                    @else
                                        <i class="fas fa-file text-gray-500 text-2xl"></i>
                                    @endif
                                </div>
                            @endif
                            <p class="text-xs text-gray-600 text-center truncate w-full" title="{{ $attachment['name'] ?? basename($attachment['path']) }}">
                                {{ $attachment['name'] ?? basename($attachment['path']) }}
                            </p>
                            <div class="absolute top-1 right-1">
                                <button type="button" 
                                        class="delete-attachment w-6 h-6 bg-red-100 rounded-full flex items-center justify-center text-red-600 hover:bg-red-600 hover:text-white transition"
                                        onclick="markForDeletion(this, {{ $index }}, '{{ $attachment['name'] ?? basename($attachment['path']) }}', '{{ $attachment['path'] }}')"
                                        title="Remove attachment">
                                    <i class="fas fa-times text-xs"></i>
                                </button>
                            </div>
                        </div>
                    </div>
                    @endif
                @endforeach
            </div>
            <p class="text-xs text-gray-500 mt-2 flex items-center">
                <i class="fas fa-info-circle text-primary mr-1"></i>
                Click the <span class="text-red-600">X</span> button to mark attachments for removal
            </p>
            
            <!-- Container for deleted attachments markers -->
            <div id="deletedAttachmentsContainer" class="mt-2 hidden">
                <h5 class="text-xs font-medium text-red-600 mb-1">Files marked for deletion:</h5>
                <div id="deletedAttachmentsList" class="space-y-1"></div>
            </div>
        </div>
    @endif
@endif

                            <!-- New Attachments Upload -->
                            <div class="border-2 border-dashed border-gray-300 rounded-xl p-8 text-center hover:border-primary hover:bg-primary/5 transition-all cursor-pointer file-drop-zone" id="dropZone">
                                <div class="flex flex-col items-center">
                                    <div class="w-20 h-20 bg-primary/10 rounded-full flex items-center justify-center mb-4">
                                        <i class="fas fa-cloud-upload-alt text-primary text-3xl"></i>
                                    </div>
                                    <p class="text-sm text-gray-700 mb-1 font-medium">Drag and drop new files here, or click to browse</p>
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
                            
                            <!-- New Files List -->
                            <div id="fileList" class="mt-4 space-y-2 hidden">
                                <h4 class="text-xs font-medium text-gray-700 mb-2 flex items-center bg-gray-50 px-3 py-2 rounded-lg">
                                    <i class="fas fa-paperclip text-primary mr-2"></i>
                                    New Files to Upload
                                </h4>
                                <!-- New files will be listed here -->
                            </div>
                            
                            <!-- Hidden input to track deleted attachments -->
                            <input type="hidden" name="remove_attachments[]" id="removeAttachments" value="">
                            
                            @error('attachments.*')
                                <p class="error-message">{{ $message }}</p>
                            @enderror
                        </div>
                    </div>

                    <!-- Step 3: Review & Update -->
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
                                
                                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                                    <div>
                                        <label class="block text-sm font-medium text-gray-700 mb-2">Full Name <span class="text-red-500">*</span></label>
                                        <input type="text" name="contact_name" id="contact_name" 
                                               value="{{ old('contact_name', $ticket->contact_name ?? auth()->user()->name) }}"
                                               class="w-full px-4 py-3 border border-gray-200 rounded-xl">
                                        @error('contact_name')<p class="error-message">{{ $message }}</p>@enderror
                                    </div>
                                    
                                    <div>
                                        <label class="block text-sm font-medium text-gray-700 mb-2">Email <span class="text-red-500">*</span></label>
                                        <input type="email" name="contact_email" id="contact_email" 
                                               value="{{ old('contact_email', $ticket->contact_email ?? auth()->user()->email) }}"
                                               class="w-full px-4 py-3 border border-gray-200 rounded-xl">
                                        @error('contact_email')<p class="error-message">{{ $message }}</p>@enderror
                                    </div>
                                    
                                    <div>
                                        <label class="block text-sm font-medium text-gray-700 mb-2">Phone</label>
                                        <input type="text" name="contact_phone" id="contact_phone" 
                                               value="{{ old('contact_phone', $ticket->contact_phone ?? auth()->user()->phone) }}"
                                               class="w-full px-4 py-3 border border-gray-200 rounded-xl">
                                    </div>
                                    
                                    <div>
                                        <label class="block text-sm font-medium text-gray-700 mb-2">Company</label>
                                        <input type="text" name="contact_company" id="contact_company" 
                                               value="{{ old('contact_company', $ticket->contact_company ?? auth()->user()->company) }}"
                                               class="w-full px-4 py-3 border border-gray-200 rounded-xl">
                                    </div>
                                </div>
                            </div>

                            <!-- Summary Card -->
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
            <span class="font-medium" id="summarySubject">{{ $ticket->subject }}</span>
        </div>
        <div class="flex justify-between py-2 border-b border-gray-200">
            <span class="text-gray-600">Category:</span>
            <span class="font-medium" id="summaryCategory">{{ $ticket->category->name ?? 'Uncategorized' }}</span>
        </div>
        <div class="flex justify-between py-2 border-b border-gray-200">
            <span class="text-gray-600">Priority:</span>
            <span class="font-medium" id="summaryPriority">{{ ucfirst($ticket->priority) }}</span>
        </div>
        <div class="flex justify-between py-2 border-b border-gray-200">
            <span class="text-gray-600">Device Model:</span>
            <span class="font-medium" id="summaryModel">{{ $ticket->model ?? '-' }}</span>
        </div>
        <div class="flex justify-between py-2 border-b border-gray-200">
            <span class="text-gray-600">Contact:</span>
            <span class="font-medium" id="summaryContact">{{ $ticket->contact_name ?? auth()->user()->name }}</span>
        </div>
        <div class="flex justify-between py-2">
            <span class="text-gray-600">Attachments:</span>
            <span class="font-medium" id="summaryAttachments">
                @php 
                    $attachments = $ticket->attachments ? json_decode($ticket->attachments, true) : [];
                    $existingCount = is_array($attachments) ? count($attachments) : 0;
                @endphp
                <span id="existingAttachmentsCount">{{ $existingCount }}</span> existing + <span id="newAttachmentsCount">0</span> new
                (<span id="keptAttachmentsCount">{{ $existingCount }}</span> kept, <span id="deletedAttachmentsCount" class="text-red-600">0</span> removed)
            </span>
        </div>
    </div>
</div>
                        </div>
                    </div>

                    <!-- Navigation Buttons -->
                    <div class="nav-buttons">
                        <button type="button" class="btn-prev" id="prevBtn" style="visibility: hidden;">
                            <i class="fas fa-arrow-left"></i> Previous
                        </button>
                        <button type="button" class="btn-next" id="nextBtn">
                            Next <i class="fas fa-arrow-right"></i>
                        </button>
                        <button type="submit" class="btn-submit" id="submitBtn" style="display: none;">
                            <i class="fas fa-check-circle"></i> Update Ticket
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </main>

    <!-- Footer -->
    <footer class="bg-gray-900 text-gray-400 py-8">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="text-center text-sm">
                <p>© {{ date('Y') }} Dataworld Computer Center. All rights reserved.</p>
            </div>
        </div>
    </footer>
</div>

<!-- Vue for Navbar -->
<script>
    const { createApp } = Vue;
    createApp({
        data() { return { mobileMenuOpen: false, scrolled: false } },
        mounted() { window.addEventListener('scroll', () => { this.scrolled = window.scrollY > 20; }); },
        methods: { toggleMenu() { this.mobileMenuOpen = !this.mobileMenuOpen; } }
    }).mount('#app');
</script>

<!-- Step Wizard and Attachment Management JavaScript -->
<script>
    document.addEventListener('DOMContentLoaded', function() {
        // Step wizard functionality
        let currentStep = 1;
        const totalSteps = 3;
        const steps = document.querySelectorAll('.step');
        const formSteps = document.querySelectorAll('.form-step');
        const prevBtn = document.getElementById('prevBtn');
        const nextBtn = document.getElementById('nextBtn');
        const submitBtn = document.getElementById('submitBtn');

        // Attachment management
            let deletedAttachments = [];
            let deletedAttachmentPaths = [];
            let deletedAttachmentNames = [];
            const authUserName = "{{ auth()->user()->name }}";
            const attachmentsJson = @json($ticket->attachments);
            const attachmentsArray = attachmentsJson ? JSON.parse(attachmentsJson) : [];
            const existingAttachmentsCount = Array.isArray(attachmentsArray) ? attachmentsArray.length : 0;

        function showStep(step) {
            formSteps.forEach((fs, i) => {
                fs.classList.toggle('active-step', i + 1 === step);
            });
            
            steps.forEach((s, i) => {
                s.classList.toggle('active', i + 1 === step);
                s.classList.toggle('completed', i + 1 < step);
            });

            prevBtn.style.visibility = step === 1 ? 'hidden' : 'visible';
            
            if (step === totalSteps) {
                nextBtn.style.display = 'none';
                submitBtn.style.display = 'flex';
                updateSummary();
            } else {
                nextBtn.style.display = 'flex';
                submitBtn.style.display = 'none';
            }
        }

        // Attachment deletion function
        window.markForDeletion = function(button, index, fileName, filePath) {
            const attachmentDiv = document.getElementById(`attachment-${index}`);
            
            if (!attachmentDiv) return;
            
            const pathIndex = deletedAttachmentPaths.indexOf(filePath);
            
            if (pathIndex !== -1) {
                // Undo deletion
                deletedAttachmentPaths.splice(pathIndex, 1);
                
                const nameIndex = deletedAttachmentNames.indexOf(fileName);
                if (nameIndex !== -1) deletedAttachmentNames.splice(nameIndex, 1);
                
                attachmentDiv.classList.remove('opacity-50', 'bg-red-50', 'border-red-300');
                attachmentDiv.classList.add('bg-gray-50', 'border-gray-200');
                button.classList.remove('bg-red-600', 'text-white');
                button.classList.add('bg-red-100', 'text-red-600');
                button.innerHTML = '<i class="fas fa-times text-xs"></i>';
                button.title = 'Remove attachment';
                
                const deletedItem = document.getElementById(`deleted-item-${index}`);
                if (deletedItem) deletedItem.remove();
            } else {
                // Mark for deletion
                deletedAttachmentPaths.push(filePath);
                deletedAttachmentNames.push(fileName);
                
                attachmentDiv.classList.add('opacity-50', 'bg-red-50', 'border-red-300');
                attachmentDiv.classList.remove('bg-gray-50', 'border-gray-200');
                button.classList.remove('bg-red-100', 'text-red-600');
                button.classList.add('bg-red-600', 'text-white');
                button.innerHTML = '<i class="fas fa-undo text-xs"></i>';
                button.title = 'Undo removal';
                
                const deletedList = document.getElementById('deletedAttachmentsList');
                const deletedContainer = document.getElementById('deletedAttachmentsContainer');
                
                if (deletedList && deletedContainer) {
                    const deletedItem = document.createElement('div');
                    deletedItem.id = `deleted-item-${index}`;
                    deletedItem.className = 'flex items-center justify-between bg-red-50 p-2 rounded-lg border border-red-200 text-xs mb-1';
                    deletedItem.innerHTML = `
                        <div class="flex items-center flex-1 min-w-0">
                            <i class="fas fa-file text-red-500 mr-2 flex-shrink-0"></i>
                            <span class="text-red-700 truncate" title="${fileName}">${fileName}</span>
                        </div>
                        <span class="text-red-500 font-medium flex-shrink-0 ml-2">Will be removed</span>
                    `;
                    deletedList.appendChild(deletedItem);
                    deletedContainer.classList.remove('hidden');
                }
            }
            
            // Update hidden input with paths (comma-separated)
            document.getElementById('removeAttachments').value = deletedAttachmentPaths.join(',');    
            
            // Update summary counts
            const keptCount = existingAttachmentsCount - deletedAttachmentPaths.length;
            const keptElement = document.getElementById('keptAttachmentsCount');
            const deletedElement = document.getElementById('deletedAttachmentsCount');
            const existingElement = document.getElementById('existingAttachmentsCount');
            
            if (keptElement) keptElement.textContent = keptCount;
            if (deletedElement) deletedElement.textContent = deletedAttachmentPaths.length;
            if (existingElement) existingElement.textContent = keptCount;
            
            // Update attachments summary text
            const newFiles = document.getElementById('fileInput')?.files.length || 0;
            const summaryAttachments = document.getElementById('summaryAttachments');
            if (summaryAttachments) {
                summaryAttachments.innerHTML = `
                    <span id="existingAttachmentsCount">${keptCount}</span> existing + 
                    <span id="newAttachmentsCount">${newFiles}</span> new
                    (<span id="keptAttachmentsCount">${keptCount}</span> kept, 
                    <span id="deletedAttachmentsCount" class="text-red-600">${deletedAttachmentPaths.length}</span> removed)
                `;
            }
        };

        // File upload preview
        const fileInput = document.getElementById('fileInput');
        const fileList = document.getElementById('fileList');
        const dropZone = document.getElementById('dropZone');
        
        if (fileInput && fileList) {
            fileInput.addEventListener('change', function() {
                fileList.innerHTML = '<h4 class="text-xs font-medium text-gray-700 mb-2 flex items-center bg-gray-50 px-3 py-2 rounded-lg"><i class="fas fa-paperclip text-primary mr-2"></i>New Files to Upload</h4>';
                
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
                    
                    // Update summary with new file count
                    const newFiles = this.files.length;
                    const keptCount = existingAttachmentsCount - deletedAttachmentPaths.length;
                    const summaryAttachments = document.getElementById('summaryAttachments');
                    if (summaryAttachments) {
                        summaryAttachments.innerHTML = `
                            <span id="existingAttachmentsCount">${keptCount}</span> existing + 
                            <span id="newAttachmentsCount">${newFiles}</span> new
                            (<span id="keptAttachmentsCount">${keptCount}</span> kept, 
                            <span id="deletedAttachmentsCount" class="text-red-600">${deletedAttachmentPaths.length}</span> removed)
                        `;
                    }
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

        // Summary update function
        function updateSummary() {
            // Update subject
            const subjectInput = document.getElementById('subject');
            if (subjectInput) {
                document.getElementById('summarySubject').textContent = subjectInput.value;
            }
            
            // Update category
            const categorySelect = document.getElementById('category');
            if (categorySelect) {
                const categoryText = categorySelect.options[categorySelect.selectedIndex]?.text || '{{ $ticket->category->name ?? "Uncategorized" }}';
                document.getElementById('summaryCategory').textContent = categoryText;
            }
            
            // Update priority
            const priorityChecked = document.querySelector('input[name="priority"]:checked');
            if (priorityChecked) {
                const priority = priorityChecked.value;
                const priorityElem = document.getElementById('summaryPriority');
                priorityElem.textContent = priority.charAt(0).toUpperCase() + priority.slice(1);
            }
            
            // Update device info
            const modelInput = document.getElementById('model');
            if (modelInput) {
                document.getElementById('summaryModel').textContent = modelInput.value || '-';
            }
            
            // Update contact
            const contactNameInput = document.getElementById('contact_name');
            if (contactNameInput) {
                document.getElementById('summaryContact').textContent = contactNameInput.value;
            }
        }

        // Next button
        nextBtn.addEventListener('click', (e) => {
            e.preventDefault();
            if (currentStep < totalSteps) {
                currentStep++;
                showStep(currentStep);
            }
        });

        // Previous button
        prevBtn.addEventListener('click', (e) => {
            e.preventDefault();
            if (currentStep > 1) {
                currentStep--;
                showStep(currentStep);
            }
        });

        // Initialize
        showStep(1);
        
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
            });
        }
    });
</script>

</body>
</html>