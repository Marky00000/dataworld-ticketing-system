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
    </style>
</head>
<body class="bg-gray-50">
    
    <!-- Top Navigation Bar - Enhanced with active state -->
    <nav class="bg-white shadow-lg border-b border-gray-200 sticky top-0 z-50">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex justify-between h-16">
                <!-- Logo -->
                <div class="flex items-center">
                    <a href="/dashboard" class="flex items-center space-x-2 group">
                        <img src="{{ asset('images/dwcc.png') }}" alt="Dataworld Logo" class="h-8 w-auto">
                        <div class="flex flex-col">
                            <span class="text-xs text-blue-600 font-medium opacity-0 group-hover:opacity-100 transition-opacity">
                                Dataworld Computer Center
                            </span>
                        </div>
                    </a>
                </div>
                
                <!-- Desktop Navigation -->
                <div class="hidden md:flex items-center space-x-8">
                    <!-- Navigation Links with active states -->
                    <a href="/dashboard" class="{{ request()->is('dashboard') ? 'text-primary border-b-2 border-primary' : 'text-gray-700 hover:text-primary' }} font-medium transition flex items-center space-x-2 pb-1">
                        <i class="fas fa-home"></i>
                        <span>Dashboard</span>
                    </a>
                    
                    <a href="/tickets" class="{{ request()->is('tickets') || request()->is('tickets/*') ? 'text-primary' : 'text-gray-700 hover:text-primary' }} font-medium transition flex items-center space-x-2 pb-1">
                        <i class="fas fa-ticket-alt"></i>
                        <span>My Tickets</span>
                    </a>
                    
                    <a href="/tickets/create" class="{{ request()->is('tickets/create') ? 'text-primary border-b-2 border-primary' : 'text-gray-700 hover:text-primary' }} font-medium transition flex items-center space-x-2 pb-1">
                        <i class="fas fa-plus-circle"></i>
                        <span>New Ticket</span>
                    </a>
                    
                    <!-- User Dropdown - Enhanced -->
                    <div class="relative group">
                        <button class="flex items-center space-x-3 focus:outline-none">
                            <div class="flex items-center space-x-3">
                                <div class="w-10 h-10 bg-gradient-to-r from-primary to-support rounded-full flex items-center justify-center text-white font-semibold shadow-md">
                                    {{ substr(auth()->user()->name, 0, 1) }}
                                </div>
                                <div class="text-left hidden lg:block">
                                    <p class="text-sm font-medium text-gray-900">{{ auth()->user()->name }}</p>
                                </div>
                            </div>
                            <i class="fas fa-chevron-down text-gray-400 text-sm transition-transform group-hover:rotate-180"></i>
                        </button>
                        
                        <!-- Dropdown Menu -->
                        <div class="absolute right-0 mt-2 w-56 bg-white rounded-lg shadow-lg py-2 z-50 opacity-0 invisible group-hover:opacity-100 group-hover:visible transition-all duration-200 border border-gray-200">
                           <div class="px-4 py-3 border-b border-gray-100">
                                <p class="text-sm font-medium text-gray-900">{{ auth()->user()->name }}</p>
                                <p class="text-xs text-gray-500 truncate">{{ auth()->user()->email }}</p>
                                <p class="text-xs font-medium 
                                    @if(auth()->user()->user_type === 'admin') text-blue-600
                                    @elseif(auth()->user()->user_type === 'tech') text-blue-600
                                    @else text-blue-600
                                    @endif">
                                    @if(auth()->user()->user_type === 'admin')
                                    </i> Admin Account
                                    @elseif(auth()->user()->user_type === 'tech')
                                    </i> Tech Account
                                    @else
                                    </i> Client Account
                                    @endif
                                </p>
                            </div>
                            
                            <a href="{{ route('profile.dashboard') }}" class="flex items-center space-x-2 px-4 py-2 text-sm text-gray-700 hover:bg-gray-50 transition">
                                <i class="fas fa-user text-gray-400 w-4"></i>
                                <span>My Profile</span>
                            </a>

                            @if(auth()->user()->user_type === 'admin')
                            <div class="border-t border-gray-100 my-1"></div>
                            <a href="{{ route('admin.tech.create') }}" class="flex items-center space-x-2 px-4 py-2 text-sm text-blue-600 hover:bg-blue-50 transition">
                                <i class="fas fa-user-plus text-blue-500 w-4"></i>
                                <span class="font-medium">Create Tech Account</span>
                            </a>
                            @endif
                            
                            <div class="border-t border-gray-100 my-1"></div>
                            
                            <form method="POST" action="{{ route('sign-out') }}" class="w-full">
                                @csrf
                                <button type="submit" class="flex items-center space-x-2 px-4 py-2 text-sm text-red-600 hover:bg-red-50 transition w-full text-left">
                                    <i class="fas fa-sign-out-alt text-red-500 w-4"></i>
                                    <span>Sign Out</span>
                                </button>
                            </form>
                        </div>
                    </div>
                </div>
                
                <!-- Mobile menu button -->
                <div class="md:hidden flex items-center">
                    <button id="mobileMenuButton" class="text-gray-500 hover:text-gray-700 focus:outline-none">
                        <i class="fas fa-bars text-xl"></i>
                    </button>
                </div>
            </div>
        </div>
        
        <!-- Mobile Menu - Enhanced -->
        <div id="mobileMenu" class="md:hidden bg-white border-t border-gray-200 hidden">
            <div class="px-4 py-3 space-y-3">
                <div class="flex items-center space-x-3 px-2 py-3 border-b border-gray-100">
                    <div class="w-10 h-10 bg-gradient-to-r from-primary to-support rounded-full flex items-center justify-center text-white font-semibold">
                        {{ substr(auth()->user()->name, 0, 1) }}
                    </div>
                    <div>
                        <p class="text-sm font-medium text-gray-900">{{ auth()->user()->name }}</p>
                        <p class="text-xs text-gray-500 capitalize">{{ auth()->user()->user_type }} Account</p>
                    </div>
                </div>
                
                <a href="/dashboard" class="flex items-center space-x-2 px-2 py-3 {{ request()->is('dashboard') ? 'text-primary bg-primary/5' : 'text-gray-700 hover:bg-gray-50' }} rounded-lg transition">
                    <i class="fas fa-home w-5"></i>
                    <span>Dashboard</span>
                </a>
                
                <a href="/tickets" class="flex items-center space-x-2 px-2 py-3 {{ request()->is('tickets') || request()->is('tickets/*') ? 'text-primary bg-primary/5' : 'text-gray-700 hover:bg-gray-50' }} rounded-lg transition">
                    <i class="fas fa-ticket-alt w-5"></i>
                    <span>My Tickets</span>
                </a>
                
                <a href="/tickets/create" class="flex items-center space-x-2 px-2 py-3 {{ request()->is('tickets/create') ? 'text-primary bg-primary/5' : 'text-gray-700 hover:bg-gray-50' }} rounded-lg transition">
                    <i class="fas fa-plus-circle w-5"></i>
                    <span>New Ticket</span>
                </a>
                
                <a href="/knowledge-base" class="flex items-center space-x-2 px-2 py-3 text-gray-700 hover:bg-gray-50 rounded-lg transition">
                    <i class="fas fa-book w-5 text-gray-400"></i>
                    <span>Knowledge Base</span>
                </a>
                
                
                @if(auth()->user()->user_type === 'admin')
                <div class="border-t border-gray-100 pt-3 mt-3">
                    <a href="{{ route('admin.tech.create') }}" class="flex items-center space-x-2 px-2 py-3 text-blue-600 hover:bg-blue-50 rounded-lg transition">
                        <i class="fas fa-user-plus text-blue-500 w-5"></i>
                        <span class="font-medium">Create Tech Account</span>
                        <span class="ml-auto text-xs bg-blue-100 text-blue-800 px-2 py-0.5 rounded-full">Admin</span>
                    </a>
                </div>
                @endif
                
                <div class="border-t border-gray-100 pt-3">
                    <a href="/profile" class="flex items-center space-x-2 px-2 py-3 text-gray-700 hover:bg-gray-50 rounded-lg transition">
                        <i class="fas fa-user w-5 text-gray-400"></i>
                        <span>My Profile</span>
                    </a>

                    <form method="POST" action="{{ route('sign-out') }}" class="mt-2">
                        @csrf
                        <button type="submit" class="flex items-center space-x-2 px-2 py-3 text-red-600 hover:bg-red-50 rounded-lg transition w-full">
                            <i class="fas fa-sign-out-alt w-5"></i>
                            <span>Sign Out</span>
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </nav>

    <!-- Main Content -->
    <main class="flex-1">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
            
            <!-- Header with improved styling -->
            <div class="flex flex-col md:flex-row md:items-center md:justify-between mb-8">
                <div>
                    <h1 class="text-2xl md:text-3xl font-bold text-gray-900 flex items-center">
                        <i class="fas fa-ticket-alt text-primary mr-3"></i>
                        My Support Tickets
                    </h1>
                    <p class="text-gray-600 mt-2">Track and manage all your support requests</p>
                </div>
                <a href="/tickets/create" class="mt-4 md:mt-0 bg-primary hover:bg-primaryDark text-white px-6 py-3 rounded-lg font-medium flex items-center space-x-2 transition shadow-md hover:shadow-lg">
                    <i class="fas fa-plus-circle"></i>
                    <span>Create New Ticket</span>
                </a>
            </div>
