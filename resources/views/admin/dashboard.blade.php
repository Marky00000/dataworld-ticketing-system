<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard - Dataworld Support Portal</title>
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

                <!-- Bolder divider -->
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
                
                <!-- New Ticket Button - Keep colored -->
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
                
                <!-- Sign Out Button - Keep red -->
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

<!-- Add Vue.js for mobile menu functionality -->
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
    <!-- Main Content (Everything below remains EXACTLY the same) -->
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">

            @if(session('success'))
            <div class="mb-6 bg-green-100 border-l-4 border-green-500 text-green-700 p-4 rounded-lg flex items-center justify-between shadow-md" role="alert">
                <div class="flex items-center space-x-3">
                    <div class="w-8 h-8 bg-green-200 rounded-full flex items-center justify-center">
                        <i class="fas fa-check-circle text-green-600 text-xl"></i>
                    </div>
                    <div>
                        <p class="font-medium">{{ session('success') }}</p>
                        <p class="text-xs text-green-600 mt-0.5">The technician can now log in with their credentials.</p>
                    </div>
                </div>
                <button type="button" class="text-green-700 hover:text-green-900 transition" onclick="this.parentElement.remove()">
                    <i class="fas fa-times"></i>
                </button>
            </div>
            @endif
        <!-- Welcome Banner -->
        <div class="bg-gradient-to-r from-primary to-primaryDark rounded-2xl p-6 text-white mb-8">
            <div class="flex flex-col md:flex-row md:items-center justify-between">
                <div>
                    <h1 class="text-2xl md:text-3xl font-bold mb-2">Welcome back, {{ auth()->user()->name }}! 👋</h1>
                    <p class="text-primary-100">Here's what's happening with your support tickets today.</p>
                </div>
            </div>
        </div>

     <!-- Stats Cards -->
 <!-- Stats Cards - Admin Dashboard (with side colors) -->
