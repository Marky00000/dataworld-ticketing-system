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
    </style>
</head>
<body class="bg-gray-50 min-h-screen">
   <!-- Top Navigation Bar -->
    <nav class="bg-white shadow-lg border-b border-gray-200">
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
                  <!-- Navigation Links -->
                      <a href="/dashboard" class="{{ request()->is('dashboard') ? 'text-primary font-medium' : 'text-gray-700 hover:text-primary' }} transition flex items-center space-x-2 pb-1">
                            <i class="fas fa-home"></i>
                            <span>Dashboard</span>
                        </a>

                    <a href="/tickets" class="{{ request()->is('tickets') || request()->is('tickets/*') ? 'text-primary border-b-2 border-primary' : 'text-gray-700 hover:text-primary' }} font-medium transition flex items-center space-x-2 pb-1">
                        <i class="fas fa-ticket-alt"></i>
                        <span>My Tickets</span>
                    </a>

                    <a href="/tickets/create" class="{{ request()->is('tickets/create') ? 'text-primary border-b-2 border-primary' : 'text-gray-700 hover:text-primary' }} font-medium transition flex items-center space-x-2 pb-1">
                        <i class="fas fa-plus-circle"></i>
                        <span>New Ticket</span>
                    </a>
                    
                    
                    <!-- User Dropdown -->
                    <div class="relative group">
                        <button class="flex items-center space-x-3 focus:outline-none">
                            <div class="flex items-center space-x-3">
                                <div class="w-10 h-10 bg-gradient-to-r from-primary to-support rounded-full flex items-center justify-center text-white font-semibold">
                                    {{ substr(auth()->user()->name, 0, 1) }}
                                </div>
                                <div class="text-left hidden lg:block">
                                    <p class="text-sm font-medium text-gray-900">{{ auth()->user()->name }}</p>
                                </div>
                            </div>
                            <i class="fas fa-chevron-down text-gray-400 text-sm"></i>
                        </button>
                        
                        <!-- Dropdown Menu -->
                        <div class="absolute right-0 mt-2 w-56 bg-white rounded-lg shadow-lg py-2 z-50 opacity-0 invisible group-hover:opacity-100 group-hover:visible transition-all duration-200">
                            <div class="px-4 py-3 border-b border-gray-100">
                                <p class="text-sm font-medium text-gray-900">{{ auth()->user()->name }}</p>
                                <p class="text-xs text-gray-500 truncate">{{ auth()->user()->email }}</p>
                                <p class="text-xs font-medium text-primary">Admin Account</p>

                            </div>
                            
                            <a href="{{ route('profile.dashboard') }}" class="flex items-center space-x-2 px-4 py-2 text-sm text-gray-700 hover:bg-gray-50 transition">
                                <i class="fas fa-user text-gray-400"></i>
                                <span>My Profile</span>
                            </a>
                            
                            
                            @if(auth()->user()->user_type === 'admin')
                            <a href="{{ route('admin.tech.create') }}" class="flex items-center space-x-2 px-4 py-2 text-sm text-blue-600 hover:bg-blue-50 transition border-t border-gray-100 mt-1 pt-3">
                                <i class="fas fa-user-plus text-blue-500"></i>
                                <span class="font-medium">Create Tech Account</span>
                            </a>
                            @endif
                            
                            <div class="border-t border-gray-100 my-1"></div>
                            
                            <form method="POST" action="{{ route('sign-out') }}" class="w-full">
                                @csrf
                                <button type="submit" class="flex items-center space-x-2 px-4 py-2 text-sm text-red-600 hover:bg-red-50 transition w-full text-left">
                                    <i class="fas fa-sign-out-alt"></i>
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
        
        <!-- Mobile Menu -->
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
                
                <a href="/dashboard" class="flex items-center space-x-2 px-2 py-3 text-primary bg-primary/5 rounded-lg transition">
                    <i class="fas fa-home"></i>
                    <span>Dashboard</span>
                </a>
                
                <a href="/tickets" class="flex items-center space-x-2 px-2 py-3 text-gray-700 hover:bg-gray-50 rounded-lg transition">
                    <i class="fas fa-ticket-alt text-gray-400"></i>
                    <span>My Tickets</span>
                </a>
                
                <a href="/tickets/create" class="flex items-center space-x-2 px-2 py-3 text-gray-700 hover:bg-gray-50 rounded-lg transition">
                    <i class="fas fa-plus-circle text-gray-400"></i>
                    <span>New Ticket</span>
                </a>
                
                <a href="/knowledge-base" class="flex items-center space-x-2 px-2 py-3 text-gray-700 hover:bg-gray-50 rounded-lg transition">
                    <i class="fas fa-book text-gray-400"></i>
                    <span>Knowledge Base</span>
                </a>
               
                <!-- Create Tech Account Button - Mobile - ONLY VISIBLE TO ADMINS -->
                @if(auth()->user()->user_type === 'admin')
                <div class="border-t border-gray-100 pt-3 mt-3">
                    <a href="{{ route('admin.tech.create') }}" class="flex items-center space-x-2 px-2 py-3 text-blue-600 hover:bg-blue-50 rounded-lg transition">
                        <i class="fas fa-user-plus text-blue-500"></i>
                        <span class="font-medium">Create Tech Account</span>
                        <span class="ml-auto text-xs bg-blue-100 text-blue-800 px-2 py-0.5 rounded-full">Admin</span>
                    </a>
                </div>
                @endif
                
                <div class="border-t border-gray-100 pt-3">
                    <a href="{{ route('profile.dashboard') }}" class="flex items-center space-x-2 px-2 py-3 text-gray-700 hover:bg-gray-50 rounded-lg transition">
                        <i class="fas fa-user text-gray-400"></i>
                        <span>My Profile</span>
                    </a>
                    
                    
                    <form method="POST" action="{{ route('sign-out') }}" class="mt-2">
                        @csrf
                        <button type="submit" class="flex items-center space-x-2 px-2 py-3 text-red-600 hover:bg-red-50 rounded-lg transition w-full">
                            <i class="fas fa-sign-out-alt"></i>
                            <span>Sign Out</span>
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </nav>

    <!-- Main Content -->
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
                <a href="/tickets/create" class="mt-4 md:mt-0 inline-flex items-center space-x-2 bg-white text-primary px-6 py-3 rounded-lg font-semibold hover:bg-gray-100 transition">
                    <i class="fas fa-plus"></i>
                    <span>Create New Ticket</span>
                </a>
            </div>
        </div>

        <!-- Stats Cards -->
     <!-- Stats Cards -->
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6 mb-8">
            <div class="bg-white rounded-xl shadow-md p-6 dashboard-card">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-gray-500 text-sm font-medium">Open Tickets</p>
                        <p class="text-3xl font-bold text-gray-800 mt-2">{{ $ticketStats['open'] ?? 0 }}</p>
                    </div>
                    <div class="w-12 h-12 bg-blue-100 rounded-full flex items-center justify-center">
                        <i class="fas fa-ticket-alt text-blue-600 text-xl"></i>
                    </div>
                </div>
                <div class="mt-4">
                    <span class="text-xs {{ ($ticketStats['open_percentage'] ?? 0) >= 0 ? 'text-green-600' : 'text-red-600' }} font-medium">
                        <i class="fas fa-{{ ($ticketStats['open_percentage'] ?? 0) >= 0 ? 'arrow-up' : 'arrow-down' }} mr-1"></i>
                        {{ abs($ticketStats['open_percentage'] ?? 0) }}% from yesterday
                    </span>
                </div>
            </div>
            
            <div class="bg-white rounded-xl shadow-md p-6 dashboard-card">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-gray-500 text-sm font-medium">In Progress</p>
                        <p class="text-3xl font-bold text-gray-800 mt-2">{{ $ticketStats['in_progress'] ?? 0 }}</p>
                    </div>
                    <div class="w-12 h-12 bg-orange-100 rounded-full flex items-center justify-center">
                        <i class="fas fa-spinner text-orange-600 text-xl"></i>
                    </div>
                </div>
                <div class="mt-4">
                    <span class="text-xs {{ ($ticketStats['in_progress_percentage'] ?? 0) <= 0 ? 'text-green-600' : 'text-red-600' }} font-medium">
                        <i class="fas fa-{{ ($ticketStats['in_progress_percentage'] ?? 0) <= 0 ? 'arrow-down' : 'arrow-up' }} mr-1"></i>
                        {{ abs($ticketStats['in_progress_percentage'] ?? 0) }}% from yesterday
                    </span>
                </div>
            </div>
            
            <div class="bg-white rounded-xl shadow-md p-6 dashboard-card">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-gray-500 text-sm font-medium">Resolved</p>
                        <p class="text-3xl font-bold text-gray-800 mt-2">{{ $ticketStats['resolved'] ?? 0 }}</p>
                    </div>
                    <div class="w-12 h-12 bg-green-100 rounded-full flex items-center justify-center">
                        <i class="fas fa-check-circle text-green-600 text-xl"></i>
                    </div>
                </div>
                <div class="mt-4">
                    <span class="text-xs {{ ($ticketStats['resolved_percentage'] ?? 0) >= 0 ? 'text-green-600' : 'text-red-600' }} font-medium">
                        <i class="fas fa-{{ ($ticketStats['resolved_percentage'] ?? 0) >= 0 ? 'arrow-up' : 'arrow-down' }} mr-1"></i>
                        {{ abs($ticketStats['resolved_percentage'] ?? 0) }}% from yesterday
                    </span>
                </div>
            </div>
            
            <div class="bg-white rounded-xl shadow-md p-6 dashboard-card">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-gray-500 text-sm font-medium">Total Tickets</p>
                        <p class="text-3xl font-bold text-gray-800 mt-2">{{ $ticketStats['total'] ?? 0 }}</p>
                    </div>
                    <div class="w-12 h-12 bg-purple-100 rounded-full flex items-center justify-center">
                        <i class="fas fa-clipboard-list text-purple-600 text-xl"></i>
                    </div>
                </div>
                <div class="mt-4">
                    <span class="text-xs text-gray-600 font-medium">
                        <i class="fas fa-calendar mr-1"></i>
                        {{ $ticketStats['total_change'] ?? 0 }} new this week
                    </span>
                </div>
            </div>
        </div>

        <!-- Recent Tickets & Quick Actions -->
        <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
               