<!-- Filters - Enhanced with search and sort functionality -->
<div class="bg-white rounded-xl shadow-md p-5 mb-8 border border-gray-100">
    <form id="filterForm" method="GET" action="{{ route('tickets.index') }}">
        <div class="flex flex-wrap gap-4 items-center">
            <div class="flex space-x-2">
                <button type="button" class="filter-btn px-5 py-2.5 {{ !request('status') || request('status') == 'all' ? 'bg-primary text-white' : 'bg-gray-100 text-gray-700 hover:bg-gray-200' }} rounded-lg font-medium text-sm shadow-sm hover:shadow-md transition" data-status="all">All</button>
                <button type="button" class="filter-btn px-5 py-2.5 {{ request('status') == 'open' ? 'bg-primary text-white' : 'bg-gray-100 text-gray-700 hover:bg-gray-200' }} rounded-lg font-medium text-sm transition" data-status="open">Open</button>
                <button type="button" class="filter-btn px-5 py-2.5 {{ request('status') == 'in_progress' ? 'bg-primary text-white' : 'bg-gray-100 text-gray-700 hover:bg-gray-200' }} rounded-lg font-medium text-sm transition" data-status="in_progress">In Progress</button>
                <button type="button" class="filter-btn px-5 py-2.5 {{ request('status') == 'resolved' ? 'bg-primary text-white' : 'bg-gray-100 text-gray-700 hover:bg-gray-200' }} rounded-lg font-medium text-sm transition" data-status="resolved">Resolved</button>
            </div>
            
            <div class="ml-auto flex items-center space-x-3">
                <div class="relative flex items-center">
                    <input type="text" name="search" id="searchInput" placeholder="Search tickets..." 
                           value="{{ request('search') }}"
                           class="pl-10 pr-4 py-2.5 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-primary focus:border-transparent w-64">
                    <button type="submit" class="absolute left-0 top-0 h-full flex items-center pl-3 pr-3 text-gray-400 hover:text-primary transition-colors">
                        <i class="fas fa-search"></i>
                    </button>
                </div>
                <select name="sort" id="sortSelect" class="border border-gray-300 rounded-lg px-4 py-2.5 focus:outline-none focus:ring-2 focus:ring-primary bg-white">
                    <option value="newest" {{ request('sort') == 'newest' ? 'selected' : '' }}>Newest First</option>
                    <option value="oldest" {{ request('sort') == 'oldest' ? 'selected' : '' }}>Oldest First</option>
                    <option value="high_priority" {{ request('sort') == 'high_priority' ? 'selected' : '' }}>High Priority</option>
                    <option value="low_priority" {{ request('sort') == 'low_priority' ? 'selected' : '' }}>Low Priority</option>
                </select>
                <input type="hidden" name="status" id="statusInput" value="{{ request('status', 'all') }}">
            </div>
        </div>
    </form>
