<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>My Dashboard - Dataworld Support Portal</title>
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
        .status-pending { background: #fff3e0; color: #e65100; }
        .status-closed { background: #f3f4f6; color: #374151; }
        
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
        
        /* Fix for footer positioning */
        html, body {
            height: 100%;
            margin: 0;
        }
        
        body {
            display: flex;
            flex-direction: column;
            min-height: 100vh;
        }
        
        main {
            flex: 1 0 auto;
        }
        
        footer {
            flex-shrink: 0;
        }
    </style>
</head>
<body class="bg-gray-50 min-h-screen flex flex-col">
    <!-- Top Navigation Bar -->
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
                <!-- Navigation Links with hover effects -->
                <a href="/dashboard" class="text-primary font-medium transition-all duration-300 flex items-center space-x-2 relative group">
                    <i class="fas fa-home"></i>
                    <span>Dashboard</span>
                    <span class="absolute -bottom-1 left-0 w-0 h-0.5 bg-primary group-hover:w-full transition-all duration-300"></span>
                </a>
                
                <a href="/tickets" class="text-gray-700 hover:text-primary font-medium transition-all duration-300 flex items-center space-x-2 relative group">
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
                                <p class="text-xs text-gray-500 flex items-center">
                                </p>
                            </div>
                        </div>
                        <i class="fas fa-chevron-down text-gray-400 text-sm transition-transform duration-300 group-hover:rotate-180"></i>
                    </button>
                    
                    <!-- Dropdown Menu - Using hover functionality -->
                    <div class="absolute right-0 mt-2 w-64 bg-white rounded-xl shadow-2xl py-2 z-50 opacity-0 invisible group-hover:opacity-100 group-hover:visible transition-all duration-300 border border-primary/10 transform origin-top-right scale-95 group-hover:scale-100">
                        
                        <div class="px-4 py-4 border-b border-gray-100">
                        <div class="flex items-center space-x-3">
                            <div class="w-12 h-12 bg-gradient-to-br from-primary to-primaryDark rounded-full flex items-center justify-center text-white font-bold text-lg shadow-md">
                                {{ substr(auth()->user()->name, 0, 1) }}
                            </div>
                            <div class="flex-1 min-w-0">
                                <p class="text-sm font-bold text-gray-900 truncate">{{ auth()->user()->name }}</p>
                                <p class="text-xs text-gray-500 truncate">{{ auth()->user()->email }}</p>
                                <span class="inline-flex items-center mt-1 px-2 py-0.5 rounded-full text-xs font-medium bg-primary/10 text-primary">
                                    <i class="fas fa-user mr-1 text-[8px]"></i>
                                    Client Account
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
                        <span class="inline-flex items-center px-2 py-0.5 rounded-full text-xs font-medium bg-primary/10 text-primary">
                            <i class="fas fa-crown mr-1 text-[8px]"></i>
                            Client
                        </span>
                        <span class="inline-flex items-center text-xs text-gray-500">
                            <i class="fas fa-circle text-green-500 text-[6px] mr-1"></i>
                            Online
                        </span>
                    </div>
                </div>
            </div>
            
            <!-- Navigation Items with improved design -->
            <a href="/dashboard" 
               class="flex items-center space-x-3 px-4 py-3 text-primary bg-primary/5 rounded-xl transition-all duration-300 border border-primary/20">
                <div class="w-10 h-10 bg-primary/10 rounded-xl flex items-center justify-center">
                    <i class="fas fa-home text-primary"></i>
                </div>
                <div class="flex-1">
                    <p class="font-semibold text-gray-900">Dashboard</p>
                    <p class="text-xs text-gray-500">Overview & statistics</p>
                </div>
                <i class="fas fa-chevron-right text-primary"></i>
            </a>
            
            <a href="/tickets" 
               class="flex items-center space-x-3 px-4 py-3 text-gray-700 hover:bg-gray-50 rounded-xl transition-all duration-300 group">
                <div class="w-10 h-10 bg-gray-100 group-hover:bg-primary/10 rounded-xl flex items-center justify-center transition-colors">
                    <i class="fas fa-ticket-alt text-gray-500 group-hover:text-primary"></i>
                </div>
                <div class="flex-1">
                    <div class="flex items-center justify-between">
                        <p class="font-medium text-gray-900">My Tickets</p>
                        <span class="text-xs bg-primary/10 text-primary px-2 py-0.5 rounded-full">3 new</span>
                    </div>
                    <p class="text-xs text-gray-500">View your support tickets</p>
                </div>
            </a>
            
            <a href="/tickets/create" 
               class="flex items-center space-x-3 px-4 py-3 text-gray-700 hover:bg-gray-50 rounded-xl transition-all duration-300 group">
                <div class="w-10 h-10 bg-gray-100 group-hover:bg-primary/10 rounded-xl flex items-center justify-center transition-colors">
                    <i class="fas fa-plus-circle text-gray-500 group-hover:text-primary"></i>
                </div>
                <div class="flex-1">
                    <p class="font-medium text-gray-900">New Ticket</p>
                    <p class="text-xs text-gray-500">Create a support request</p>
                </div>
            </a>
            
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
            
            <a href="/settings" 
               class="flex items-center space-x-3 px-4 py-3 text-gray-700 hover:bg-gray-50 rounded-xl transition-all duration-300 group">
                <div class="w-10 h-10 bg-gray-100 group-hover:bg-primary/10 rounded-xl flex items-center justify-center transition-colors">
                    <i class="fas fa-cog text-gray-500 group-hover:text-primary"></i>
                </div>
                <div class="flex-1">
                    <p class="font-medium text-gray-900">Settings</p>
                    <p class="text-xs text-gray-500">Preferences & security</p>
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
                    <i class="fas fa-arrow-right-from-bracket text-red-400 group-hover:translate-x-1 transition-all"></i>
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

<!-- Add these styles to your existing style section -->
<style>
    /* Smooth transitions for mobile menu */
    [x-cloak] { display: none !important; }
    
    /* Backdrop blur support */
    .backdrop-blur-md {
        backdrop-filter: blur(12px);
        -webkit-backdrop-filter: blur(12px);
    }
    
    /* Animation for dropdown */
    @keyframes slideDown {
        from {
            opacity: 0;
            transform: translateY(-10px);
        }
        to {
            opacity: 1;
            transform: translateY(0);
        }
    }
    
    /* Ensure dropdown appears above other elements */
    .absolute {
        z-index: 1000;
    }
    
    /* Cursor pointer for clickable elements */
    button.cursor-pointer {
        cursor: pointer;
    }
    
    /* Smooth hover transitions */
    .group:hover .group-hover\:rotate-180 {
        transform: rotate(180deg);
    }
    
    .group:hover .group-hover\:scale-100 {
        transform: scale(1);
    }
    
    .group:hover .group-hover\:visible {
        visibility: visible;
    }
    
    .group:hover .group-hover\:opacity-100 {
        opacity: 1;
    }
</style>

    <!-- Main Content - Added flex-1 to push footer down -->
    <main class="flex-1">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
            <!-- Welcome Banner with Quick Stats -->
            <div class="bg-gradient-to-r from-primary to-primaryDark rounded-2xl p-6 text-white mb-8">
                <div class="flex flex-col md:flex-row md:items-center justify-between">
                    <div class="mb-6 md:mb-0">
                        <h1 class="text-2xl md:text-3xl font-bold mb-2">Welcome to Your Support Dashboard, {{ auth()->user()->name }}! 👋</h1>
                        <p class="text-primary-100">Track your support tickets and get help when you need it.</p>
                    </div>
                </div>
            </div>

            <!-- Quick Stats Cards - User Dashboard -->
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6 mb-8">
                <div class="bg-white rounded-xl shadow-md p-6 dashboard-card">
                    <div class="flex items-center justify-between">
                        <div>
                            <p class="text-gray-500 text-sm font-medium">Active Tickets</p>
                            <p class="text-3xl font-bold text-gray-800 mt-2">{{ $ticketStats['active'] ?? 0 }}</p>
                        </div>
                        <div class="w-12 h-12 bg-blue-100 rounded-full flex items-center justify-center">
                            <i class="fas fa-clock text-blue-600 text-xl"></i>
                        </div>
                    </div>
                    <div class="mt-4">
                        <a href="{{ route('tickets.index', ['status' => 'active']) }}" class="text-sm text-primary hover:text-primaryDark font-medium">
                            View all active tickets <i class="fas fa-arrow-right ml-1"></i>
                        </a>
                    </div>
                </div>
                
                <div class="bg-white rounded-xl shadow-md p-6 dashboard-card">
                    <div class="flex items-center justify-between">
                        <div>
                            <p class="text-gray-500 text-sm font-medium">Awaiting Response</p>
                            <p class="text-3xl font-bold text-gray-800 mt-2">{{ $ticketStats['awaiting'] ?? 0 }}</p>
                        </div>
                        <div class="w-12 h-12 bg-orange-100 rounded-full flex items-center justify-center">
                            <i class="fas fa-comment-dots text-orange-600 text-xl"></i>
                        </div>
                    </div>
                    <div class="mt-4">
                        @if(($ticketStats['awaiting'] ?? 0) > 0)
                            <span class="text-xs text-orange-600 font-medium">
                                <i class="fas fa-exclamation-circle mr-1"></i>
                                Needs your attention
                            </span>
                        @else
                            <span class="text-xs text-gray-500 font-medium">
                                <i class="fas fa-check-circle mr-1"></i>
                                All caught up
                            </span>
                        @endif
                    </div>
                </div>
                
                <div class="bg-white rounded-xl shadow-md p-6 dashboard-card">
                    <div class="flex items-center justify-between">
                        <div>
                            <p class="text-gray-500 text-sm font-medium">Resolved This Month</p>
                            <p class="text-3xl font-bold text-gray-800 mt-2">{{ $ticketStats['resolved_month'] ?? 0 }}</p>
                        </div>
                        <div class="w-12 h-12 bg-green-100 rounded-full flex items-center justify-center">
                            <i class="fas fa-check-circle text-green-600 text-xl"></i>
                        </div>
                    </div>
                    <div class="mt-4">
                        @php
                            $percentageChange = $ticketStats['percentage_change'] ?? 0;
                            $changeClass = $percentageChange >= 0 ? 'text-green-600' : 'text-red-600';
                            $arrowIcon = $percentageChange >= 0 ? 'arrow-up' : 'arrow-down';
                        @endphp
                        <span class="text-xs {{ $changeClass }} font-medium">
                            <i class="fas fa-{{ $arrowIcon }} mr-1"></i>
                            {{ abs($percentageChange) }}% from last month
                        </span>
                    </div>
                </div>
                
                <div class="bg-white rounded-xl shadow-md p-6 dashboard-card">
                    <div class="flex items-center justify-between">
                        <div>
                            <p class="text-gray-500 text-sm font-medium">Avg. Resolution Time</p>
                            <p class="text-3xl font-bold text-gray-800 mt-2">{{ $ticketStats['avg_resolution'] ?? '0h' }}</p>
                        </div>
                        <div class="w-12 h-12 bg-purple-100 rounded-full flex items-center justify-center">
                            <i class="fas fa-stopwatch text-purple-600 text-xl"></i>
                        </div>
                    </div>
                    <div class="mt-4">
                        @php
                            $timeComparison = $ticketStats['time_comparison'] ?? 0;
                            $comparisonClass = $timeComparison <= 0 ? 'text-green-600' : 'text-red-600';
                            $comparisonIcon = $timeComparison <= 0 ? 'arrow-down' : 'arrow-up';
                            $comparisonText = $timeComparison <= 0 ? 'faster' : 'slower';
                        @endphp
                        <span class="text-xs {{ $comparisonClass }} font-medium">
                            <i class="fas fa-{{ $comparisonIcon }} mr-1"></i>
                            {{ abs($timeComparison) }}h {{ $comparisonText }} than average
                        </span>
                    </div>
                </div>
            </div>

            <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
                <!-- Recent Activity & Tickets -->
                <div class="lg:col-span-2">
                    <!-- Quick Action Buttons -->

                    <div class="bg-white rounded-xl shadow-md overflow-hidden">
    <div class="px-6 py-4 border-b border-gray-200">
        <div class="flex items-center justify-between">
            <h2 class="text-lg font-semibold text-gray-800">Your Recent Support Requests</h2>
            <a href="{{ route('tickets.index') }}" class="text-primary hover:text-primaryDark text-sm font-medium">
                View All Tickets <i class="fas fa-arrow-right ml-1"></i>
            </a>
        </div>
    </div>
    
    <div class="divide-y divide-gray-100 max-h-96 overflow-y-auto custom-scrollbar">
        @forelse($recentTickets ?? [] as $ticket)
            <div class="relative p-6 hover:bg-gray-50 transition cursor-pointer group ticket-item" 
                 data-ticket-id="{{ $ticket->id }}">
                
                <!-- Dynamic colored left border on hover -->
                <div class="absolute left-0 top-0 h-full w-1 bg-transparent 
                    @if($ticket->priority === 'high') group-hover:bg-red-500
                    @elseif($ticket->priority === 'medium') group-hover:bg-yellow-500
                    @elseif($ticket->priority === 'low') group-hover:bg-green-500
                    @endif transition-all duration-200"></div>
                
                <div class="flex items-start justify-between pl-2">
                    <div class="flex-1">
                        <div class="flex items-center justify-between mb-2">
                            <div class="flex items-center space-x-2">
                                <!-- Status Badge -->
                                <span class="inline-flex items-center px-3 py-1 rounded-full text-xs font-medium shadow-sm
                                    @if($ticket->status === 'in_progress') bg-blue-100 text-blue-800
                                    @elseif($ticket->status === 'open') bg-green-100 text-green-800
                                    @elseif($ticket->status === 'pending') bg-yellow-100 text-yellow-800
                                    @elseif($ticket->status === 'resolved') bg-purple-100 text-purple-800
                                    @elseif($ticket->status === 'closed') bg-gray-100 text-gray-800
                                    @endif">
                                    
                                    @if($ticket->status === 'in_progress')
                                        <i class="fas fa-spinner fa-pulse mr-1.5 text-blue-600"></i>
                                        In Progress
                                    @elseif($ticket->status === 'open')
                                        <i class="fas fa-circle text-[8px] mr-1.5 text-green-600"></i>
                                        Open
                                    @elseif($ticket->status === 'pending')
                                        <i class="fas fa-hourglass-half mr-1.5 text-yellow-600"></i>
                                        Pending
                                    @elseif($ticket->status === 'resolved')
                                        <i class="fas fa-check-circle mr-1.5 text-purple-600"></i>
                                        Resolved
                                    @elseif($ticket->status === 'closed')
                                        <i class="fas fa-lock mr-1.5 text-gray-600"></i>
                                        Closed
                                    @endif
                                </span>
                                
                                <!-- Priority Badge -->
                                <span class="inline-flex items-center px-3 py-1 rounded-full text-xs font-medium shadow-sm
                                    @if($ticket->priority === 'high') bg-red-100 text-red-800
                                    @elseif($ticket->priority === 'medium') bg-yellow-100 text-yellow-800
                                    @elseif($ticket->priority === 'low') bg-green-100 text-green-800
                                    @endif">
                                    @if($ticket->priority === 'high')
                                        <i class="fas fa-arrow-up mr-1 text-xs"></i>
                                    @elseif($ticket->priority === 'medium')
                                        <i class="fas fa-minus mr-1 text-xs"></i>
                                    @elseif($ticket->priority === 'low')
                                        <i class="fas fa-arrow-down mr-1 text-xs"></i>
                                    @endif
                                    {{ ucfirst($ticket->priority) }}
                                </span>
                            </div>
                            
                            <!-- Ticket Number - All the way to the right -->
                            <span class="text-xs font-mono text-gray-400">{{ $ticket->ticket_number }}</span>
                        </div>
                        
                        <h3 class="font-medium text-gray-900 mb-2">{{ $ticket->subject }}</h3>
                        
                        <p class="text-gray-600 text-sm mb-3 line-clamp-2">
                            {{ Str::limit($ticket->description, 100) }}
                        </p>
                        
                        <div class="flex items-center justify-between text-xs text-gray-500">
                            <div class="flex items-center space-x-4">
                                <span class="flex items-center">
                                    <i class="fas fa-calendar mr-1"></i>
                                    {{ $ticket->created_at->format('M d, Y - g:i A') }}
                                </span>
                                
                                @if($ticket->assignedTech)
                                    <span class="flex items-center">
                                        <i class="fas fa-user-tie mr-1"></i>
                                        {{ $ticket->assignedTech->name }} (Tech)
                                    </span>
                                @else
                                    <span class="flex items-center">
                                        <i class="fas fa-user-clock mr-1"></i>
                                        Unassigned
                                    </span>
                                @endif
                            </div>
                            
                            <span class="text-primary font-medium">
                                @if($ticket->status === 'pending')
                                    Awaiting assignment
                                @elseif($ticket->status === 'open')
                                    Just opened
                                @elseif($ticket->status === 'in_progress')
                                    In progress
                                @elseif($ticket->status === 'resolved')
                                    Ready for review
                                @elseif($ticket->status === 'closed')
                                    Closed {{ $ticket->resolved_at ? $ticket->resolved_at->diffForHumans() : '' }}
                                @endif
                            </span>
                        </div>
                    </div>
                    <i class="fas fa-chevron-right text-gray-400 mt-6 ml-4"></i>
                </div>
            </div>
        @empty
            <div class="p-12 text-center">
                <div class="flex flex-col items-center justify-center">
                    <i class="fas fa-ticket-alt text-gray-300 text-5xl mb-4"></i>
                    <h3 class="text-lg font-medium text-gray-700 mb-2">No tickets yet</h3>
                    <p class="text-gray-500 text-sm mb-4">Create your first support ticket to get help</p>
                    <a href="{{ route('tickets.create') }}" 
                    class="bg-primary hover:bg-primaryDark text-white px-6 py-2 rounded-lg text-sm font-medium transition">
                        <i class="fas fa-plus-circle mr-2"></i>
                        Create New Ticket
                    </a>
                </div>
            </div>
        @endforelse
    </div>
</div>
                </div>
                
                <!-- Right Sidebar - Support Resources & Info -->
                <div class="space-y-6">
                    <!-- Support Status -->
                    <div class="bg-white rounded-xl shadow-md p-6">
                        <h3 class="text-lg font-semibold text-gray-800 mb-4 flex items-center">
                            <i class="fas fa-headset text-primary mr-2"></i>
                            Support Status
                        </h3>
                        <div class="space-y-4">
                            <div class="grid grid-cols-2 gap-4">
                                <div class="text-center p-3 bg-blue-50 rounded-lg">
                                    <p class="text-sm text-gray-600">Response Time</p>
                                    <p class="text-xl font-bold text-gray-900">45 min</p>
                                </div>
                                <div class="text-center p-3 bg-purple-50 rounded-lg">
                                    <p class="text-sm text-gray-600">Resolution Time</p>
                                    <p class="text-xl font-bold text-gray-900">8.2 hours</p>
                                </div>
                            </div>
                            
                            <div class="pt-4 border-t border-gray-100">
                                <h4 class="font-medium text-gray-900 mb-3">Support Channels</h4>
                                <div class="space-y-3">
                                    <a href="#" class="flex items-center space-x-3 p-3 bg-gray-50 hover:bg-gray-100 rounded-lg transition">
                                        <div class="w-10 h-10 bg-primary rounded-lg flex items-center justify-center">
                                            <i class="fas fa-ticket-alt text-white"></i>
                                        </div>
                                        <div>
                                            <p class="font-medium text-gray-900">Ticket System</p>
                                            <p class="text-sm text-gray-500">24/7 available</p>
                                        </div>
                                    </a>
                                    
                                    <a href="#" class="flex items-center space-x-3 p-3 bg-gray-50 hover:bg-gray-100 rounded-lg transition">
                                        <div class="w-10 h-10 bg-support rounded-lg flex items-center justify-center">
                                            <i class="fas fa-phone text-white"></i>
                                        </div>
                                        <div>
                                            <p class="font-medium text-gray-900">Phone Support</p>
                                            <p class="text-sm text-gray-500">Mon-Fri, 9AM-6PM</p>
                                        </div>
                                    </a>
                                    
                                    <a href="#" class="flex items-center space-x-3 p-3 bg-gray-50 hover:bg-gray-100 rounded-lg transition">
                                        <div class="w-10 h-10 bg-warning rounded-lg flex items-center justify-center">
                                            <i class="fas fa-comments text-white"></i>
                                        </div>
                                        <div>
                                            <p class="font-medium text-gray-900">Live Chat</p>
                                            <p class="text-sm text-gray-500">Available now</p>
                                        </div>
                                    </a>
                                </div>
                            </div>
                        </div>
                    </div>
            </div>
        </div>
    </main>

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

    <!-- JavaScript -->
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            // Mobile menu toggle
            const mobileMenuButton = document.getElementById('mobileMenuButton');
            const mobileMenu = document.getElementById('mobileMenu');
            
            if (mobileMenuButton && mobileMenu) {
                mobileMenuButton.addEventListener('click', function(e) {
                    e.stopPropagation();
                    mobileMenu.classList.toggle('hidden');
                });
            }
            
            // Close mobile menu when clicking outside
            document.addEventListener('click', function(event) {
                if (mobileMenu && !mobileMenu.contains(event.target) && mobileMenuButton && !mobileMenuButton.contains(event.target)) {
                    mobileMenu.classList.add('hidden');
                }
            });
            
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
            
            // FIXED: Ticket click handlers - Now using data-ticket-id attribute
            document.querySelectorAll('.ticket-item').forEach(ticket => {
                ticket.addEventListener('click', function(e) {
                    // Prevent click if clicking on a link or button
                    if (e.target.closest('a') || e.target.closest('button')) {
                        return;
                    }
                    
                    const ticketId = this.dataset.ticketId;
                    if (ticketId) {
                        window.location.href = `/tickets/my_tickets_view/${ticketId}`;
                    }
                });
            });
        
        });
    </script>
</body>
</html>