<!-- Recent Tickets -->
<div class="lg:col-span-2">
    <div class="bg-white rounded-xl shadow-md overflow-hidden">
        <div class="px-6 py-4 border-b border-gray-200">
            <div class="flex items-center justify-between">
                <h2 class="text-lg font-semibold text-gray-800">Recent Tickets</h2>
                <a href="{{ route('tickets.index') }}" class="text-primary hover:text-primaryDark text-sm font-medium">
                    View All <i class="fas fa-arrow-right ml-1"></i>
                </a>
            </div>
        </div>
        
        <!-- Scrollable tickets container -->
        <div class="divide-y divide-gray-100 max-h-[500px] overflow-y-auto custom-scrollbar">
            @forelse($recentTickets ?? [] as $ticket)
            
            <div class="relative p-6 hover:bg-gray-50 transition cursor-pointer group" 
                 onclick="window.location.href='{{ route('tickets.my_tickets_view', $ticket->id) }}'">
                <!-- Dynamic colored left border on hover -->
                <div class="absolute left-0 top-0 h-full w-1 bg-transparent group-hover:bg-{{ $ticket->priority === 'high' ? 'red' : ($ticket->priority === 'medium' ? 'yellow' : 'green') }}-500 transition-all duration-200"></div>
                
                <div class="flex items-start justify-between pl-2">
                    <div class="flex-1">
                        <div class="flex items-center space-x-2 mb-2">
                           <span class="status-badge inline-flex items-center px-3 py-1.5 rounded-full text-xs font-medium
                                @if($ticket->status === 'in_progress') bg-blue-100 text-blue-800
                                @elseif($ticket->status === 'open') bg-green-100 text-green-800
                                @elseif($ticket->status === 'pending') bg-yellow-100 text-yellow-800
                                @elseif($ticket->status === 'resolved') bg-purple-100 text-purple-800
                                @elseif($ticket->status === 'closed') bg-red-100 text-red-800
                                @endif">
                                
                                @if($ticket->status === 'in_progress')
                                    <span class="w-2 h-2 rounded-full bg-blue-500 mr-1.5 animate-pulse"></span>
                                    In Progress
                                @elseif($ticket->status === 'open')
                                    <span class="w-2 h-2 rounded-full bg-green-500 mr-1.5"></span>
                                    Open
                                @elseif($ticket->status === 'pending')
                                    <span class="w-2 h-2 rounded-full bg-yellow-500 mr-1.5"></span>
                                    Pending
                                @elseif($ticket->status === 'resolved')
                                    <span class="w-2 h-2 rounded-full bg-purple-500 mr-1.5"></span>
                                    Resolved
                                @elseif($ticket->status === 'closed')
                                    <span class="w-2 h-2 rounded-full bg-red-500 mr-1.5"></span>
                                    Closed
                                @endif
                            </span>
                            <span class="text-xs text-gray-500 font-mono">{{ $ticket->ticket_number }}</span>
                        </div>
                        
                        <h3 class="font-medium text-gray-900 mb-1">{{ $ticket->subject }}</h3>
                        
                        <p class="text-gray-600 text-sm mb-2 line-clamp-2">
                            {{ Str::limit($ticket->description, 100) }}
                        </p>
                        
                        <div class="flex items-center space-x-4 text-xs text-gray-500">
                            <span class="flex items-center">
                                <i class="fas fa-calendar mr-1"></i>
                                {{ $ticket->created_at->format('M d, Y') }}
                            </span>
                            
                            <span class="flex items-center">
                                <i class="fas fa-user mr-1"></i>
                                {{ $ticket->creator->name ?? 'Unknown' }}
                            </span>
                            
                            @if($ticket->assignedTech)
                                <span class="flex items-center">
                                    <i class="fas fa-user-tie mr-1"></i>
                                    {{ $ticket->assignedTech->name }}
                                </span>
                            @else
                                <span class="flex items-center">
                                    <i class="fas fa-user-clock mr-1"></i>
                                    Unassigned
                                </span>
                            @endif
                            
                            @if($ticket->priority === 'high')
                                <span class="flex items-center text-red-600">
                                    <i class="fas fa-exclamation-triangle mr-1"></i>
                                    High
                                </span>
                            @elseif($ticket->priority === 'medium')
                                <span class="flex items-center text-yellow-600">
                                    <i class="fas fa-minus-circle mr-1"></i>
                                    Medium
                                </span>
                            @elseif($ticket->priority === 'low')
                                <span class="flex items-center text-green-600">
                                    <i class="fas fa-arrow-down mr-1"></i>
                                    Low
                                </span>
                            @endif
                        </div>
                    </div>
                    <i class="fas fa-chevron-right text-gray-400 mt-6 ml-4"></i>
                </div>
            </div>
            @empty
            <div class="p-12 text-center">
                <div class="flex flex-col items-center justify-center">
                    <i class="fas fa-ticket-alt text-gray-300 text-5xl mb-4"></i>
                    <h3 class="text-lg font-medium text-gray-700 mb-2">No tickets found</h3>
                    <p class="text-gray-500 text-sm">There are no support tickets in the system yet.</p>
                </div>
            </div>
            @endforelse
        </div>
        
        <!-- View All button at bottom -->
        <div class="px-6 py-3 bg-gray-50 border-t border-gray-200 text-center">
            <a href="{{ route('tickets.index') }}" class="text-primary hover:text-primaryDark text-sm font-medium inline-flex items-center">
                View All Tickets <i class="fas fa-arrow-right ml-2"></i>
            </a>
        </div>
    </div>