</div>


            <!-- Stats Cards - Enhanced with icons and better hover -->
<div class="grid grid-cols-1 md:grid-cols-4 gap-6 mb-8">
    
    @php
        // Use the full namespace for Ticket model
        $ticketModel = 'App\\Models\\Ticket';
        
        // Calculate stats based on user type using the same logic as your controller
        if ($user->user_type === 'admin') {
            $statsQuery = $ticketModel::query();
        } elseif ($user->user_type === 'tech') {
            $statsQuery = $ticketModel::where('assigned_to', $user->id)
                ->orWhere('created_by', $user->id);
        } else {
            $statsQuery = $ticketModel::where('created_by', $user->id);
        }
        
        // Apply same filters if they exist in request
        if (request()->status && request()->status !== 'all') {
            $statsQuery->where('status', request()->status);
        }
        
        if (request()->search) {
            $search = request()->search;
            $statsQuery->where(function($q) use ($search) {
                $q->where('ticket_number', 'like', "%{$search}%")
                  ->orWhere('subject', 'like', "%{$search}%")
                  ->orWhere('description', 'like', "%{$search}%");
            });
        }
        
        // Clone the query for different stats
        $totalQuery = clone $statsQuery;
        $activeQuery = clone $statsQuery;
        $resolvedQuery = clone $statsQuery;
        $highPriorityQuery = clone $statsQuery;
        $unassignedQuery = clone $statsQuery;
        $pendingReviewQuery = clone $statsQuery;
        
        // Calculate stats
        $totalTickets = $totalQuery->count();
        $activeTickets = $activeQuery->whereIn('status', ['pending', 'open', 'in_progress'])->count();
        $resolvedTickets = $resolvedQuery->whereIn('status', ['resolved', 'closed'])->count();
        $highPriorityTickets = $highPriorityQuery->where('priority', 'high')
            ->whereNotIn('status', ['resolved', 'closed'])
            ->count();
        $unassignedTickets = $unassignedQuery->whereNull('assigned_to')->count();
        $pendingReviewTickets = $pendingReviewQuery->where('status', 'pending')->count();
    @endphp

    @if($user->user_type === 'admin')
        <!-- Admin Stats Cards -->
        <div class="bg-white rounded-xl p-6 shadow-md dashboard-card border border-gray-100">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-gray-500 text-sm font-medium">Total Tickets</p>
                    <p class="text-3xl font-bold text-gray-900 mt-2">{{ $totalTickets }}</p>
                </div>
                <div class="w-14 h-14 bg-blue-100 rounded-xl flex items-center justify-center">
                    <i class="fas fa-ticket-alt text-blue-600 text-2xl"></i>
                </div>
            </div>
            @if(request()->status || request()->search)
                <p class="text-xs text-gray-400 mt-2">Filtered results</p>
            @endif
        </div>
        
        <div class="bg-white rounded-xl p-6 shadow-md dashboard-card border border-gray-100">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-gray-500 text-sm font-medium">Active Tickets</p>
                    <p class="text-3xl font-bold text-gray-900 mt-2">{{ $activeTickets }}</p>
                </div>
                <div class="w-14 h-14 bg-yellow-100 rounded-xl flex items-center justify-center">
                    <i class="fas fa-clock text-yellow-600 text-2xl"></i>
                </div>
            </div>
        </div>
        
        <div class="bg-white rounded-xl p-6 shadow-md dashboard-card border border-gray-100">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-gray-500 text-sm font-medium">Resolved</p>
                    <p class="text-3xl font-bold text-gray-900 mt-2">{{ $resolvedTickets }}</p>
                </div>
                <div class="w-14 h-14 bg-green-100 rounded-xl flex items-center justify-center">
                    <i class="fas fa-check-circle text-green-600 text-2xl"></i>
                </div>
            </div>
        </div>
        
        <div class="bg-white rounded-xl p-6 shadow-md dashboard-card border border-gray-100">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-gray-500 text-sm font-medium">Unassigned</p>
                    <p class="text-3xl font-bold text-gray-900 mt-2">{{ $unassignedTickets }}</p>
                </div>
                <div class="w-14 h-14 bg-purple-100 rounded-xl flex items-center justify-center">
                    <i class="fas fa-user-slash text-purple-600 text-2xl"></i>
                </div>
            </div>
        </div>
        
    @elseif($user->user_type === 'tech')
        <!-- Tech Stats Cards -->
        <div class="bg-white rounded-xl p-6 shadow-md dashboard-card border border-gray-100">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-gray-500 text-sm font-medium">My Tickets</p>
                    <p class="text-3xl font-bold text-gray-900 mt-2">{{ $totalTickets }}</p>
                </div>
                <div class="w-14 h-14 bg-blue-100 rounded-xl flex items-center justify-center">
                    <i class="fas fa-ticket-alt text-blue-600 text-2xl"></i>
                </div>
            </div>
            @if(request()->status || request()->search)
                <p class="text-xs text-gray-400 mt-2">Filtered results</p>
            @endif
        </div>
        
        <div class="bg-white rounded-xl p-6 shadow-md dashboard-card border border-gray-100">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-gray-500 text-sm font-medium">Active</p>
                    <p class="text-3xl font-bold text-gray-900 mt-2">{{ $activeTickets }}</p>
                </div>
                <div class="w-14 h-14 bg-yellow-100 rounded-xl flex items-center justify-center">
                    <i class="fas fa-clock text-yellow-600 text-2xl"></i>
                </div>
            </div>
        </div>
        
        <div class="bg-white rounded-xl p-6 shadow-md dashboard-card border border-gray-100">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-gray-500 text-sm font-medium">Resolved</p>
                    <p class="text-3xl font-bold text-gray-900 mt-2">{{ $resolvedTickets }}</p>
                </div>
                <div class="w-14 h-14 bg-green-100 rounded-xl flex items-center justify-center">
                    <i class="fas fa-check-circle text-green-600 text-2xl"></i>
                </div>
            </div>
        </div>
        
        <div class="bg-white rounded-xl p-6 shadow-md dashboard-card border border-gray-100">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-gray-500 text-sm font-medium">High Priority</p>
                    <p class="text-3xl font-bold text-gray-900 mt-2">{{ $highPriorityTickets }}</p>
                </div>
                <div class="w-14 h-14 bg-red-100 rounded-xl flex items-center justify-center">
                    <i class="fas fa-exclamation-triangle text-red-600 text-2xl"></i>
                </div>
            </div>
        </div>
        
    @else
        <!-- Regular User Stats Cards -->
        <div class="bg-white rounded-xl p-6 shadow-md dashboard-card border border-gray-100">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-gray-500 text-sm font-medium">My Tickets</p>
                    <p class="text-3xl font-bold text-gray-900 mt-2">{{ $totalTickets }}</p>
                </div>
                <div class="w-14 h-14 bg-blue-100 rounded-xl flex items-center justify-center">
                    <i class="fas fa-ticket-alt text-blue-600 text-2xl"></i>
                </div>
            </div>
            @if(request()->status || request()->search)
                <p class="text-xs text-gray-400 mt-2">Filtered results</p>
            @endif
        </div>
        
        <div class="bg-white rounded-xl p-6 shadow-md dashboard-card border border-gray-100">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-gray-500 text-sm font-medium">Active</p>
                    <p class="text-3xl font-bold text-gray-900 mt-2">{{ $activeTickets }}</p>
                </div>
                <div class="w-14 h-14 bg-yellow-100 rounded-xl flex items-center justify-center">
                    <i class="fas fa-clock text-yellow-600 text-2xl"></i>
                </div>
            </div>
        </div>
        
        <div class="bg-white rounded-xl p-6 shadow-md dashboard-card border border-gray-100">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-gray-500 text-sm font-medium">Resolved</p>
                    <p class="text-3xl font-bold text-gray-900 mt-2">{{ $resolvedTickets }}</p>
                </div>
                <div class="w-14 h-14 bg-green-100 rounded-xl flex items-center justify-center">
                    <i class="fas fa-check-circle text-green-600 text-2xl"></i>
                </div>
            </div>
        </div>
        
        <div class="bg-white rounded-xl p-6 shadow-md dashboard-card border border-gray-100">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-gray-500 text-sm font-medium">Pending Review</p>
                    <p class="text-3xl font-bold text-gray-900 mt-2">{{ $pendingReviewTickets }}</p>
                </div>
                <div class="w-14 h-14 bg-orange-100 rounded-xl flex items-center justify-center">
                    <i class="fas fa-hourglass-half text-orange-600 text-2xl"></i>
                </div>
            </div>
        </div>
    @endif
