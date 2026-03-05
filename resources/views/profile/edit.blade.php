<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Profile - {{ $user->name }} - Dataworld Support</title>
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
            box-shadow: 0 10px 25px rgba(0, 0, 0, 0.1);
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
        .status-pending { background: #fff3cd; color: #856404; }
        .status-closed { background: #e5e7eb; color: #374151; }
        
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
        
        /* Profile avatar animation */
        .avatar-ring {
            box-shadow: 0 0 0 4px white, 0 0 0 6px #6366f1;
            transition: all 0.3s ease;
        }
        
        .avatar-ring:hover {
            transform: scale(1.05);
            box-shadow: 0 0 0 4px white, 0 0 0 8px #4f46e5;
        }
        
        /* Profile stat card hover */
        .profile-stat-card {
            transition: all 0.3s ease;
            border: 1px solid transparent;
        }
        
        .profile-stat-card:hover {
            transform: translateY(-4px);
            border-color: #6366f1;
            box-shadow: 0 12px 20px -10px rgba(99, 102, 241, 0.3);
        }
        
        /* Activity item hover */
        .activity-item {
            transition: all 0.2s ease;
            cursor: pointer;
        }
        
        .activity-item:hover {
            background-color: #f9fafb;
            transform: translateX(4px);
        }
        
        /* Setting item hover */
        .setting-item {
            transition: all 0.2s ease;
            cursor: pointer;
        }
        
        .setting-item:hover {
            background-color: #f9fafb;
            padding-left: 1.75rem !important;
        }
        
        .setting-item:hover i.fa-chevron-right {
            color: #6366f1 !important;
            transform: translateX(4px);
        }
        
        /* Card hover effect */
        .card-hover {
            transition: all 0.3s ease;
        }
        
        .card-hover:hover {
            box-shadow: 0 20px 25px -5px rgba(0, 0, 0, 0.1), 0 10px 10px -5px rgba(0, 0, 0, 0.04);
        }
        
        /* Breadcrumb hover */
        .breadcrumb-hover {
            transition: all 0.2s ease;
        }
        
        .breadcrumb-hover:hover {
            color: #6366f1;
        }
        
        .breadcrumb-hover:hover i {
            transform: translateY(-1px);
        }
        
        /* Change password button */
        .change-password-btn {
            transition: all 0.3s ease;
        }
        
        .change-password-btn:hover {
            transform: translateY(-2px);
            box-shadow: 0 8px 15px -3px rgba(99, 102, 241, 0.3);
        }

        /* Form input focus effects */
        .form-input:focus {
            box-shadow: 0 0 0 3px rgba(99, 102, 241, 0.1);
        }

        /* Save button pulse animation */
        @keyframes softPulse {
            0% { box-shadow: 0 0 0 0 rgba(99, 102, 241, 0.4); }
            70% { box-shadow: 0 0 0 10px rgba(99, 102, 241, 0); }
            100% { box-shadow: 0 0 0 0 rgba(99, 102, 241, 0); }
        }

        .btn-save {
            animation: softPulse 2s infinite;
        }

        .btn-save:hover {
            animation: none;
        }
    </style>
</head>
<body class="bg-gray-50 min-h-screen">
    <!-- Top Navigation Bar - Modern Updated -->
<nav class="bg-white/80 backdrop-blur-md shadow-lg border-b border-primary/10 sticky top-0 z-50 transition-all duration-300" 
     x-data="{ 
        mobileMenuOpen: false, 
        scrolled: false,
        userMenuOpen: false,
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
                <!-- Dashboard Link -->
                <a href="/dashboard" 
                   class="{{ request()->is('dashboard') ? 'text-primary font-medium' : 'text-gray-700 hover:text-primary' }} transition-all duration-300 flex items-center space-x-2 relative group">
                    <i class="fas fa-home"></i>
                    <span>Dashboard</span>
                    <span class="absolute -bottom-1 left-0 w-0 h-0.5 bg-primary group-hover:w-full transition-all duration-300"></span>
                </a>
                
                <!-- My Tickets Link -->
                <a href="/tickets" 
                   class="{{ request()->is('tickets*') ? 'text-primary font-medium' : 'text-gray-700 hover:text-primary' }} transition-all duration-300 flex items-center space-x-2 relative group">
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

                <!-- User Dropdown - Modernized -->
                <div class="relative group">
                    <button class="flex items-center space-x-3 focus:outline-none group cursor-pointer">
                        <div class="flex items-center space-x-3">
                            <!-- User avatar with gradient and status indicator -->
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
                    
                    <!-- Dropdown Menu -->
                    <div class="absolute right-0 mt-2 w-64 bg-white rounded-xl shadow-2xl py-2 z-50 opacity-0 invisible group-hover:opacity-100 group-hover:visible transition-all duration-300 border border-primary/10 transform origin-top-right scale-95 group-hover:scale-100">
                        
                        <!-- User info header -->
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
                        
                        <!-- Menu items -->
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
                           class="flex items-center space-x-3 px-4 py-3 text-sm text-blue-600 hover:bg-blue-50 transition-all duration-300 group border-t border-gray-100 mt-1 pt-3">
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
            
            <!-- Navigation Items with active states -->
            <a href="/dashboard" 
               class="flex items-center space-x-3 px-4 py-3 {{ request()->is('dashboard') ? 'text-primary bg-primary/5 border border-primary/20' : 'text-gray-700 hover:bg-gray-50' }} rounded-xl transition-all duration-300 group">
                <div class="w-10 h-10 {{ request()->is('dashboard') ? 'bg-primary/10' : 'bg-gray-100 group-hover:bg-primary/10' }} rounded-xl flex items-center justify-center transition-colors">
                    <i class="fas fa-home {{ request()->is('dashboard') ? 'text-primary' : 'text-gray-500 group-hover:text-primary' }}"></i>
                </div>
                <div class="flex-1">
                    <p class="font-medium {{ request()->is('dashboard') ? 'text-primary' : 'text-gray-900' }}">Dashboard</p>
                    <p class="text-xs text-gray-500">Overview & statistics</p>
                </div>
            </a>
            
            <a href="/tickets" 
               class="flex items-center space-x-3 px-4 py-3 {{ request()->is('tickets*') && !request()->is('tickets/create') ? 'text-primary bg-primary/5 border border-primary/20' : 'text-gray-700 hover:bg-gray-50' }} rounded-xl transition-all duration-300 group">
                <div class="w-10 h-10 {{ request()->is('tickets*') && !request()->is('tickets/create') ? 'bg-primary/10' : 'bg-gray-100 group-hover:bg-primary/10' }} rounded-xl flex items-center justify-center transition-colors">
                    <i class="fas fa-ticket-alt {{ request()->is('tickets*') && !request()->is('tickets/create') ? 'text-primary' : 'text-gray-500 group-hover:text-primary' }}"></i>
                </div>
                <div class="flex-1">
                    <p class="font-medium {{ request()->is('tickets*') && !request()->is('tickets/create') ? 'text-primary' : 'text-gray-900' }}">My Tickets</p>
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
            
            <!-- Profile & Sign Out -->
            <a href="{{ route('profile.dashboard') }}" 
               class="flex items-center space-x-3 px-4 py-3 {{ request()->routeIs('profile.dashboard') ? 'text-primary bg-primary/5 border border-primary/20' : 'text-gray-700 hover:bg-gray-50' }} rounded-xl transition-all duration-300 group">
                <div class="w-10 h-10 {{ request()->routeIs('profile.dashboard') ? 'bg-primary/10' : 'bg-gray-100 group-hover:bg-primary/10' }} rounded-xl flex items-center justify-center transition-colors">
                    <i class="fas fa-user {{ request()->routeIs('profile.dashboard') ? 'text-primary' : 'text-gray-500 group-hover:text-primary' }}"></i>
                </div>
                <div class="flex-1">
                    <p class="font-medium {{ request()->routeIs('profile.dashboard') ? 'text-primary' : 'text-gray-900' }}">My Profile</p>
                    <p class="text-xs text-gray-500">Manage your account</p>
                </div>
            </a>
            
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

<!-- Add Alpine.js for mobile menu functionality -->
<script src="//unpkg.com/alpinejs" defer></script>

<!-- Add these styles -->
<style>
    [x-cloak] { display: none !important; }
    
    .backdrop-blur-md {
        backdrop-filter: blur(12px);
        -webkit-backdrop-filter: blur(12px);
    }
    
    .group:hover .group-hover\:rotate-180 {
        transform: rotate(180deg);
    }
    
    .group:hover .group-hover\:scale-100 {
        transform: scale(1);
    }
    
    /* Ensure dropdown appears above other elements */
    .absolute {
        z-index: 1000;
    }
</style>

    <!-- Main Content -->
    <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
        <!-- Breadcrumb -->
        <div class="mb-6 flex items-center space-x-2 text-sm">
            <a href="{{ route('profile.dashboard') }}" class="text-gray-500 hover:text-primary transition flex items-center">
                <i class="fas fa-user mr-1"></i> Profile
            </a>
            <i class="fas fa-chevron-right text-gray-400 text-xs"></i>
            <span class="text-primary font-medium">Edit Profile</span>
        </div>

        <!-- Header Card -->
        <div class="bg-gradient-to-r from-primary to-primaryDark rounded-2xl shadow-lg overflow-hidden mb-6">
            <div class="px-6 py-8 text-white">
                <div class="flex items-center space-x-4">
                    <div class="w-16 h-16 bg-white/20 rounded-2xl flex items-center justify-center backdrop-blur-sm">
                        <i class="fas fa-user-edit text-3xl"></i>
                    </div>
                    <div>
                        <h1 class="text-2xl font-bold">Edit Profile</h1>
                        <p class="text-white/80 text-sm mt-1">Update your personal information and contact details</p>
                    </div>
                </div>
            </div>
        </div>

        {{-- Success Message --}}
        @if(session('success'))
            <div class="mb-6 bg-green-50 border-l-4 border-green-500 rounded-lg p-4">
                <div class="flex items-center">
                    <div class="flex-shrink-0">
                        <i class="fas fa-check-circle text-green-500 text-lg"></i>
                    </div>
                    <div class="ml-3">
                        <p class="text-sm text-green-700">{{ session('success') }}</p>
                    </div>
                </div>
            </div>
        @endif

        {{-- Error Display --}}
        @if($errors->any())
            <div class="mb-6 bg-red-50 border-l-4 border-red-500 rounded-lg p-4">
                <div class="flex items-center mb-2">
                    <div class="flex-shrink-0">
                        <i class="fas fa-exclamation-circle text-red-500 text-lg"></i>
                    </div>
                    <div class="ml-3">
                        <h5 class="text-sm font-medium text-red-800">Please fix the following errors:</h5>
                    </div>
                </div>
                <ul class="list-disc list-inside text-sm text-red-700 ml-6">
                    @foreach($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <!-- Edit Form Card -->
        <div class="bg-white rounded-2xl shadow-sm overflow-hidden card-hover">
            <div class="p-6">
                <form method="POST" action="{{ route('profile.update') }}">
                    @csrf
                    @method('PUT')

                    <!-- Name Field -->
                    <div class="mb-6">
                        <label for="name" class="block text-sm font-semibold text-gray-700 mb-2">
                            <i class="fas fa-user text-primary mr-2"></i>Full Name <span class="text-red-500">*</span>
                        </label>
                        <input type="text" 
                               id="name" 
                               name="name" 
                               value="{{ old('name', $user->name) }}" 
                               required
                               class="w-full px-4 py-3 border border-gray-300 rounded-xl focus:ring-2 focus:ring-primary/20 focus:border-primary transition form-input @error('name') border-red-500 @enderror"
                               placeholder="Enter your full name">
                        @error('name')
                            <p class="mt-1 text-sm text-red-600 flex items-center">
                                <i class="fas fa-exclamation-circle mr-1"></i> {{ $message }}
                            </p>
                        @enderror
                    </div>

                    <!-- Company Field -->
                    <div class="mb-6">
                        <label for="company" class="block text-sm font-semibold text-gray-700 mb-2">
                            <i class="fas fa-building text-primary mr-2"></i>Company
                        </label>
                        <input type="text" 
                               id="company" 
                               name="company" 
                               value="{{ old('company', $user->company) }}"
                               class="w-full px-4 py-3 border border-gray-300 rounded-xl focus:ring-2 focus:ring-primary/20 focus:border-primary transition form-input @error('company') border-red-500 @enderror"
                               placeholder="Enter your company name">
                        @error('company')
                            <p class="mt-1 text-sm text-red-600 flex items-center">
                                <i class="fas fa-exclamation-circle mr-1"></i> {{ $message }}
                            </p>
                        @enderror
                    </div>

                    <!-- Email Field -->
                    <div class="mb-6">
                        <label for="email" class="block text-sm font-semibold text-gray-700 mb-2">
                            <i class="fas fa-envelope text-primary mr-2"></i>Email Address <span class="text-red-500">*</span>
                        </label>
                        <input type="email" 
                               id="email" 
                               name="email" 
                               value="{{ old('email', $user->email) }}" 
                               required
                               class="w-full px-4 py-3 border border-gray-300 rounded-xl focus:ring-2 focus:ring-primary/20 focus:border-primary transition form-input @error('email') border-red-500 @enderror"
                               placeholder="Enter your email address">
                        @error('email')
                            <p class="mt-1 text-sm text-red-600 flex items-center">
                                <i class="fas fa-exclamation-circle mr-1"></i> {{ $message }}
                            </p>
                        @enderror
                        
                        <!-- Email Verification Status -->
                        <div class="mt-3 flex items-center">
                            @if($user->email_verified_at)
                                <span class="inline-flex items-center px-3 py-1 rounded-full text-xs font-medium bg-green-100 text-green-800">
                                    <i class="fas fa-check-circle mr-1"></i> Verified
                                </span>
                                <span class="text-xs text-gray-500 ml-2">
                                    {{ $user->email_verified_at->format('M d, Y') }}
                                </span>
                            @else
                                <span class="inline-flex items-center px-3 py-1 rounded-full text-xs font-medium bg-yellow-100 text-yellow-800">
                                    <i class="fas fa-exclamation-triangle mr-1"></i> Not verified
                                </span>
                            @endif
                        </div>

                        <!-- Email Change Warning -->
                        <div class="mt-4 bg-blue-50 rounded-xl p-4">
                            <div class="flex">
                                <div class="flex-shrink-0">
                                    <i class="fas fa-info-circle text-blue-500"></i>
                                </div>
                                <div class="ml-3">
                                    <h4 class="text-sm font-medium text-blue-800">Changing your email address</h4>
                                    <p class="text-xs text-blue-700 mt-1">
                                        If you change your email address, you'll need to verify it again before you can receive notifications.
                                    </p>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Phone Field -->
                    <div class="mb-6">
                        <label for="phone" class="block text-sm font-semibold text-gray-700 mb-2">
                            <i class="fas fa-phone text-primary mr-2"></i>Phone Number
                        </label>
                        <input type="text" 
                               id="phone" 
                               name="phone" 
                               value="{{ old('phone', $user->phone) }}"
                               class="w-full px-4 py-3 border border-gray-300 rounded-xl focus:ring-2 focus:ring-primary/20 focus:border-primary transition form-input @error('phone') border-red-500 @enderror"
                               placeholder="Enter your phone number">
                        @error('phone')
                            <p class="mt-1 text-sm text-red-600 flex items-center">
                                <i class="fas fa-exclamation-circle mr-1"></i> {{ $message }}
                            </p>
                        @enderror
                    </div>

                    <!-- Account Type (Read-only) -->
                    <div class="mb-6 p-4 bg-gray-50 rounded-xl">
                        <label class="block text-sm font-semibold text-gray-700 mb-2">
                            <i class="fas fa-user-tag text-primary mr-2"></i>Account Type
                        </label>
                        <div class="flex items-center">
                            <span class="inline-flex items-center px-4 py-2 rounded-lg text-sm font-medium
                                @if($user->user_type === 'admin') bg-red-100 text-red-800
                                @elseif($user->user_type === 'tech') bg-blue-100 text-blue-800
                                @else bg-green-100 text-green-800
                                @endif">
                                <i class="fas 
                                    @if($user->user_type === 'admin') fa-shield-alt
                                    @elseif($user->user_type === 'tech') fa-wrench
                                    @else fa-user
                                    @endif mr-2">
                                </i>
                                {{ ucfirst($user->user_type) }} Account
                            </span>
                            <span class="text-xs text-gray-500 ml-3">(Cannot be changed)</span>
                        </div>
                    </div>

                    <!-- Form Buttons -->
                    <div class="flex items-center justify-between pt-6 border-t border-gray-200">
                        <a href="{{ route('profile.dashboard') }}" 
                           class="inline-flex items-center px-6 py-3 bg-gray-100 hover:bg-gray-200 text-gray-700 rounded-xl font-medium transition-all hover:scale-105">
                            <i class="fas fa-arrow-left mr-2"></i> Back to Profile
                        </a>
                        <div class="flex space-x-3">
                            <a href="{{ route('profile.dashboard') }}" 
                               class="inline-flex items-center px-6 py-3 bg-white border border-gray-300 hover:bg-gray-50 text-gray-700 rounded-xl font-medium transition-all hover:scale-105">
                                <i class="fas fa-times mr-2"></i> Cancel
                            </a>
                            <button type="submit" 
                                    class="inline-flex items-center px-8 py-3 bg-primary hover:bg-primaryDark text-white rounded-xl font-medium transition-all hover:scale-105 shadow-md btn-save">
                                <i class="fas fa-save mr-2"></i> Save Changes
                            </button>
                        </div>
                    </div>
                </form>
            </div>
        </div>

        <!-- Additional Info Card -->
        <div class="mt-6 bg-white rounded-2xl shadow-sm overflow-hidden">
            <div class="px-6 py-4 bg-gray-50 border-b border-gray-200">
                <h3 class="font-semibold text-gray-900 flex items-center">
                    <i class="fas fa-shield-alt text-primary mr-2"></i>
                    Profile Security Tips
                </h3>
            </div>
            <div class="p-6">
                <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                    <div class="flex items-start space-x-3">
                        <div class="w-8 h-8 bg-green-100 rounded-lg flex items-center justify-center flex-shrink-0">
                            <i class="fas fa-check-circle text-green-600"></i>
                        </div>
                        <div>
                            <h4 class="text-sm font-medium text-gray-900">Verified Email</h4>
                            <p class="text-xs text-gray-500">Ensure your email is verified to receive notifications</p>
                        </div>
                    </div>
                    <div class="flex items-start space-x-3">
                        <div class="w-8 h-8 bg-blue-100 rounded-lg flex items-center justify-center flex-shrink-0">
                            <i class="fas fa-phone-alt text-blue-600"></i>
                        </div>
                        <div>
                            <h4 class="text-sm font-medium text-gray-900">Contact Number</h4>
                            <p class="text-xs text-gray-500">Keep your phone number updated for quick support</p>
                        </div>
                    </div>
                    <div class="flex items-start space-x-3">
                        <div class="w-8 h-8 bg-purple-100 rounded-lg flex items-center justify-center flex-shrink-0">
                            <i class="fas fa-building text-purple-600"></i>
                        </div>
                        <div>
                            <h4 class="text-sm font-medium text-gray-900">Company Details</h4>
                            <p class="text-xs text-gray-500">Company information helps us serve you better</p>
                        </div>
                    </div>
                </div>
            </div>
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
        document.addEventListener('DOMContentLoaded', function() {
            // Mobile menu toggle
            const mobileMenuButton = document.getElementById('mobileMenuButton');
            const mobileMenu = document.getElementById('mobileMenu');
            
            if (mobileMenuButton && mobileMenu) {
                mobileMenuButton.addEventListener('click', function() {
                    mobileMenu.classList.toggle('hidden');
                });
            }
            
            // Close mobile menu when clicking outside
            document.addEventListener('click', function(event) {
                if (mobileMenu && mobileMenuButton && 
                    !mobileMenu.contains(event.target) && 
                    !mobileMenuButton.contains(event.target)) {
                    mobileMenu.classList.add('hidden');
                }
            });
            
            // Form validation
            const form = document.querySelector('form');
            if (form) {
                form.addEventListener('submit', function(e) {
                    const requiredFields = form.querySelectorAll('[required]');
                    let isValid = true;
                    
                    requiredFields.forEach(field => {
                        if (!field.value.trim()) {
                            field.classList.add('border-red-500');
                            isValid = false;
                        } else {
                            field.classList.remove('border-red-500');
                        }
                    });
                    
                    if (!isValid) {
                        e.preventDefault();
                        alert('Please fill in all required fields.');
                    }
                });
            }
            
            // Remove error styling on input
            const inputs = document.querySelectorAll('input');
            inputs.forEach(input => {
                input.addEventListener('input', function() {
                    this.classList.remove('border-red-500');
                });
            });
        });
    </script>
</body>
</html>