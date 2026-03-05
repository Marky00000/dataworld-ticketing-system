<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ $user->name }}'s Profile - Dataworld Support</title>
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
            box-shadow: 0 10px 25px rgba(99, 102, 241, 0.15);
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

        /* Profile info item */
        .info-item {
            transition: all 0.2s ease;
            border: 1px solid transparent;
        }
        
        .info-item:hover {
            background-color: #f9fafb;
            border-color: #e5e7eb;
        }

        /* Gradient text */
        .gradient-text {
            background: linear-gradient(135deg, #6366f1, #8b5cf6);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            background-clip: text;
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
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
        <!-- Breadcrumb -->
        <div class="flex items-center text-sm text-gray-500 mb-6">
            <a href="/dashboard" class="hover:text-primary transition">Dashboard</a>
            <i class="fas fa-chevron-right mx-2 text-xs"></i>
            <span class="text-gray-700 font-medium">My Profile</span>
        </div>

        <!-- Stats Cards - Dynamic Data -->
        <div class="grid grid-cols-1 md:grid-cols-4 gap-6 mb-8">
            <div class="bg-white rounded-xl p-6 shadow-sm profile-stat-card">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-gray-500 text-sm font-medium">Total Tickets</p>
                        <p class="text-3xl font-bold text-gray-900 mt-2">{{ $totalTickets ?? 0 }}</p>
                    </div>
                    <div class="w-14 h-14 bg-blue-100 rounded-xl flex items-center justify-center">
                        <i class="fas fa-ticket-alt text-blue-600 text-2xl"></i>
                    </div>
                </div>
                <div class="mt-3 text-xs text-gray-500">
                    <span class="text-blue-600 font-medium">+{{ $ticketsThisMonth ?? 0 }}</span> this month
                </div>
            </div>
            
            <div class="bg-white rounded-xl p-6 shadow-sm profile-stat-card">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-gray-500 text-sm font-medium">Active</p>
                        <p class="text-3xl font-bold text-gray-900 mt-2">{{ $activeTickets ?? 0 }}</p>
                    </div>
                    <div class="w-14 h-14 bg-yellow-100 rounded-xl flex items-center justify-center">
                        <i class="fas fa-clock text-yellow-600 text-2xl"></i>
                    </div>
                </div>
                <div class="mt-3 text-xs text-gray-500">
                    <span class="text-yellow-600 font-medium">{{ $inProgressCount ?? 0 }}</span> in progress
                </div>
            </div>
            
            <div class="bg-white rounded-xl p-6 shadow-sm profile-stat-card">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-gray-500 text-sm font-medium">Resolved</p>
                        <p class="text-3xl font-bold text-gray-900 mt-2">{{ $resolvedTickets ?? 0 }}</p>
                    </div>
                    <div class="w-14 h-14 bg-green-100 rounded-xl flex items-center justify-center">
                        <i class="fas fa-check-circle text-green-600 text-2xl"></i>
                    </div>
                </div>
                <div class="mt-3 text-xs text-gray-500">
                    <span class="text-green-600 font-medium">{{ $resolvedThisMonth ?? 0 }}</span> this month
                </div>
            </div>
            
            <div class="bg-white rounded-xl p-6 shadow-sm profile-stat-card">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-gray-500 text-sm font-medium">Avg. Response</p>
                        <p class="text-3xl font-bold text-gray-900 mt-2">{{ $avgResponse ?? '0h' }}</p>
                    </div>
                    <div class="w-14 h-14 bg-purple-100 rounded-xl flex items-center justify-center">
                        <i class="fas fa-bolt text-purple-600 text-2xl"></i>
                    </div>
                </div>
                <div class="mt-3 text-xs text-gray-500">
                    <span class="text-purple-600 font-medium">{{ $responseTimeTrend ?? '0%' }}</span> vs last month
                </div>
            </div>
        </div>

        <!-- Main Grid -->
        <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
            <!-- Left Column - Profile Info -->
            <div class="lg:col-span-1">
                <div class="bg-white rounded-2xl shadow-sm overflow-hidden card-hover sticky top-24">
                    <!-- Profile Header with Gradient -->
                    <div class="relative">
                        <div class="bg-gradient-to-r from-primary via-primaryDark to-indigo-800 h-32"></div>
                        <div class="absolute -bottom-12 left-1/2 transform -translate-x-1/2">
                            <div class="w-28 h-28 bg-gradient-to-br from-primary to-support rounded-full flex items-center justify-center text-white text-4xl font-bold avatar-ring shadow-xl">
                                {{ strtoupper(substr($user->name, 0, 1)) }}
                            </div>
                        </div>
                    </div>
                    
                    <div class="pt-16 pb-6 px-6">
                        <div class="text-center mb-6">
                            <h2 class="text-2xl font-bold text-gray-900">{{ $user->name }}</h2>
                            <p class="text-gray-500 text-sm mb-4">{{ $user->email }}</p>
                            <div class="flex flex-wrap justify-center gap-2">
                                <span class="inline-flex items-center px-3 py-1.5 bg-primary/10 text-primary rounded-full text-sm font-medium">
                                    <i class="fas fa-user-tag mr-1.5 text-xs"></i>
                                    {{ ucfirst($user->user_type) }} Account
                                </span>
                                @if($user->email_verified_at)
                                    <span class="inline-flex items-center px-3 py-1.5 bg-green-100 text-green-700 rounded-full text-sm font-medium">
                                        <i class="fas fa-check-circle mr-1.5 text-xs"></i>
                                        Verified
                                    </span>
                                @endif
                            </div>
                        </div>
                        
                        <div class="space-y-3">
                            <div class="flex items-center justify-between p-4 bg-gray-50 rounded-xl info-item">
                                <div class="flex items-center space-x-3">
                                    <div class="w-10 h-10 bg-blue-100 rounded-xl flex items-center justify-center">
                                        <i class="fas fa-calendar-alt text-blue-600"></i>
                                    </div>
                                    <div>
                                        <p class="text-xs text-gray-500">Member Since</p>
                                        <p class="font-medium text-gray-900">{{ $user->created_at->format('M d, Y') }}</p>
                                    </div>
                                </div>
                                <span class="text-xs text-gray-400 bg-white px-2 py-1 rounded-full">{{ $user->created_at->diffForHumans() }}</span>
                            </div>
                            
                            @if($user->phone)
                            <div class="flex items-center justify-between p-4 bg-gray-50 rounded-xl info-item">
                                <div class="flex items-center space-x-3">
                                    <div class="w-10 h-10 bg-green-100 rounded-xl flex items-center justify-center">
                                        <i class="fas fa-phone text-green-600"></i>
                                    </div>
                                    <div>
                                        <p class="text-xs text-gray-500">Phone</p>
                                        <p class="font-medium text-gray-900">{{ $user->phone }}</p>
                                    </div>
                                </div>
                            </div>
                            @endif
                            
                            @if($user->company)
                            <div class="flex items-center justify-between p-4 bg-gray-50 rounded-xl info-item">
                                <div class="flex items-center space-x-3">
                                    <div class="w-10 h-10 bg-purple-100 rounded-xl flex items-center justify-center">
                                        <i class="fas fa-building text-purple-600"></i>
                                    </div>
                                    <div>
                                        <p class="text-xs text-gray-500">Company</p>
                                        <p class="font-medium text-gray-900">{{ $user->company }}</p>
                                    </div>
                                </div>
                            </div>
                            @endif
                            
                            <div class="flex items-center justify-between p-4 bg-gray-50 rounded-xl info-item">
                                <div class="flex items-center space-x-3">
                                    <div class="w-10 h-10 bg-indigo-100 rounded-xl flex items-center justify-center">
                                        <i class="fas fa-star text-indigo-600"></i>
                                    </div>
                                    <div>
                                        <p class="text-xs text-gray-500">Satisfaction</p>
                                        <p class="font-medium text-gray-900">{{ $satisfactionScore ?? '4.8' }} / 5.0</p>
                                    </div>
                                </div>
                                <div class="flex items-center text-yellow-400">
                                    <i class="fas fa-star text-xs"></i>
                                    <i class="fas fa-star text-xs"></i>
                                    <i class="fas fa-star text-xs"></i>
                                    <i class="fas fa-star text-xs"></i>
                                    <i class="fas fa-star-half-alt text-xs"></i>
                                </div>
                            </div>
                        </div>
                        
                        <div class="mt-6 grid grid-cols-2 gap-3">
                            <button onclick="window.location.href='{{ route('profile.password') }}'" 
                                    class="bg-primary hover:bg-primaryDark text-white px-4 py-3 rounded-xl font-medium transition-all duration-200 shadow-sm hover:shadow-md flex items-center justify-center space-x-2">
                                <i class="fas fa-key"></i>
                                <span>Password</span>
                            </button>

                            <button onclick="window.location.href='{{ route('profile.edit') }}'" 
                                    class="bg-gray-100 hover:bg-gray-200 text-gray-700 px-4 py-3 rounded-xl font-medium transition-all duration-200 flex items-center justify-center space-x-2">
                                <i class="fas fa-user-edit"></i>
                                <span>Edit</span>
                            </button>
                        </div>
                    </div>
                </div>
            </div>
            
            <!-- Right Column - Activities & Settings -->
            <div class="lg:col-span-2 space-y-8">
                <!-- Recent Activity -->
                <div class="bg-white rounded-2xl shadow-sm overflow-hidden card-hover">
                    <div class="px-6 py-5 border-b border-gray-200">
                        <div class="flex items-center justify-between">
                            <h3 class="text-lg font-semibold text-gray-900 flex items-center">
                                <i class="fas fa-history text-primary mr-2"></i>
                                Recent Activity
                            </h3>
                            <span class="text-xs bg-gray-100 text-gray-600 px-3 py-1.5 rounded-full">
                                Last 30 days
                            </span>
                        </div>
                    </div>
                    <div class="divide-y divide-gray-200 max-h-[400px] overflow-y-auto custom-scrollbar">
                        @forelse($recentActivities ?? [] as $activity)
                            <div class="px-6 py-4 activity-item hover:bg-gray-50 transition">
                                <div class="flex items-start space-x-4">
                                    <div class="w-10 h-10 rounded-xl flex items-center justify-center flex-shrink-0
                                        @if($activity->type === 'ticket') bg-blue-100
                                        @elseif($activity->type === 'comment') bg-yellow-100
                                        @else bg-green-100
                                        @endif">
                                        <i class="fas 
                                            @if($activity->type === 'ticket') fa-ticket-alt text-blue-600
                                            @elseif($activity->type === 'comment') fa-comment text-yellow-600
                                            @else fa-check-circle text-green-600
                                            @endif"></i>
                                    </div>
                                    <div class="flex-1 min-w-0">
                                        <div class="flex items-start justify-between">
                                            <div>
                                                <p class="font-medium text-gray-900">{{ $activity->description }}</p>
                                                <p class="text-sm text-gray-600 mt-0.5">{{ $activity->details }}</p>
                                            </div>
                                            <span class="text-xs text-gray-400 whitespace-nowrap ml-4 bg-gray-50 px-2 py-1 rounded-full">{{ $activity->created_at->diffForHumans() }}</span>
                                        </div>
                                        @if($activity->status)
                                            <div class="mt-2">
                                                <span class="status-badge status-{{ $activity->status }}">{{ ucfirst($activity->status) }}</span>
                                            </div>
                                        @endif
                                    </div>
                                </div>
                            </div>
                        @empty
                            <div class="px-6 py-12 text-center">
                                <div class="w-20 h-20 bg-gray-100 rounded-full flex items-center justify-center mx-auto mb-4">
                                    <i class="fas fa-history text-gray-400 text-3xl"></i>
                                </div>
                                <h4 class="text-gray-700 font-medium mb-1">No recent activity</h4>
                                <p class="text-gray-500 text-sm">Your recent actions will appear here</p>
                            </div>
                        @endforelse
                    </div>
                    <div class="px-6 py-4 bg-gray-50 border-t border-gray-200">
                        <a href="/tickets" class="text-primary hover:text-primaryDark font-medium flex items-center justify-center space-x-2 transition group">
                            <span>View all activity</span>
                            <i class="fas fa-arrow-right group-hover:translate-x-1 transition"></i>
                        </a>
                    </div>
                </div>

                <!-- Quick Settings -->
                <div class="bg-white rounded-2xl shadow-sm overflow-hidden card-hover">
                    <div class="px-6 py-5 border-b border-gray-200">
                        <h3 class="text-lg font-semibold text-gray-900 flex items-center">
                            <i class="fas fa-cog text-primary mr-2"></i>
                            Quick Settings
                        </h3>
                    </div>
                    <div class="divide-y divide-gray-200">
                        <a href="{{ route('profile.password') }}" class="block px-6 py-4 setting-item hover:bg-gray-50 transition">
                            <div class="flex items-center justify-between">
                                <div class="flex items-center space-x-3">
                                    <div class="w-10 h-10 bg-red-100 rounded-xl flex items-center justify-center">
                                        <i class="fas fa-lock text-red-600"></i>
                                    </div>
                                    <div>
                                        <p class="font-medium text-gray-900">Security</p>
                                        <p class="text-sm text-gray-500">Change your password and security settings</p>
                                    </div>
                                </div>
                                <i class="fas fa-chevron-right text-gray-400"></i>
                            </div>
                        </a>
                        
                        <a href="#" class="block px-6 py-4 setting-item hover:bg-gray-50 transition">
                            <div class="flex items-center justify-between">
                                <div class="flex items-center space-x-3">
                                    <div class="w-10 h-10 bg-blue-100 rounded-xl flex items-center justify-center">
                                        <i class="fas fa-bell text-blue-600"></i>
                                    </div>
                                    <div>
                                        <p class="font-medium text-gray-900">Notifications</p>
                                        <p class="text-sm text-gray-500">Manage your notification preferences</p>
                                    </div>
                                </div>
                                <i class="fas fa-chevron-right text-gray-400"></i>
                            </div>
                        </a>
                        
                        <a href="#" class="block px-6 py-4 setting-item hover:bg-gray-50 transition">
                            <div class="flex items-center justify-between">
                                <div class="flex items-center space-x-3">
                                    <div class="w-10 h-10 bg-green-100 rounded-xl flex items-center justify-center">
                                        <i class="fas fa-envelope text-green-600"></i>
                                    </div>
                                    <div>
                                        <p class="font-medium text-gray-900">Email Settings</p>
                                        <p class="text-sm text-gray-500">Update your email preferences</p>
                                    </div>
                                </div>
                                <i class="fas fa-chevron-right text-gray-400"></i>
                            </div>
                        </a>
                        
                        <a href="#" class="block px-6 py-4 setting-item hover:bg-gray-50 transition">
                            <div class="flex items-center justify-between">
                                <div class="flex items-center space-x-3">
                                    <div class="w-10 h-10 bg-purple-100 rounded-xl flex items-center justify-center">
                                        <i class="fas fa-globe text-purple-600"></i>
                                    </div>
                                    <div>
                                        <p class="font-medium text-gray-900">Language & Region</p>
                                        <p class="text-sm text-gray-500">Set your preferred language</p>
                                    </div>
                                </div>
                                <i class="fas fa-chevron-right text-gray-400"></i>
                            </div>
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Footer - Enhanced -->
    <footer class="bg-gray-900 text-gray-400 py-8 mt-12">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="border-t border-gray-800 pt-8 text-center text-sm">
                <p>© {{ date('Y') }} Dataworld Computer Center. All rights reserved.</p>
                <p class="mt-2 text-xs text-gray-600">
                    <i class="fas fa-ticket-alt mr-1"></i>
                    Support Ticket System v2.0
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
            
            // Make setting items clickable
            document.querySelectorAll('.setting-item').forEach(item => {
                item.addEventListener('click', function(e) {
                    const link = this.closest('a');
                    if (link) {
                        // Already using <a> tag, no need to handle
                    }
                });
            });
            
            // Make activity items clickable
            document.querySelectorAll('.activity-item').forEach(item => {
                item.addEventListener('click', function() {
                    const ticketLink = this.querySelector('a[href^="/tickets/"]');
                    if (ticketLink) {
                        window.location.href = ticketLink.getAttribute('href');
                    }
                });
            });
            
            // Close mobile menu when clicking outside
            document.addEventListener('click', function(event) {
                if (mobileMenu && mobileMenuButton && 
                    !mobileMenu.contains(event.target) && 
                    !mobileMenuButton.contains(event.target)) {
                    mobileMenu.classList.add('hidden');
                }
            });
        });
    </script>
</body>
</html>