</div>

<!-- Additional row for Admin with system-wide stats -->
@if($user->user_type === 'admin')
    @php
        // Use full namespace for User and TicketCategory models
        $userModel = 'App\\Models\\User';
        $categoryModel = 'App\\Models\\TicketCategory';
        
        // System-wide stats (not filtered by search/status)
        $totalUsers = $userModel::count();
        $activeTechs = $userModel::where('user_type', 'tech')->where('is_active', true)->count();
        $totalCategories = $categoryModel::count();
    @endphp
@endif

<!-- Optional: Show active filters indicator -->
@if(request()->status || request()->search)
<div class="mb-4 px-4 py-2 bg-blue-50 text-blue-700 rounded-lg flex items-center justify-between">
    <div class="flex items-center space-x-2">
        <i class="fas fa-filter"></i>
        <span>Showing filtered results</span>
        @if(request()->status && request()->status !== 'all')
            <span class="px-2 py-1 bg-blue-100 rounded-full text-xs">Status: {{ ucfirst(request()->status) }}</span>
        @endif
        @if(request()->search)
            <span class="px-2 py-1 bg-blue-100 rounded-full text-xs">Search: "{{ request()->search }}"</span>
        @endif
    </div>
    <a href="{{ route('tickets.index') }}" class="text-blue-700 hover:text-blue-900">
        <i class="fas fa-times"></i>
    </a>
