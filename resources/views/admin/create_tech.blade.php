<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Create Technician Account - Dataworld Support Portal</title>
    <link rel="icon" type="image/png" href="{{ asset('images/logo.png') }}">
    
    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    
    <!-- Tailwind CSS -->
    <script src="https://cdn.tailwindcss.com"></script>
    
    <!-- Vue 3 -->
    <script src="https://cdn.jsdelivr.net/npm/vue@3.5.13/dist/vue.global.min.js"></script>
    
    <!-- Tailwind Configuration -->
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
        
        .absolute {
            z-index: 1000;
        }
    </style>
</head>
<body class="bg-gray-50 min-h-screen">

<div id="app">
    <!-- Top Navigation Bar - Modern Updated -->
    <nav class="bg-white/80 backdrop-blur-md shadow-lg border-b border-primary/10 sticky top-0 z-50 transition-all duration-300" 
     :class="{ 'shadow-xl bg-white/95': scrolled }">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex justify-between h-16">
            <!-- Logo with animation -->
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

                <!-- Bolder divider - thicker and more prominent -->
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
                            <div>
                                <p class="text-sm font-semibold text-gray-900">{{ auth()->user()->name }}</p>
                                <p class="text-xs text-gray-500 mt-0.5">{{ auth()->user()->email }}</p>
                            </div>
                        </div>
                        <div class="px-5 pb-2">
                            <span class="inline-flex items-center px-2.5 py-1 rounded-md text-xs font-medium bg-gray-100 text-blue-700">
                                @if(auth()->user()->user_type === 'admin')
                                    <i class="fas fa-crown mr-1.5 text-xs text-blue-600"></i>
                                @elseif(auth()->user()->user_type === 'tech')
                                    <i class="fas fa-tools mr-1.5 text-xs text-blue-600"></i>
                                @else
                                    <i class="fas fa-user mr-1.5 text-xs text-blue-600"></i>
                                @endif
                                @if(auth()->user()->user_type === 'admin')
                                    Administrator
                                @elseif(auth()->user()->user_type === 'tech')
                                    Technician
                                @else
                                    Client
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
                <button @click="menuOpen = !menuOpen" 
                        class="relative w-10 h-10 flex items-center justify-center text-gray-600 hover:text-primary focus:outline-none transition-colors duration-200"
                        :class="{ 'text-primary': menuOpen }"
                        aria-label="Toggle menu">
                    <i :class="menuOpen ? 'fas fa-times text-xl' : 'fas fa-bars text-xl'"></i>
                </button>
            </div>
        </div>
    </div>
    
    <!-- Mobile Menu - Vue Transition -->
    <transition name="mobile-menu">
        <div v-if="menuOpen" 
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
                                        Administrator
                                    @elseif(auth()->user()->user_type === 'tech')
                                        Technician Account
                                    @else
                                        Client Account
                                    @endif
                            </span>
                        </div>
                </div>
                
                <!-- Navigation Items -->
                <a href="/dashboard" @click="menuOpen = false"
                   class="flex items-center space-x-3 px-4 py-3 text-gray-600 hover:text-primary rounded-xl transition-all duration-300 group">
                    <div class="w-10 h-10 bg-gray-100 group-hover:bg-primary/10 rounded-xl flex items-center justify-center transition-colors">
                        <i class="fas fa-home text-gray-500 group-hover:text-primary"></i>
                    </div>
                    <div class="flex-1">
                        <p class="font-medium text-gray-700">Dashboard</p>
                        <p class="text-xs text-gray-400">Overview & statistics</p>
                    </div>
                    @if(request()->is('dashboard'))
                        <span class="text-xs bg-primary/10 text-primary px-2 py-1 rounded-full">Current</span>
                    @endif
                </a>
                
                <a href="/tickets" @click="menuOpen = false"
                   class="flex items-center space-x-3 px-4 py-3 text-gray-600 hover:text-primary rounded-xl transition-all duration-300 group">
                    <div class="w-10 h-10 bg-gray-100 group-hover:bg-primary/10 rounded-xl flex items-center justify-center transition-colors">
                        <i class="fas fa-ticket-alt text-gray-500 group-hover:text-primary"></i>
                    </div>
                    <div class="flex-1">
                        <p class="font-medium text-gray-700">My Tickets</p>
                        <p class="text-xs text-gray-400">View your support tickets</p>
                    </div>
                    @if(request()->is('tickets') || request()->is('tickets/*'))
                        <span class="text-xs bg-primary/10 text-primary px-2 py-1 rounded-full">Current</span>
                    @endif
                </a>
                
                <!-- New Ticket Button -->
                <a href="/tickets/create" @click="menuOpen = false"
                   class="flex items-center space-x-3 px-4 py-3 bg-gradient-to-r from-primary to-primaryDark text-white rounded-xl font-medium hover:shadow-lg hover:shadow-primary/30 transition-all duration-300 group">
                    <div class="w-10 h-10 bg-white/20 rounded-xl flex items-center justify-center">
                        <i class="fas fa-plus-circle text-white"></i>
                    </div>
                    <div class="flex-1">
                        <p class="font-medium text-white">New Ticket</p>
                        <p class="text-xs text-white/80">Create a support request</p>
                    </div>
                </a>
                
                @if(auth()->user()->user_type === 'admin')
                <div class="border-t border-gray-200 pt-4 mt-2">
                    <a href="{{ route('admin.tech.create') }}" @click="menuOpen = false"
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
                <a href="{{ route('profile.dashboard') }}" @click="menuOpen = false"
                   class="flex items-center space-x-3 px-4 py-3 text-gray-600 hover:text-primary rounded-xl transition-all duration-300 group">
                    <div class="w-10 h-10 bg-gray-100 group-hover:bg-primary/10 rounded-xl flex items-center justify-center transition-colors">
                        <i class="fas fa-user text-gray-500 group-hover:text-primary"></i>
                    </div>
                    <div class="flex-1">
                        <p class="font-medium text-gray-700">My Profile</p>
                        <p class="text-xs text-gray-400">Manage your account</p>
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
                            <p class="font-medium text-red-600">Sign Out</p>
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

