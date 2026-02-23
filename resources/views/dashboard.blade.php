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
                    <!-- Navigation Links -->
                    <a href="/dashboard" class="text-primary font-medium transition flex items-center space-x-2">
                        <i class="fas fa-home"></i>
                        <span>Dashboard</span>
                    </a>
                    
                    <a href="/tickets" class="text-gray-700 hover:text-primary font-medium transition flex items-center space-x-2">
                        <i class="fas fa-ticket-alt"></i>
                        <span>My Tickets</span>
                    </a>
                    
                    <a href="/tickets/create" class="text-gray-700 hover:text-primary font-medium transition flex items-center space-x-2">
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
                        <div class="absolute right-0 mt-2 w-48 bg-white rounded-lg shadow-lg py-2 z-50 opacity-0 invisible group-hover:opacity-100 group-hover:visible transition-all duration-200">
                            <div class="px-4 py-3 border-b border-gray-100">
                                <p class="text-xs text-gray-500 truncate">{{ auth()->user()->email }}</p>
                                <p class="text-xs font-medium text-primary">Client Account</p>

                            </div>
                            
                            <a href="{{ route('profile.dashboard') }}" class="flex items-center space-x-2 px-4 py-2 text-sm text-gray-700 hover:bg-gray-50 transition">
                                <i class="fas fa-user text-gray-400"></i>
                                <span>My Profile</span>
                            </a>
                            
                            
                            <div class="border-t border-gray-100 my-1"></div>
                            
                            <form method="POST" action="{{ route('sign-out') }}" class="w-full">
                                @csrf
                                <button type="submit" class="flex items-center space-x-2 px-4 py-2 text-sm text-red-600 hover:bg-gray-50 transition w-full text-left">
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
                        <p class="text-xs text-gray-500">Client Account</p>
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
                
                <div class="border-t border-gray-100 pt-3">
                    <a href="{{ route('profile.dashboard') }}" class="flex items-center space-x-2 px-2 py-3 text-gray-700 hover:bg-gray-50 rounded-lg transition">
                        <i class="fas fa-user text-gray-400"></i>
                        <span>My Profile</span>
                    </a>
                    
                    <form method="POST" action="{{ route('sign-out') }}" class="mt-2">
                        @csrf
                        <button type="submit" class="flex items-center space-x-2 px-2 py-3 text-red-600 hover:bg-gray-50 rounded-lg transition w-full">
                            <i class="fas fa-sign-out-alt"></i>
                            <span>Sign Out</span>
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </nav>

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
                    <a href="/tickets/create" class="inline-flex items-center space-x-2 bg-white text-primary px-6 py-3 rounded-lg font-semibold hover:bg-gray-100 transition shadow-lg">
                        <i class="fas fa-plus"></i>
                        <span>Request Support</span>
                    </a>
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
                    <div class="grid grid-cols-1 sm:grid-cols-3 gap-4 mb-6">
                        <a href="/tickets/create" class="bg-white p-4 rounded-xl shadow-md hover:shadow-lg transition flex items-center space-x-3 dashboard-card">
                            <div class="w-12 h-12 bg-primary/10 rounded-lg flex items-center justify-center">
                                <i class="fas fa-plus text-primary text-xl"></i>
                            </div>
                            <div>
                                <p class="font-medium text-gray-900">New Ticket</p>
                                <p class="text-sm text-gray-500">Report an issue</p>
                            </div>
                        </a>
                        
                        <a href="/tickets" class="bg-white p-4 rounded-xl shadow-md hover:shadow-lg transition flex items-center space-x-3 dashboard-card">
                            <div class="w-12 h-12 bg-support/10 rounded-lg flex items-center justify-center">
                                <i class="fas fa-ticket-alt text-support text-xl"></i>
                            </div>
                            <div>
                                <p class="font-medium text-gray-900">My Tickets</p>
                                <p class="text-sm text-gray-500">View all requests</p>
                            </div>
                        </a>
                        
                    </div>

                    <!-- Recent Tickets - FIXED: Removed inline onclick, using data attribute instead -->
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
                                    <div class="absolute left-0 top-0 h-full w-1 bg-transparent group-hover:bg-{{ $ticket->priority === 'high' ? 'red' : ($ticket->priority === 'medium' ? 'yellow' : 'green') }}-500 transition-all duration-200"></div>
                                    
                                    <div class="flex items-start justify-between pl-2">
                                        <div class="flex-1">
                                            <div class="flex items-center justify-between mb-2">
                                                <span class="status-badge status-{{ $ticket->status === 'in_progress' ? 'in-progress' : $ticket->status }}">
                                                    @if($ticket->status === 'in_progress')
                                                        <i class="fas fa-spinner text-xs mr-1 animate-spin"></i>
                                                        In Progress
                                                    @elseif($ticket->status === 'open')
                                                        <i class="fas fa-circle text-xs mr-1"></i>
                                                        Open
                                                    @elseif($ticket->status === 'pending')
                                                        <i class="fas fa-clock text-xs mr-1"></i>
                                                        Pending
                                                    @elseif($ticket->status === 'resolved')
                                                        <i class="fas fa-check-circle text-xs mr-1"></i>
                                                        Resolved
                                                    @elseif($ticket->status === 'closed')
                                                        <i class="fas fa-check-double text-xs mr-1"></i>
                                                        Closed
                                                    @endif
                                                </span>
                                                <span class="text-xs text-gray-500 font-mono">{{ $ticket->ticket_number }}</span>
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
                                                    
                                                    @if($ticket->priority === 'high')
                                                        <span class="flex items-center text-red-600">
                                                            <i class="fas fa-exclamation-triangle mr-1"></i>
                                                            High Priority
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
                    
                    <!-- Support Contact -->
                    <div class="bg-gradient-to-r from-primary to-primaryDark rounded-xl p-6 text-white">
                        <h3 class="text-lg font-semibold mb-3">Need Immediate Help?</h3>
                        <p class="text-primary-100 mb-4">Our support team is here to help you with any issues.</p>
                        <div class="space-y-3">
                            <div class="flex items-center space-x-3">
                                <i class="fas fa-phone"></i>
                                <div>
                                    <p class="text-sm opacity-90">Emergency Support</p>
                                    <p class="font-semibold">1-800-DATAWORLD</p>
                                </div>
                            </div>
                            <div class="flex items-center space-x-3">
                                <i class="fas fa-envelope"></i>
                                <div>
                                    <p class="text-sm opacity-90">Email Support</p>
                                    <p class="font-semibold">support@dataworld.com</p>
                                </div>
                            </div>
                        </div>
                        <button class="w-full mt-4 bg-white text-primary py-2 px-4 rounded-lg font-semibold hover:bg-gray-100 transition">
                            <i class="fas fa-comment-dots mr-2"></i>
                            Start Live Chat
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </main>

    <!-- Footer - Fixed at bottom -->
    <footer class="bg-gray-900 text-gray-400 py-8">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex flex-col md:flex-row justify-between items-center">
                <div class="mb-6 md:mb-0">
                    <div class="flex items-center space-x-3 mb-4">
                        <img src="{{ asset('images/dwcc.png') }}" 
                             alt="Dataworld Logo" 
                             class="h-8 w-auto">
                    </div>
                    <p class="text-sm">© {{ date('Y') }} Dataworld Computer Center. All rights reserved.</p>
                </div>
                <div class="flex space-x-6">
                    <a href="/privacy" class="text-sm hover:text-white transition">Privacy Policy</a>
                    <a href="/terms" class="text-sm hover:text-white transition">Terms of Service</a>
                    <a href="/contact" class="text-sm hover:text-white transition">Contact Us</a>
                </div>
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