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
        
        /* Setting item hover */
        .setting-item {
            transition: all 0.2s ease;
            cursor: pointer;
            border-left: 3px solid transparent;
        }
        
        .setting-item:hover {
            background-color: #f9fafb;
            border-left-color: #6366f1;
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

        /* Backdrop blur support */
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

        /* Status badges */
        .status-badge {
            padding: 0.25rem 0.75rem;
            border-radius: 9999px;
            font-size: 0.75rem;
            font-weight: 500;
            display: inline-flex;
            align-items: center;
        }
        
        .status-badge.success {
            background: #d1fae5;
            color: #065f46;
        }
        
        .status-badge.warning {
            background: #fed7aa;
            color: #92400e;
        }
        
        .status-badge.info {
            background: #dbeafe;
            color: #1e40af;
        }

        /* Gradient backgrounds */
        .gradient-bg-primary {
            background: linear-gradient(135deg, #6366f1, #8b5cf6);
        }
    </style>
</head>
<body class="bg-gray-50 min-h-screen">

<div id="app" class="min-h-screen flex flex-col">
    
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

                <!-- New Ticket Button -->
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
                                    Administrator Account
                                @elseif(auth()->user()->user_type === 'tech')
                                    Technician Account
                                @else
                                    Client Account
                                @endif
                            </span>
                        </div>
                        </div>
                        
                        <!-- Menu items -->
                        <div class="border-t border-gray-100 my-1"></div>
                        
                        <a href="{{ route('profile.dashboard') }}" 
                           class="flex items-center px-5 py-3 text-sm text-gray-700 hover:bg-gray-50 transition-all duration-200 bg-secondary/5">
                            <i class="fas fa-user-circle w-5 text-secondary mr-3"></i>
                            <span class="flex-1 font-medium text-secondary">My Profile</span>
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
            
            <!-- Mobile menu button -->
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
    
    <!-- Mobile Menu -->
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
                <a href="/dashboard" @click="menuOpen = false"
                   class="flex items-center space-x-3 px-4 py-3 text-gray-600 hover:text-primary rounded-xl transition-all duration-300 group">
                    <div class="w-10 h-10 bg-gray-100 group-hover:bg-primary/10 rounded-xl flex items-center justify-center">
                        <i class="fas fa-home text-gray-500 group-hover:text-primary"></i>
                    </div>
                    <div>
                        <p class="font-medium text-gray-700">Dashboard</p>
                    </div>
                </a>
                
                <a href="/tickets" @click="menuOpen = false"
                   class="flex items-center space-x-3 px-4 py-3 text-gray-600 hover:text-primary rounded-xl transition-all duration-300 group">
                    <div class="w-10 h-10 bg-gray-100 group-hover:bg-primary/10 rounded-xl flex items-center justify-center">
                        <i class="fas fa-ticket-alt text-gray-500 group-hover:text-primary"></i>
                    </div>
                    <div>
                        <p class="font-medium text-gray-700">My Tickets</p>
                    </div>
                </a>
                
                <a href="/tickets/create" @click="menuOpen = false"
                   class="flex items-center space-x-3 px-4 py-3 bg-gradient-to-r from-primary to-primaryDark text-white rounded-xl font-medium">
                    <div class="w-10 h-10 bg-white/20 rounded-xl flex items-center justify-center">
                        <i class="fas fa-plus-circle text-white"></i>
                    </div>
                    <div>
                        <p class="font-medium text-white">New Ticket</p>
                    </div>
                </a>
                
                @if(auth()->user()->user_type === 'admin')
                <div class="border-t border-gray-200 pt-4 mt-2">
                    <a href="{{ route('admin.tech.create') }}" @click="menuOpen = false"
                       class="flex items-center space-x-3 px-4 py-3 text-blue-600 hover:bg-blue-50 rounded-xl transition-all duration-300 group border border-blue-100">
                        <div class="w-10 h-10 bg-blue-100 group-hover:bg-blue-200 rounded-xl flex items-center justify-center">
                            <i class="fas fa-user-plus text-blue-600"></i>
                        </div>
                        <div>
                            <p class="font-medium text-blue-600">Create Tech Account</p>
                        </div>
                    </a>
                </div>
                @endif
                
                <div class="border-t border-gray-200 pt-4 mt-2"></div>
                
                <!-- Profile & Settings -->
                <a href="{{ route('profile.dashboard') }}" @click="menuOpen = false"
                   class="flex items-center space-x-3 px-4 py-3 text-gray-600 hover:text-primary rounded-xl transition-all duration-300 group">
                    <div class="w-10 h-10 bg-gray-100 group-hover:bg-primary/10 rounded-xl flex items-center justify-center">
                        <i class="fas fa-user text-gray-500 group-hover:text-primary"></i>
                    </div>
                    <div>
                        <p class="font-medium text-gray-700">My Profile</p>
                    </div>
                </a>
                
                <!-- Sign Out -->
                <form method="POST" action="{{ route('sign-out') }}" class="mt-4">
                    @csrf
                    <button type="submit" 
                            class="flex items-center space-x-3 px-4 py-3 text-red-600 hover:bg-red-50 rounded-xl transition-all duration-300 w-full">
                        <i class="fas fa-sign-out-alt text-red-500"></i>
                        <span>Sign Out</span>
                    </button>
                </form>
            </div>
        </div>
    </transition>
</nav>

<script src="https://cdn.jsdelivr.net/npm/vue@3.5.13/dist/vue.global.min.js"></script>
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
    <main class="flex-1">
        <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
            <!-- Breadcrumb -->
            <div class="flex items-center text-sm text-gray-500">
                <a href="/dashboard" class="hover:text-primary transition breadcrumb-hover">
                Dashboard
                </a>
                <i class="fas fa-chevron-right mx-2 text-xs text-gray-400"></i>
                <span class="text-gray-700 font-medium flex items-center">
                 My Profile
                </span>
            </div>

            <!-- Page Header -->
            <div class="mb-8 text-center">
                <h1 class="text-3xl font-bold text-gray-900">Profile Settings</h1>
                <p class="text-gray-500 mt-1">Manage your account information and preferences</p>
            </div>

            <!-- Settings Cards -->
            <div class="space-y-6">
                <!-- Account Settings Card -->
                <div class="bg-white rounded-2xl shadow-sm overflow-hidden card-hover border border-gray-100">
                    <div class="px-6 py-5 border-b border-gray-200 bg-gradient-to-r from-primary/5 to-transparent">
                        <div class="flex items-center justify-between">
                            <h3 class="text-lg font-semibold text-gray-900 flex items-center">
                                <div class="w-8 h-8 bg-primary/10 rounded-lg flex items-center justify-center mr-3">
                                    <i class="fas fa-user-cog text-primary text-sm"></i>
                                </div>
                                Account Settings
                            </h3>
                            <span class="text-xs bg-gray-100 text-gray-600 px-3 py-1.5 rounded-full">2 options</span>
                        </div>
                        <p class="text-sm text-gray-500 mt-1 ml-11">Manage your account preferences and security</p>
                    </div>
                    <div class="divide-y divide-gray-200">
                        <a href="{{ route('profile.edit') }}" class="block px-6 py-5 setting-item hover:bg-gray-50 transition group">
                            <div class="flex items-center justify-between">
                                <div class="flex items-center space-x-4">
                                    <div class="w-14 h-14 bg-gradient-to-br from-primary/10 to-primary/5 rounded-xl flex items-center justify-center group-hover:scale-110 transition-transform">
                                        <i class="fas fa-id-card text-primary text-2xl"></i>
                                    </div>
                                    <div>
                                        <p class="font-medium text-gray-900 text-lg">Personal Information</p>
                                        <p class="text-sm text-gray-500 mt-0.5">Update your name, email, and contact details</p>
                                        <div class="flex items-center mt-2 space-x-2">
                                        </div>
                                    </div>
                                </div>
                                <div class="flex items-center mr-2">
                                    <span class="text-sm text-gray-400 mr-3 group-hover:text-primary transition-colors">Update</span>
                                    <i class="fas fa-chevron-right text-gray-400 group-hover:text-primary group-hover:translate-x-1 transition-all"></i>
                                </div>
                            </div>
                        </a>
                        
                        <a href="{{ route('profile.password') }}" class="block px-6 py-5 setting-item hover:bg-gray-50 transition group">
                            <div class="flex items-center justify-between">
                                <div class="flex items-center space-x-4">
                                    <div class="w-14 h-14 bg-gradient-to-br from-red-50 to-red-100 rounded-xl flex items-center justify-center group-hover:scale-110 transition-transform">
                                        <i class="fas fa-lock text-red-600 text-2xl"></i>
                                    </div>
                                    <div>
                                        <p class="font-medium text-gray-900 text-lg">Security</p>
                                        <p class="text-sm text-gray-500 mt-0.5">Change your password and security settings</p>
                                        <div class="flex items-center mt-2 space-x-2">
                                        </div>
                                    </div>
                                </div>
                                <div class="flex items-center mr-2">
                                    <span class="text-sm text-gray-400 mr-3 group-hover:text-primary transition-colors">Change</span>
                                    <i class="fas fa-chevron-right text-gray-400 group-hover:text-primary group-hover:translate-x-1 transition-all"></i>
                                </div>
                            </div>
                        </a>
                    </div>
                </div>

            </div>
        </div>
    </main>

    <!-- Footer -->
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
</div>

<!-- JavaScript for profile functions -->
<script>
    document.addEventListener('DOMContentLoaded', function() {
        // Smooth scroll for anchor links
        document.querySelectorAll('a[href^="#"]').forEach(anchor => {
            anchor.addEventListener('click', function (e) {
                e.preventDefault();
                document.querySelector(this.getAttribute('href')).scrollIntoView({
                    behavior: 'smooth'
                });
            });
        });
    });

    // Two-factor authentication
    function enable2FA() {
        alert('Two-factor authentication setup will be available soon.');
    }
</script>

</body>
</html>