<div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6 mb-8">
    
    @php
        use App\Models\Ticket;
        use App\Models\User;
        
        // Total Tickets
        $totalTickets = Ticket::count();
        
        // Open Tickets
        $openTickets = Ticket::whereIn('status', ['open', 'pending'])->count();
        
        // In Progress
        $inProgressTickets = Ticket::where('status', 'in_progress')->count();
        
        // Resolved Today
        $resolvedToday = Ticket::whereDate('resolved_at', now()->toDateString())
            ->whereIn('status', ['resolved', 'closed'])
            ->count();
        
        // Active Technicians
        $activeTechs = User::where('user_type', 'tech')->count();
        
        // Unassigned Tickets
        $unassignedTickets = Ticket::whereNull('assigned_to')
            ->whereNotIn('status', ['resolved', 'closed'])
            ->count();
        
        // High Priority
        $highPriorityCount = Ticket::where('priority', 'high')
            ->whereNotIn('status', ['resolved', 'closed'])
            ->count();
        
        // New This Week
        $newThisWeek = Ticket::where('created_at', '>=', now()->startOfWeek())->count();
        
        // Resolved this month
        $resolvedMonth = Ticket::whereIn('status', ['resolved', 'closed'])
            ->whereMonth('resolved_at', now()->month)
            ->count();
        
        // Average resolution time
        $avgResolutionTime = Ticket::whereNotNull('resolved_at')
            ->whereIn('status', ['resolved', 'closed'])
            ->get()
            ->map(function($ticket) {
                return $ticket->created_at->diffInHours($ticket->resolved_at);
            })
            ->avg();
        
        $avgResolution = $avgResolutionTime ? number_format($avgResolutionTime, 1) . 'h' : '0h';
    @endphp
    
    <!-- Card 1: Total Tickets -->
    <div class="bg-white rounded-xl shadow-md p-6 dashboard-card border-l-4 border-blue-500">
        <div class="flex items-center justify-between">
            <div>
                <p class="text-gray-500 text-sm font-medium">Total Tickets</p>
                <p class="text-3xl font-bold text-gray-900 mt-2">{{ $totalTickets }}</p>
            </div>
            <div class="w-12 h-12 bg-blue-100 rounded-xl flex items-center justify-center">
                <i class="fas fa-ticket-alt text-blue-600 text-xl"></i>
            </div>
        </div>
        <div class="mt-4 flex items-center text-xs">
            <span class="text-blue-600 font-medium flex items-center">
                <i class="fas fa-calendar mr-1 text-xs"></i>
                {{ $newThisWeek }} new this week
            </span>
        </div>
    </div>
    
    <!-- Card 2: Open Tickets -->
    <div class="bg-white rounded-xl shadow-md p-6 dashboard-card border-l-4 border-yellow-500">
        <div class="flex items-center justify-between">
            <div>
                <p class="text-gray-500 text-sm font-medium">Open Tickets</p>
                <p class="text-3xl font-bold text-gray-900 mt-2">{{ $openTickets }}</p>
            </div>
            <div class="w-12 h-12 bg-yellow-100 rounded-xl flex items-center justify-center">
                <i class="fas fa-folder-open text-yellow-600 text-xl"></i>
            </div>
        </div>
        <div class="mt-4 flex items-center text-xs">
            <span class="text-yellow-600 font-medium flex items-center">
                <i class="fas fa-spinner mr-1 text-xs"></i>
                {{ $inProgressTickets }} in progress
            </span>
        </div>
    </div>
    
    <!-- Card 3: High Priority -->
    <div class="bg-white rounded-xl shadow-md p-6 dashboard-card border-l-4 border-red-500">
        <div class="flex items-center justify-between">
            <div>
                <p class="text-gray-500 text-sm font-medium">High Priority</p>
                <p class="text-3xl font-bold text-gray-900 mt-2">{{ $highPriorityCount }}</p>
            </div>
            <div class="w-12 h-12 bg-red-100 rounded-xl flex items-center justify-center">
                <i class="fas fa-exclamation-triangle text-red-600 text-xl"></i>
            </div>
        </div>
        <div class="mt-4 flex items-center text-xs">
            @if($highPriorityCount > 0)
                <span class="text-red-600 font-medium flex items-center">
                    <i class="fas fa-bell mr-1 text-xs"></i>
                    Needs attention
                </span>
            @else
                <span class="text-gray-500 font-medium">
                    No critical issues
                </span>
            @endif
        </div>
    </div>
    
    <!-- Card 4: Performance -->
    <div class="bg-white rounded-xl shadow-md p-6 dashboard-card border-l-4 border-green-500">
        <div class="flex items-center justify-between">
            <div>
                <p class="text-gray-500 text-sm font-medium">Performance</p>
                <p class="text-3xl font-bold text-gray-900 mt-2">{{ $resolvedToday }}</p>
            </div>
            <div class="w-12 h-12 bg-green-100 rounded-xl flex items-center justify-center">
                <i class="fas fa-check-circle text-green-600 text-xl"></i>
            </div>
        </div>
        <div class="mt-4 flex items-center text-xs">
            <span class="text-green-600 font-medium flex items-center">
                <i class="fas fa-clock mr-1 text-xs"></i>
                Avg: {{ $avgResolution }}
            </span>
        </div>
    </div>
</div>

