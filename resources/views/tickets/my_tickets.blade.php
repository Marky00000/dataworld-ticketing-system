<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>My Tickets - Dataworld Support</title>
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
            height: 6px;
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
        
        /* Table row hover effect */
        tbody tr {
            transition: all 0.2s ease;
        }
        
        tbody tr:hover {
            background-color: #f9fafb;
        }
        
        /* Breadcrumb styling */
        .breadcrumb-hover {
            transition: color 0.2s ease;
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
    </style>
</head>
<body class="bg-gray-50">

<div id="app" class="min-h-screen flex flex-col">
    
 <!-- Top Navigation Bar - Modern Updated -->
<nav class="bg-white/80 backdrop-blur-md shadow-lg border-b border-primary/10 sticky top-0 z-50 transition-all duration-300" 
     :class="{ 'shadow-xl bg-white/95': scrolled }">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex justify-between h-16">
            <!-- Logo with animation - Updated modern typography -->
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
            
            <!-- Desktop Navigation - Modern with icon backgrounds -->
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
    
    <!-- Mobile Menu - Vue Transition (Simplified with gray text) -->
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
                
                <!-- Navigation Items - All gray text -->
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
                       class="flex items-center space-x-3 px-4 py-3 text-gray-600 hover:text-primary rounded-xl transition-all duration-300 group border border-gray-200">
                        <div class="w-10 h-10 bg-gray-100 group-hover:bg-primary/10 rounded-xl flex items-center justify-center transition-colors">
                            <i class="fas fa-user-plus text-gray-500 group-hover:text-primary"></i>
                        </div>
                        <div class="flex-1">
                            <p class="font-medium text-gray-700">Create Tech Account</p>
                            <p class="text-xs text-gray-400">Add new technician</p>
                        </div>
                        <span class="text-xs bg-gray-100 text-gray-600 px-2 py-0.5 rounded-full">Admin</span>
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

    <!-- Main Content (ALL YOUR EXISTING CONTENT PRESERVED) -->
    <main class="flex-1">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
            
            <!-- Header with improved styling -->
            <div class="flex flex-col md:flex-row md:items-center md:justify-between mb-8">
                <div>
                    <h1 class="text-2xl md:text-3xl font-bold text-gray-900 flex items-center">
                        My Support Tickets
                    </h1>
                    <p class="text-gray-600 mt-2">Track and manage all your support requests</p>
                </div>
            </div>

 <!-- Filters - Desktop: Left/Right Layout, Mobile: Stacked -->
<div class="bg-white rounded-lg shadow-sm p-3 mb-4 border border-gray-200">
    <form id="filterForm" method="GET" action="{{ route('tickets.index') }}">
        <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-3">
            <!-- Status Filter Buttons - Left side -->
            <div class="flex gap-1.5 flex-wrap">
                <button type="button" class="filter-btn px-3 py-1.5 {{ !request('status') || request('status') == 'all' ? 'bg-primary text-white' : 'bg-gray-100 text-gray-700 hover:bg-gray-200' }} rounded-lg font-medium text-xs transition" data-status="all">All</button>
                <button type="button" class="filter-btn px-3 py-1.5 {{ request('status') == 'open' ? 'bg-primary text-white' : 'bg-gray-100 text-gray-700 hover:bg-gray-200' }} rounded-lg font-medium text-xs transition" data-status="open">Open</button>
                <button type="button" class="filter-btn px-3 py-1.5 {{ request('status') == 'in_progress' ? 'bg-primary text-white' : 'bg-gray-100 text-gray-700 hover:bg-gray-200' }} rounded-lg font-medium text-xs transition" data-status="in_progress">In Progress</button>
                <button type="button" class="filter-btn px-3 py-1.5 {{ request('status') == 'resolved' ? 'bg-primary text-white' : 'bg-gray-100 text-gray-700 hover:bg-gray-200' }} rounded-lg font-medium text-xs transition" data-status="resolved">Resolved</button>
                <button type="button" class="filter-btn px-3 py-1.5 {{ request('status') == 'closed' ? 'bg-primary text-white' : 'bg-gray-100 text-gray-700 hover:bg-gray-200' }} rounded-lg font-medium text-xs transition" data-status="closed">Closed</button>
            </div>
                        
            <!-- Search and Sort - Right side -->
            <div class="flex items-center gap-2 sm:max-w-md w-full sm:w-auto">
                <!-- Search Input with clickable magnifying glass -->
                <div class="relative flex-1">
                    <input type="text" name="search" id="searchInput" placeholder="Search tickets..." 
                           value="{{ request('search') }}"
                           class="w-full pl-8 pr-2 py-1.5 text-xs border border-gray-300 rounded-lg focus:outline-none focus:ring-1 focus:ring-primary focus:border-transparent">
                    <button type="submit" form="filterForm" class="absolute left-2.5 top-1/2 -translate-y-1/2 text-gray-400 hover:text-primary focus:outline-none cursor-pointer">
                        <i class="fas fa-search text-xs"></i>
                    </button>
                </div>
                
                <!-- Sort Dropdown -->
                <select name="sort" id="sortSelect" 
                        onchange="document.getElementById('filterForm').submit()"
                        class="w-28 border border-gray-300 rounded-lg px-2 py-1.5 text-xs focus:outline-none focus:ring-1 focus:ring-primary bg-white">
                    <option value="newest" {{ request('sort') == 'newest' ? 'selected' : '' }}>Newest</option>
                    <option value="oldest" {{ request('sort') == 'oldest' ? 'selected' : '' }}>Oldest</option>
                    <option value="high_priority" {{ request('sort') == 'high_priority' ? 'selected' : '' }}>High Priority</option>
                    <option value="low_priority" {{ request('sort') == 'low_priority' ? 'selected' : '' }}>Low Priority</option>
                </select>
                
                <input type="hidden" name="status" id="statusInput" value="{{ request('status', 'all') }}">
            </div>
        </div>
    </form>
</div>

         

            <!-- Tickets Table - YOUR FULL TABLE PRESERVED -->
            <div class="bg-white rounded-xl shadow-md overflow-hidden border border-gray-200">
    <div class="px-6 py-4 border-b border-gray-200 bg-gray-50">
        <h2 class="text-lg font-semibold text-gray-800 flex items-center">
            <i class="fas fa-list-ul text-primary mr-2"></i>
            Ticket List
        </h2>
    </div>
    
    <div class="overflow-x-auto">
        <table class="w-full">
            <thead class="bg-gray-50">
                <tr>
                    <th class="px-6 py-4 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Ticket ID</th>
                    <th class="px-6 py-4 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Subject</th>
                    <th class="px-6 py-4 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Status</th>
                    <th class="px-6 py-4 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Priority</th>
                    <th class="px-6 py-4 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Assigned To</th>
                    <th class="px-6 py-4 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Created</th>
                    <th class="px-6 py-4 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Actions</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-gray-200">
                @forelse($tickets as $ticket)
                <tr class="hover:bg-gray-50 transition">
                    <td class="px-6 py-4">
                        <span class="font-mono text-sm font-medium text-gray-700 bg-gray-100 px-3 py-1.5 rounded-lg border border-gray-200">
                            {{ $ticket->ticket_number }}
                        </span>
                    </td>
                    <td class="px-6 py-4">
                        <div>
                            <p class="font-semibold text-gray-900">{{ $ticket->subject }}</p>
                            <p class="text-sm text-gray-500 mt-0.5">{{ Str::limit($ticket->description, 50) }}</p>
                        </div>
                    </td>
                    <td class="px-6 py-4">
                        <span class="inline-flex items-center px-3 py-1.5 rounded-full text-xs font-medium shadow-sm 
                            @if($ticket->status === 'in_progress') bg-blue-100 text-blue-800 border border-blue-200
                            @elseif($ticket->status === 'open') bg-green-100 text-green-800 border border-green-200
                            @elseif($ticket->status === 'pending') bg-yellow-100 text-yellow-800 border border-yellow-200
                            @elseif($ticket->status === 'resolved') bg-purple-100 text-purple-800 border border-purple-200
                            @elseif($ticket->status === 'closed') bg-gray-100 text-gray-800 border border-gray-300
                            @else bg-gray-100 text-gray-800 border border-gray-200
                            @endif">
                            @if($ticket->status === 'in_progress')
                                In Progress
                            @elseif($ticket->status === 'open')
                                Open
                            @elseif($ticket->status === 'pending')
                                Pending
                            @elseif($ticket->status === 'resolved')
                                Resolved
                            @elseif($ticket->status === 'closed')
                                Closed
                            @else
                                {{ ucfirst(str_replace('_', ' ', $ticket->status)) }}
                            @endif
                        </span>
                    </td>
                    <td class="px-6 py-4">
                        <span class="inline-flex items-center px-3 py-1.5 rounded-full text-xs font-medium 
                            @if($ticket->priority === 'high') bg-red-100 text-red-800 border border-red-200
                            @elseif($ticket->priority === 'medium') bg-yellow-100 text-yellow-800 border border-yellow-200
                            @elseif($ticket->priority === 'low') bg-green-100 text-green-800 border border-green-200
                            @endif">
                            @if($ticket->priority === 'high')
                                High
                            @elseif($ticket->priority === 'medium')
                                Medium
                            @elseif($ticket->priority === 'low')
                                Low
                            @endif
                        </span>
                    </td>
                    
                    <td class="px-6 py-4">
                        @if($ticket->assignedTech)
                            <div class="flex items-center">
                                <div class="ml-2">
                                    <p class="text-sm font-medium text-gray-900">{{ $ticket->assignedTech->name }}</p>
                                </div>
                            </div>
                        @else
                            <div class="flex items-center">
                                <span class="ml-2 text-sm text-gray-500 font-medium">Unassigned</span>
                            </div>
                        @endif
                    </td>
                    <td class="px-6 py-4 text-sm text-gray-600">
                        <div class="flex items-center">
                            <i class="fas fa-calendar-alt text-gray-400 mr-2 text-xs"></i>
                            {{ $ticket->created_at->format('M d, Y') }}
                        </div>
                        <div class="text-xs text-gray-400 mt-1">
                            {{ $ticket->created_at->format('g:i A') }}
                        </div>
                    </td>
                    
                    <td class="px-6 py-4">
                    <a href="{{ url('/tickets/my_tickets_view/' . $ticket->id) }}" 
                    class="inline-flex items-center px-4 py-2 bg-primary/10 text-primary hover:bg-primary hover:text-white rounded-lg transition text-sm font-medium group">
                        <span>View</span>
                        <i class="fas fa-arrow-right ml-2 group-hover:translate-x-1 transition-transform"></i>
                    </a>
                </td>
                </tr>
                @empty
                <tr>
                    <td colspan="8" class="px-6 py-16 text-center">
                        <div class="flex flex-col items-center justify-center">
                            <div class="w-20 h-20 bg-gray-100 rounded-2xl flex items-center justify-center mb-4">
                                <i class="fas fa-ticket-alt text-gray-400 text-3xl"></i>
                            </div>
                            <h3 class="text-xl font-semibold text-gray-700 mb-2">No tickets found</h3>
                            <p class="text-gray-500 mb-6 max-w-md">You haven't created any support tickets yet. Create your first ticket to get help from our support team.</p>
                            <a href="{{ route('tickets.create') }}" class="inline-flex items-center space-x-2 bg-primary hover:bg-primaryDark text-white px-6 py-3 rounded-lg font-medium transition shadow-md hover:shadow-lg">
                                <i class="fas fa-plus-circle"></i>
                                <span>Create Your First Ticket</span>
                            </a>
                        </div>
                    </td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>
    
    <!-- Pagination -->
    @if($tickets->hasPages())
    <div class="px-6 py-4 border-t border-gray-200 bg-gray-50">
        <div class="flex flex-col sm:flex-row items-center justify-between gap-4">
            <div class="text-sm text-gray-600">
                Showing <span class="font-semibold text-gray-900">{{ $tickets->firstItem() ?? 0 }}</span> 
                to <span class="font-semibold text-gray-900">{{ $tickets->lastItem() ?? 0 }}</span> 
                of <span class="font-semibold text-gray-900">{{ $tickets->total() }}</span> tickets
            </div>
            
            <div class="flex items-center space-x-2">
                {{-- Previous Page Link --}}
                @if($tickets->onFirstPage())
                    <span class="inline-flex items-center justify-center w-10 h-10 bg-gray-100 text-gray-400 rounded-lg cursor-not-allowed">
                        <i class="fas fa-chevron-left"></i>
                    </span>
                @else
                    <a href="{{ $tickets->previousPageUrl() }}" class="inline-flex items-center justify-center w-10 h-10 bg-white border border-gray-300 text-gray-700 rounded-lg hover:bg-primary hover:text-white hover:border-primary transition-all duration-200">
                        <i class="fas fa-chevron-left"></i>
                    </a>
                @endif

                {{-- Pagination Elements --}}
                @php
                    $start = max($tickets->currentPage() - 2, 1);
                    $end = min($start + 4, $tickets->lastPage());
                    $start = max(min($start, $tickets->lastPage() - 4), 1);
                @endphp

                @if($start > 1)
                    <a href="{{ $tickets->url(1) }}" class="inline-flex items-center justify-center w-10 h-10 bg-white border border-gray-300 text-gray-700 rounded-lg hover:bg-primary hover:text-white hover:border-primary transition-all duration-200 font-medium">1</a>
                    @if($start > 2)
                        <span class="inline-flex items-center justify-center w-10 h-10 text-gray-500">...</span>
                    @endif
                @endif

                @for($page = $start; $page <= $end; $page++)
                    @if($page == $tickets->currentPage())
                        <span class="inline-flex items-center justify-center w-10 h-10 bg-primary text-white rounded-lg font-medium shadow-md">{{ $page }}</span>
                    @else
                        <a href="{{ $tickets->url($page) }}" class="inline-flex items-center justify-center w-10 h-10 bg-white border border-gray-300 text-gray-700 rounded-lg hover:bg-primary hover:text-white hover:border-primary transition-all duration-200 font-medium">{{ $page }}</a>
                    @endif
                @endfor

                @if($end < $tickets->lastPage())
                    @if($end < $tickets->lastPage() - 1)
                        <span class="inline-flex items-center justify-center w-10 h-10 text-gray-500">...</span>
                    @endif
                    <a href="{{ $tickets->url($tickets->lastPage()) }}" class="inline-flex items-center justify-center w-10 h-10 bg-white border border-gray-300 text-gray-700 rounded-lg hover:bg-primary hover:text-white hover:border-primary transition-all duration-200 font-medium">{{ $tickets->lastPage() }}</a>
                @endif

                {{-- Next Page Link --}}
                @if($tickets->hasMorePages())
                    <a href="{{ $tickets->nextPageUrl() }}" class="inline-flex items-center justify-center w-10 h-10 bg-white border border-gray-300 text-gray-700 rounded-lg hover:bg-primary hover:text-white hover:border-primary transition-all duration-200">
                        <i class="fas fa-chevron-right"></i>
                    </a>
                @else
                    <span class="inline-flex items-center justify-center w-10 h-10 bg-gray-100 text-gray-400 rounded-lg cursor-not-allowed">
                        <i class="fas fa-chevron-right"></i>
                    </span>
                @endif
            </div>
        </div>
    </div>
    @endif
</div>
        </div>
    </main>

    <!-- Footer -->
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

</div>

<!-- Vue App -->
<script>
    const { createApp } = Vue;

    createApp({
        data() {
            return {
                menuOpen: false,
                scrolled: false
            }
        },
        mounted() {
            window.addEventListener('scroll', this.handleScroll);
            console.log('Vue mounted - mobile menu ready');
        },
        methods: {
            toggleMenu() {
                this.menuOpen = !this.menuOpen;
                console.log('Menu toggled:', this.menuOpen);
            },
            handleScroll() {
                this.scrolled = window.scrollY > 20;
            }
        }
    }).mount('#app');
</script>

<!-- Keep your existing JavaScript for other functionality -->
<script>
    document.addEventListener('DOMContentLoaded', function() {
    // User dropdown hover (keep this)
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
    
    // Filter buttons functionality
    const filterButtons = document.querySelectorAll('.filter-btn');
    const statusInput = document.getElementById('statusInput');
    
    if (filterButtons.length > 0 && statusInput) {
        filterButtons.forEach(button => {
            button.addEventListener('click', function() {
                const status = this.dataset.status;
                
                // Update hidden input
                statusInput.value = status;
                
                // Update button styles
                filterButtons.forEach(btn => {
                    btn.classList.remove('bg-primary', 'text-white');
                    btn.classList.add('bg-gray-100', 'text-gray-700', 'hover:bg-gray-200');
                });
                
                this.classList.remove('bg-gray-100', 'text-gray-700', 'hover:bg-gray-200');
                this.classList.add('bg-primary', 'text-white');
                
                // Submit the form
                document.getElementById('filterForm').submit();
            });
        });
    }
    
    // 🔥 ADD THIS - Make search input submit on Enter key
    const searchInput = document.getElementById('searchInput');
    if (searchInput) {
        searchInput.addEventListener('keypress', function(e) {
            if (e.key === 'Enter') {
                e.preventDefault();
                document.getElementById('filterForm').submit();
            }
        });
    }
});
</script>

</body>
</html>