</div>
@endif
            <!-- Tickets Table - Enhanced with better styling -->
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
                                <th class="px-6 py-4 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Created</th>
                                <th class="px-6 py-4 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Last Update</th>
                                <th class="px-6 py-4 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Actions</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-gray-200">
                            @forelse($tickets as $ticket)
                            <tr class="hover:bg-gray-50 transition">
                                <td class="px-6 py-4">
                                    <span class="font-mono text-sm font-medium text-primary bg-primary/5 px-3 py-1.5 rounded-lg">
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
                                </td>
                                <td class="px-6 py-4">
                                    <span class="inline-flex items-center px-3 py-1.5 rounded-full text-xs font-medium 
                                        @if($ticket->priority === 'high') bg-red-100 text-red-800 shadow-sm
                                        @elseif($ticket->priority === 'medium') bg-yellow-100 text-yellow-800 shadow-sm
                                        @elseif($ticket->priority === 'low') bg-green-100 text-green-800 shadow-sm
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
                                <td class="px-6 py-4 text-sm text-gray-600">
                                    <div class="flex items-center">
                                        <i class="fas fa-clock text-gray-400 mr-2 text-xs"></i>
                                        {{ $ticket->updated_at->diffForHumans() }}
                                    </div>
                                </td>
                                <td class="px-6 py-4">
                                    <a href="{{ url('/tickets/my_tickets_view/' . $ticket->id) }}" 
                                    class="inline-flex items-center px-4 py-2 bg-primary/10 text-primary hover:bg-primary hover:text-white rounded-lg transition text-sm font-medium group">
                                        <span>View</span>
                                        <i class="fas fa-arrow-right ml-2 text-xs group-hover:translate-x-1 transition-transform"></i>
                                    </a>
                                </td>
                            </tr>
                            @empty
                            <tr>
                                <td colspan="7" class="px-6 py-16 text-center">
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
                
              <!-- Pagination - Custom styled buttons -->
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
                mobileMenuButton.addEventListener('click', function(e) {
                    e.stopPropagation();
                    mobileMenu.classList.toggle('hidden');
                });
                
                // Close mobile menu when clicking outside
                document.addEventListener('click', function(event) {
                    if (mobileMenu && !mobileMenu.contains(event.target) && 
                        mobileMenuButton && !mobileMenuButton.contains(event.target)) {
                        mobileMenu.classList.add('hidden');
                    }
                });
            }
            
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
            
            // Filter buttons functionality
            const filterButtons = document.querySelectorAll('.bg-gray-100');
            const allButton = document.querySelector('.bg-primary');
            
            filterButtons.forEach(button => {
                button.addEventListener('click', function() {
                    // Remove active class from all buttons
                    filterButtons.forEach(btn => {
                        btn.classList.remove('bg-primary', 'text-white');
                        btn.classList.add('bg-gray-100', 'hover:bg-gray-200', 'text-gray-700');
                    });
                    
                    if (allButton) {
                        allButton.classList.remove('bg-primary', 'text-white');
                        allButton.classList.add('bg-gray-100', 'hover:bg-gray-200', 'text-gray-700');
                    }
                    
                    // Add active class to clicked button
                    this.classList.remove('bg-gray-100', 'hover:bg-gray-200', 'text-gray-700');
                    this.classList.add('bg-primary', 'text-white');
                });
            });
            
            if (allButton) {
                allButton.addEventListener('click', function() {
                    // Remove active class from all buttons
                    filterButtons.forEach(btn => {
                        btn.classList.remove('bg-primary', 'text-white');
                        btn.classList.add('bg-gray-100', 'hover:bg-gray-200', 'text-gray-700');
                    });
                    
                    // Add active class to All button
                    filterButtons.forEach(btn => btn.classList.remove('bg-primary', 'text-white'));
                    this.classList.add('bg-primary', 'text-white');
                });
            }
        });
    </script>
</body>
</html>