</div>
            
            <!-- Quick Actions & Resources -->
            <div class="space-y-6">
                <!-- Quick Actions -->
                <div class="bg-white rounded-xl shadow-md p-6">
                    <h3 class="text-lg font-semibold text-gray-800 mb-4">Quick Actions</h3>
                    <div class="space-y-3">
                        <a href="/tickets/create" class="flex items-center space-x-3 p-3 bg-primary/5 hover:bg-primary/10 rounded-lg transition group">
                            <div class="w-10 h-10 bg-primary rounded-lg flex items-center justify-center">
                                <i class="fas fa-plus text-white"></i>
                            </div>
                            <div>
                                <p class="font-medium text-gray-900">New Support Ticket</p>
                                <p class="text-sm text-gray-500">Report a new issue</p>
                            </div>
                        </a>
                        
                        <a href="/tickets" class="flex items-center space-x-3 p-3 bg-support/5 hover:bg-support/10 rounded-lg transition group">
                            <div class="w-10 h-10 bg-support rounded-lg flex items-center justify-center">
                                <i class="fas fa-ticket-alt text-white"></i>
                            </div>
                            <div>
                                <p class="font-medium text-gray-900">View My Tickets</p>
                                <p class="text-sm text-gray-500">Check ticket status</p>
                            </div>
                        </a>
                        
                        <a href="/knowledge-base" class="flex items-center space-x-3 p-3 bg-warning/5 hover:bg-warning/10 rounded-lg transition group">
                            <div class="w-10 h-10 bg-warning rounded-lg flex items-center justify-center">
                                <i class="fas fa-book text-white"></i>
                            </div>
                            <div>
                                <p class="font-medium text-gray-900">Knowledge Base</p>
                                <p class="text-sm text-gray-500">Find solutions</p>
                            </div>
                        </a>
                        
                        <a href="{{ route('profile.dashboard') }}" class="flex items-center space-x-3 p-3 bg-gray-100 hover:bg-gray-200 rounded-lg transition group">
                            <div class="w-10 h-10 bg-gray-300 rounded-lg flex items-center justify-center">
                                <i class="fas fa-user text-gray-700"></i>
                            </div>
                            <div>
                                <p class="font-medium text-gray-900">Update Profile</p>
                                <p class="text-sm text-gray-500">Manage account details</p>
                            </div>
                        </a>
                    </div>
                </div>
                
                <!-- Support Status -->
                <div class="bg-white rounded-xl shadow-md p-6">
                    <h3 class="text-lg font-semibold text-gray-800 mb-4">Support Status</h3>
                    <div class="space-y-4">
                        <div class="flex items-center justify-between">
                            <span class="text-gray-700">System Status</span>
                            <span class="flex items-center text-green-600">
                                <div class="w-2 h-2 bg-green-500 rounded-full mr-2 animate-pulse"></div>
                                Operational
                            </span>
                        </div>
                        <div class="flex items-center justify-between">
                            <span class="text-gray-700">Response Time</span>
                            <span class="font-medium text-gray-900">Under 1 hour</span>
                        </div>
                        <div class="flex items-center justify-between">
                            <span class="text-gray-700">Support Hours</span>
                            <span class="font-medium text-gray-900">24/7 Available</span>
                        </div>
                        <div class="pt-4 border-t border-gray-100">
                            <p class="text-sm text-gray-600 mb-2">Need immediate assistance?</p>
                            <div class="flex items-center space-x-2">
                                <i class="fas fa-phone text-primary"></i>
                                <span class="font-medium">1-800-DATAWORLD</span>
                            </div>
                        </div>
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
                if (!mobileMenu.contains(event.target) && !mobileMenuButton.contains(event.target)) {
                    mobileMenu.classList.add('hidden');
                }
            });
            
            // User dropdown hover
            const userDropdown = document.querySelector('.relative.group');
            if (userDropdown) {
                userDropdown.addEventListener('mouseenter', function() {
                    const dropdown = this.querySelector('.absolute');
                    dropdown.classList.remove('opacity-0', 'invisible');
                    dropdown.classList.add('opacity-100', 'visible');
                });
                
                userDropdown.addEventListener('mouseleave', function() {
                    const dropdown = this.querySelector('.absolute');
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