<div class="grid grid-cols-1 gap-8">
                <!-- Recent Tickets - Full Width -->
                <div>
                    <div class="bg-white rounded-xl shadow-md overflow-hidden border border-gray-200">
                        <div class="px-6 py-4 border-b border-gray-200 bg-gray-50">
                            <div class="flex items-center justify-between">
                                <h2 class="text-lg font-semibold text-gray-800 flex items-center">
                                    Your Recent Support Requests
                                </h2>
                                <a href="{{ route('tickets.index') }}" class="text-primary hover:text-primaryDark text-sm font-medium inline-flex items-center">
                                    View All Tickets <i class="fas fa-arrow-right ml-2 text-xs"></i>
                                </a>
                            </div>
                        </div>
                        
                        <div class="divide-y divide-gray-200 max-h-[500px] overflow-y-auto custom-scrollbar">
                            @forelse($recentTickets ?? [] as $ticket)
                            <div class="relative p-6 hover:bg-gray-50 transition cursor-pointer group ticket-item" 
                                onclick="window.location.href='{{ route('tickets.my_tickets_view', $ticket->id) }}'">

                                <div class="absolute left-0 top-0 h-full w-1 rounded-l-lg opacity-0 group-hover:opacity-100 transition-opacity duration-200
                                    @if($ticket->priority === 'high') bg-red-500
                                    @elseif($ticket->priority === 'medium') bg-yellow-500
                                    @elseif($ticket->priority === 'low') bg-green-500
                                    @endif">
                                </div>

                                <div class="flex items-start justify-between pl-2">
                                    <div class="flex-1">

                                        <!-- Badge Row -->
                                        <div class="flex items-start justify-between mb-2">

                                            <!-- LEFT: Priority + Status -->
                                            <div class="flex items-center space-x-2">

                                                <!-- Priority Badge - White theme -->
                                                @if($ticket->priority === 'high')
                                                    <span class="inline-flex items-center px-3 py-1.5 rounded-full text-xs font-medium bg-red-100 text-red-800 border border-red-200">
                                                        High Priority
                                                    </span>
                                                @elseif($ticket->priority === 'medium')
                                                    <span class="inline-flex items-center px-3 py-1.5 rounded-full text-xs font-medium bg-yellow-100 text-yellow-800 border border-yellow-200">
                                                        Medium Priority
                                                    </span>
                                                @elseif($ticket->priority === 'low')
                                                    <span class="inline-flex items-center px-3 py-1.5 rounded-full text-xs font-medium bg-green-100 text-green-800 border border-green-200">
                                                        Low Priority
                                                    </span>
                                                @endif

                                                <!-- Status Badge - White theme -->
                                                @if($ticket->status === 'in_progress')
                                                    <span class="inline-flex items-center px-3 py-1.5 rounded-full text-xs font-medium bg-blue-100 text-blue-800 border border-blue-200">
                                                        In Progress
                                                    </span>
                                                @elseif($ticket->status === 'open')
                                                    <span class="inline-flex items-center px-3 py-1.5 rounded-full text-xs font-medium bg-green-100 text-green-800 border border-green-200">
                                                        Open
                                                    </span>
                                                @elseif($ticket->status === 'pending')
                                                    <span class="inline-flex items-center px-3 py-1.5 rounded-full text-xs font-medium bg-yellow-100 text-yellow-800 border border-yellow-200">
                                                        Pending
                                                    </span>
                                                @elseif($ticket->status === 'resolved')
                                                    <span class="inline-flex items-center px-3 py-1.5 rounded-full text-xs font-medium bg-purple-100 text-purple-800 border border-purple-200">
                                                        Resolved
                                                    </span>
                                                @elseif($ticket->status === 'closed')
                                                    <span class="inline-flex items-center px-3 py-1.5 rounded-full text-xs font-medium bg-gray-100 text-gray-800 border border-gray-300">
                                                        Closed
                                                    </span>
                                                @endif

                                            </div>

                                            <!-- RIGHT: Ticket Number -->
                                            <span class="text-xs text-gray-500 font-mono bg-gray-100 px-3 py-1 rounded-md whitespace-nowrap border border-gray-200">
                                                {{ $ticket->ticket_number }}
                                            </span>

                                        </div>

                                        <h3 class="font-medium text-gray-900 mb-2">{{ $ticket->subject }}</h3>

                                        <p class="text-gray-600 text-sm mb-3 line-clamp-2">
                                            {{ Str::limit($ticket->description, 100) }}
                                        </p>

                                        <div class="flex flex-wrap items-center gap-4 text-xs text-gray-500">
                                            <span class="flex items-center">
                                                <i class="fas fa-calendar mr-1.5 text-gray-400"></i>
                                                {{ $ticket->created_at->format('M d, Y - g:i A') }}
                                            </span>

                                            @if($ticket->creator)
                                                <span class="flex items-center">
                                                    <i class="fas fa-user mr-1.5 text-gray-400"></i>
                                                    {{ $ticket->creator->name ?? 'Unknown' }}
                                                </span>
                                            @endif

                                            @if($ticket->assignedTech)
                                                <span class="flex items-center">
                                                    <i class="fas fa-user-tie mr-1.5 text-gray-400"></i>
                                                    {{ $ticket->assignedTech->name }}
                                                </span>
                                            @else
                                                <span class="flex items-center">
                                                    <i class="fas fa-user-clock mr-1.5 text-gray-400"></i>
                                                    Unassigned
                                                </span>
                                            @endif
                                        </div>
                                    </div>

                                    <i class="fas fa-chevron-right text-gray-400 mt-8 ml-4 group-hover:text-primary transition"></i>
                                </div>
                            </div>
                            @empty
                            <div class="p-12 text-center">
                                <div class="flex flex-col items-center justify-center">
                                    <div class="w-20 h-20 bg-gray-100 rounded-full flex items-center justify-center mb-4">
                                        <i class="fas fa-ticket-alt text-gray-400 text-3xl"></i>
                                    </div>
                                    <h3 class="text-lg font-medium text-gray-700 mb-2">No tickets yet</h3>
                                    <p class="text-gray-500 text-sm mb-6">Create your first support ticket to get help</p>
                                    <a href="{{ route('tickets.create') }}" 
                                       class="inline-flex items-center space-x-2 bg-primary hover:bg-primaryDark text-white px-6 py-3 rounded-lg font-medium transition shadow-md">
                                        <i class="fas fa-plus-circle"></i>
                                        <span>Create New Ticket</span>
                                    </a>
                                </div>
                            </div>
                            @endforelse
                        </div>
                    </div>
                </div>
            </div>
    </div>

    <!-- Footer -->
    <footer class="bg-gray-900 text-gray-400 py-8 mt-12">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="border-t border-gray-800 pt-8 text-center text-sm">
                <p>
                    © Dataworld Computer Center. All rights reserved.
                </p>
            </div>
        </div>
    </footer>

    <!-- JavaScript -->
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            // User dropdown hover
            const userDropdown = document.querySelector('.relative.group');
            if (userDropdown) {
                const dropdown = userDropdown.querySelector('.absolute');
                
                userDropdown.addEventListener('mouseenter', function() {
                    dropdown.classList.remove('opacity-0', 'invisible');
                    dropdown.classList.add('opacity-100', 'visible');
                });
                
                userDropdown.addEventListener('mouseleave', function() {
                    dropdown.classList.remove('opacity-100', 'visible');
                    dropdown.classList.add('opacity-0', 'invisible');
                });
            }
            
            // Initialize tooltips
            const tooltips = document.querySelectorAll('[data-tooltip]');
            tooltips.forEach(element => {
                element.addEventListener('mouseenter', function() {
                    const tooltipText = this.getAttribute('data-tooltip');
                    const tooltip = document.createElement('div');
                    tooltip.className = 'absolute z-50 px-3 py-2 text-sm text-white bg-gray-900 rounded-lg shadow-lg';
                    tooltip.textContent = tooltipText;
                    tooltip.style.top = (this.getBoundingClientRect().top - 40) + 'px';
                    tooltip.style.left = (this.getBoundingClientRect().left + this.offsetWidth/2) + 'px';
                    tooltip.style.transform = 'translateX(-50%)';
                    tooltip.id = 'tooltip-' + Date.now();
                    document.body.appendChild(tooltip);
                    this.dataset.tooltipId = tooltip.id;
                });
                
                element.addEventListener('mouseleave', function() {
                    if (this.dataset.tooltipId) {
                        const tooltip = document.getElementById(this.dataset.tooltipId);
                        if (tooltip) {
                            tooltip.remove();
                        }
                    }
                });
            });
        });
    </script>
</body>
</html>