<!-- Vue for Navbar -->
<script>
    const { createApp } = Vue;

    const app = createApp({
        data() {
            return {
                menuOpen: false,
                scrolled: false
            }
        },
        mounted() {
            window.addEventListener('scroll', this.handleScroll);
        },
        methods: {
            handleScroll() {
                this.scrolled = window.scrollY > 20;
            }
        }
    });

    app.mount('#app');
</script>

    <!-- Main Content -->
    <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
        <div class="flex items-center text-sm text-gray-500 mb-6 bg-gray-50 px-4 py-3 rounded-lg">
            <a href="/dashboard" class="hover:text-primary transition breadcrumb-hover flex items-center">
                <span>Dashboard</span>
            </a>
            <i class="fas fa-chevron-right mx-3 text-xs text-gray-400"></i>
            <a href="create_tech" class="hover:text-primary transition breadcrumb-hover flex items-center">
                <span>Create Tech Account</span>
            </a>
        </div>        
        
        <div class="mb-8">
            <div class="flex items-center space-x-4">
                <div>
                    <h1 class="text-3xl font-bold text-gray-900">Create Tech Account</h1>
                    <p class="text-gray-600 mt-1">Add a new technician to your support team</p>
                </div>
            </div>
        </div>

        <!-- Success Message -->
        @if(session('success'))
        <div class="mb-6 bg-green-100 border-l-4 border-green-500 text-green-700 p-4 rounded-lg flex items-center justify-between" role="alert">
            <div class="flex items-center space-x-3">
                <i class="fas fa-check-circle text-green-500 text-xl"></i>
                <p>{{ session('success') }}</p>
            </div>
            <button type="button" class="text-green-700 hover:text-green-900" onclick="this.parentElement.remove()">
                <i class="fas fa-times"></i>
            </button>
        </div>
        @endif

        <!-- Error Messages -->
        @if($errors->any())
        <div class="mb-6 bg-red-100 border-l-4 border-red-500 text-red-700 p-4 rounded-lg" role="alert">
            <div class="flex items-center space-x-3 mb-2">
                <i class="fas fa-exclamation-circle text-red-500 text-xl"></i>
                <p class="font-semibold">Please fix the following errors:</p>
            </div>
            <ul class="list-disc list-inside ml-6 space-y-1">
                @foreach($errors->all() as $error)
                    <li class="text-sm">{{ $error }}</li>
                @endforeach
            </ul>
        </div>
        @endif

        <!-- Create Tech Form -->
        <div class="bg-white rounded-2xl shadow-lg overflow-hidden card-hover">
            <div class="px-8 py-6 bg-gradient-to-r from-primary to-primaryDark">
                <h2 class="text-xl font-semibold text-white flex items-center space-x-3">
                    <span>Technician Information</span>
                </h2>
            </div>
            
            <form action="{{ route('admin.tech.store') }}" method="POST" class="p-8">
                @csrf
                
                <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
                    <!-- Left Column -->
                    <div class="space-y-6">
                        <!-- Full Name -->
                        <div>
                            <label for="name" class="block text-sm font-medium text-gray-700 mb-2">
                                <i class="fas fa-user text-primary mr-2"></i>Full Name <span class="text-red-500">*</span>
                            </label>
                            <input type="text" 
                                   name="name" 
                                   id="name" 
                                   value="{{ old('name') }}"
                                   class="w-full px-4 py-3 border border-gray-300 rounded-xl form-input focus:outline-none focus:border-primary focus:ring-2 focus:ring-primary/20 transition @error('name') border-red-500 @enderror"
                                   placeholder="John Doe"
                                   required
                                   autofocus>
                            @error('name')
                                <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Email Address -->
                        <div>
                            <label for="email" class="block text-sm font-medium text-gray-700 mb-2">
                                <i class="fas fa-envelope text-primary mr-2"></i>Email Address <span class="text-red-500">*</span>
                            </label>
                            <input type="email" 
                                   name="email" 
                                   id="email" 
                                   value="{{ old('email') }}"
                                   class="w-full px-4 py-3 border border-gray-300 rounded-xl form-input focus:outline-none focus:border-primary focus:ring-2 focus:ring-primary/20 transition @error('email') border-red-500 @enderror"
                                   placeholder="tech@dataworld.com"
                                   required>
                            @error('email')
                                <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Company (Optional) -->
                        <div>
                            <label for="company" class="block text-sm font-medium text-gray-700 mb-2">
                                <i class="fas fa-building text-primary mr-2"></i>Company
                            </label>
                            <input type="text" 
                                   name="company" 
                                   id="company" 
                                   value="{{ old('company', 'Dataworld Computer Center') }}"
                                   class="w-full px-4 py-3 border border-gray-300 rounded-xl form-input focus:outline-none focus:border-primary focus:ring-2 focus:ring-primary/20 transition"
                                   placeholder="Company Name">
                            <p class="mt-1 text-xs text-gray-500">
                                <i class="fas fa-info-circle mr-1"></i>
                                Default: Dataworld Computer Center
                            </p>
                        </div>
                    </div>

                    <!-- Right Column -->
                    <div class="space-y-6">
                        <!-- Phone Number -->
                        <div>
                            <label for="phone" class="block text-sm font-medium text-gray-700 mb-2">
                                <i class="fas fa-phone text-primary mr-2"></i>Phone Number
                            </label>
                            <input type="tel" 
                                   name="phone" 
                                   id="phone" 
                                   value="{{ old('phone') }}"
                                   class="w-full px-4 py-3 border border-gray-300 rounded-xl form-input focus:outline-none focus:border-primary focus:ring-2 focus:ring-primary/20 transition"
                                   placeholder="+63 912 345 6789">
                            @error('phone')
                                <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Password -->
                        <div>
                            <label for="password" class="block text-sm font-medium text-gray-700 mb-2">
                                <i class="fas fa-lock text-primary mr-2"></i>Password <span class="text-red-500">*</span>
                            </label>
                            <input type="password" 
                                   name="password" 
                                   id="password" 
                                   class="w-full px-4 py-3 border border-gray-300 rounded-xl form-input focus:outline-none focus:border-primary focus:ring-2 focus:ring-primary/20 transition @error('password') border-red-500 @enderror"
                                   placeholder="••••••••"
                                   required>
                            @error('password')
                                <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Confirm Password -->
                        <div>
                            <label for="password_confirmation" class="block text-sm font-medium text-gray-700 mb-2">
                                <i class="fas fa-lock text-primary mr-2"></i>Confirm Password <span class="text-red-500">*</span>
                            </label>
                            <input type="password" 
                                   name="password_confirmation" 
                                   id="password_confirmation" 
                                   class="w-full px-4 py-3 border border-gray-300 rounded-xl form-input focus:outline-none focus:border-primary focus:ring-2 focus:ring-primary/20 transition"
                                   placeholder="••••••••"
                                   required>
                        </div>
                    </div>
                </div>

                <!-- Form Actions -->
                <div class="mt-8 pt-6 border-t border-gray-200 flex items-center justify-end space-x-4">
                    <a href="{{ route('admin.dashboard') }}" 
                       class="px-6 py-3 border border-gray-300 rounded-xl text-gray-700 font-medium hover:bg-gray-50 transition flex items-center space-x-2">
                        <span>Cancel</span>
                    </a>
                    <button type="submit" 
                            class="px-8 py-3 bg-gradient-to-r from-primary to-primaryDark text-white rounded-xl font-medium hover:opacity-90 transition flex items-center space-x-3 shadow-lg hover:shadow-xl">
                        <span>Create Technician Account</span>
                    </button>
                </div>
            </form>
        </div>

    </div>

    <!-- JavaScript -->
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            // Password strength indicator
            const passwordInput = document.getElementById('password');
            if (passwordInput) {
                passwordInput.addEventListener('input', function() {
                    const password = this.value;
                    let strength = 0;
                    
                    if (password.length >= 8) strength++;
                    if (password.match(/[a-z]+/)) strength++;
                    if (password.match(/[A-Z]+/)) strength++;
                    if (password.match(/[0-9]+/)) strength++;
                    if (password.match(/[$@#&!]+/)) strength++;
                });
            }

            // Form submission handling for checkboxes
            const form = document.querySelector('form');
            if (form) {
                form.addEventListener('submit', function(e) {
                    // Handle is_active checkbox
                    const isActiveCheckbox = document.getElementById('is_active');
                    if (isActiveCheckbox && !isActiveCheckbox.checked) {
                        const hiddenInput = document.createElement('input');
                        hiddenInput.type = 'hidden';
                        hiddenInput.name = 'is_active';
                        hiddenInput.value = '0';
                        form.appendChild(hiddenInput);
                        isActiveCheckbox.removeAttribute('name');
                    }
                    
                    // Handle email_verified checkbox
                    const emailVerifiedCheckbox = document.getElementById('email_verified');
                    if (emailVerifiedCheckbox && !emailVerifiedCheckbox.checked) {
                        const hiddenInput = document.createElement('input');
                        hiddenInput.type = 'hidden';
                        hiddenInput.name = 'email_verified';
                        hiddenInput.value = '0';
                        form.appendChild(hiddenInput);
                        emailVerifiedCheckbox.removeAttribute('name');
                    }
                });
            }
        });
    </script>
</body>
</html>