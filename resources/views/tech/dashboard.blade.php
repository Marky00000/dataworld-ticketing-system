<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Technical Dashboard - Dataworld Support Portal</title>
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
        
        /* Technician badge */
        .tech-badge {
            background: linear-gradient(135deg, #6366f1 0%, #10b981 100%);
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
        
        /* Dropdown transition */
        .dropdown-transition {
            transition: opacity 0.2s ease, visibility 0.2s ease, transform 0.2s ease;
            transform-origin: top right;
        }
        
        .group:hover .dropdown-transition {
            opacity: 1;
            visibility: visible;
            transform: scale(1);
        }
        
        /* Line clamp */
        .line-clamp-2 {
            display: -webkit-box;
            -webkit-line-clamp: 2;
            -webkit-box-orient: vertical;
            overflow: hidden;
        }
    </style>
</head>
<body class="bg-gray-50 min-h-screen">
    
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
                <!-- Dashboard Link -->
                <a href="/dashboard" 
                   class="{{ request()->is('dashboard') ? 'text-primary' : 'text-gray-700 hover:text-primary' }} font-medium transition-all duration-300 flex items-center space-x-2 relative group">
                    <i class="fas fa-home"></i>
                    <span>Dashboard</span>
                    @if(request()->is('dashboard'))
                        <span class="absolute -bottom-1 left-0 w-full h-0.5 bg-primary"></span>
                    @else
                        <span class="absolute -bottom-1 left-0 w-0 h-0.5 bg-primary group-hover:w-full transition-all duration-300"></span>
                    @endif
                </a>

                <!-- My Tickets Link -->
                <a href="/tickets" 
                   class="{{ request()->is('tickets') || request()->is('tickets/*') ? 'text-primary' : 'text-gray-700 hover:text-primary' }} font-medium transition-all duration-300 flex items-center space-x-2 relative group">
                    <i class="fas fa-ticket-alt"></i>
                    <span>My Tickets</span>
                    @if(request()->is('tickets') || request()->is('tickets/*'))
                        <span class="absolute -bottom-1 left-0 w-full h-0.5 bg-primary"></span>
                    @else
                        <span class="absolute -bottom-1 left-0 w-0 h-0.5 bg-primary group-hover:w-full transition-all duration-300"></span>
                    @endif
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
                                <div class="absolute -bottom-0.5 -right-0.5 w-3 h-3 bg-green-500 rounded-full border-2 border-white"></div>
                            </div>
                            <div class="text-left hidden lg:block">
                                <p class="text-sm font-medium text-gray-900">{{ auth()->user()->name }}</p>
                            </div>
                        </div>
                        <i class="fas fa-chevron-down text-gray-400 text-sm transition-transform duration-300 group-hover:rotate-180"></i>
                    </button>
                    
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
                                        <i class="fas fa-tools mr-1 text-[8px]"></i>
                                        Tech Account
                                    </span>
                                </div>
                            </div>
                        </div>
                        
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
                            Tech Account
                        </span>
                        <span class="inline-flex items-center text-xs text-gray-500">
                            <i class="fas fa-circle text-green-500 text-[6px] mr-1"></i>
                            Online
                        </span>
                    </div>
                </div>
            </div>
            
            <!-- Navigation Items -->
            <a href="/dashboard" 
               class="flex items-center space-x-3 px-4 py-3 {{ request()->is('dashboard') ? 'text-primary bg-primary/5 border border-primary/20' : 'text-gray-700 hover:bg-gray-50' }} rounded-xl transition-all duration-300 group">
                <div class="w-10 h-10 {{ request()->is('dashboard') ? 'bg-primary/10' : 'bg-gray-100 group-hover:bg-primary/10' }} rounded-xl flex items-center justify-center transition-colors">
                    <i class="fas fa-home {{ request()->is('dashboard') ? 'text-primary' : 'text-gray-500 group-hover:text-primary' }}"></i>
                </div>
                <div class="flex-1">
                    <p class="font-medium {{ request()->is('dashboard') ? 'text-primary' : 'text-gray-900' }}">Dashboard</p>
                    <p class="text-xs text-gray-500">Overview & statistics</p>
                </div>
                @if(request()->is('dashboard'))
                    <i class="fas fa-check-circle text-primary"></i>
                @endif
            </a>
            
            <a href="/tickets" 
               class="flex items-center space-x-3 px-4 py-3 {{ request()->is('tickets') || request()->is('tickets/*') ? 'text-primary bg-primary/5 border border-primary/20' : 'text-gray-700 hover:bg-gray-50' }} rounded-xl transition-all duration-300 group">
                <div class="w-10 h-10 {{ request()->is('tickets') || request()->is('tickets/*') ? 'bg-primary/10' : 'bg-gray-100 group-hover:bg-primary/10' }} rounded-xl flex items-center justify-center transition-colors">
                    <i class="fas fa-ticket-alt {{ request()->is('tickets') || request()->is('tickets/*') ? 'text-primary' : 'text-gray-500 group-hover:text-primary' }}"></i>
                </div>
                <div class="flex-1">
                    <p class="font-medium {{ request()->is('tickets') || request()->is('tickets/*') ? 'text-primary' : 'text-gray-900' }}">Assigned Tickets</p>
                    <p class="text-xs text-gray-500">View your assigned tickets</p>
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
            
            <div class="border-t border-gray-200 pt-4 mt-2"></div>
            
            <!-- Profile Link -->
            <a href="{{ route('profile.dashboard', auth()->user()->id) }}" 
               class="flex items-center space-x-3 px-4 py-3 text-gray-700 hover:bg-gray-50 rounded-xl transition-all duration-300 group">
                <div class="w-10 h-10 bg-gray-100 group-hover:bg-primary/10 rounded-xl flex items-center justify-center transition-colors">
                    <i class="fas fa-user text-gray-500 group-hover:text-primary"></i>
                </div>
                <div class="flex-1">
                    <p class="font-medium text-gray-900">My Profile</p>
                    <p class="text-xs text-gray-500">Manage your account</p>
                </div>
            </a>
            
            <!-- Sign Out Form -->
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
    
    /* Smooth transitions */
    .transition-all {
        transition-property: all;
        transition-timing-function: cubic-bezier(0.4, 0, 0.2, 1);
        transition-duration: 300ms;
    }
</style>

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
                </div>
            </div>
            <button type="button" class="text-green-700 hover:text-green-900 transition" onclick="this.parentElement.remove()">
                <i class="fas fa-times"></i>
            </button>
        </div>
        @endif

        @if(session('error'))
        <div class="mb-6 bg-red-100 border-l-4 border-red-500 text-red-700 p-4 rounded-lg flex items-center justify-between shadow-md" role="alert">
            <div class="flex items-center space-x-3">
                <div class="w-8 h-8 bg-red-200 rounded-full flex items-center justify-center">
                    <i class="fas fa-exclamation-circle text-red-600 text-xl"></i>
                </div>
                <div>
                    <p class="font-medium">{{ session('error') }}</p>
                </div>
            </div>
            <button type="button" class="text-red-700 hover:text-red-900 transition" onclick="this.parentElement.remove()">
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

<!-- Stats Cards - Technician Focused -->
<div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6 mb-8">
    
    @php
        use App\Models\Ticket;
        
        $techId = auth()->id();
        $today = now()->startOfDay();
        $now = now();
        
        // Assigned to me - all tickets assigned to this tech
        $assignedQuery = Ticket::where('assigned_to', $techId);
        $assignedCount = $assignedQuery->count();
        
        // New assignments - tickets assigned in the last 24 hours
        $newAssignments = Ticket::where('assigned_to', $techId)
            ->where('created_at', '>=', now()->subDay())
            ->count();
        
        // In Progress tickets
        $inProgressCount = Ticket::where('assigned_to', $techId)
            ->whereIn('status', ['in_progress', 'open'])
            ->count();
        
        // Overdue tickets - high priority tickets not resolved within 24 hours
        $overdueCount = Ticket::where('assigned_to', $techId)
            ->whereIn('priority', ['high', 'medium'])
            ->whereNotIn('status', ['resolved', 'closed'])
            ->where('created_at', '<=', now()->subHours(24))
            ->count();
        
        // Resolved today
        $resolvedToday = Ticket::where('assigned_to', $techId)
            ->whereDate('resolved_at', $today)
            ->count();
        
        // Resolution rate - percentage of assigned tickets that are resolved
        $resolvedTotal = Ticket::where('assigned_to', $techId)
            ->whereIn('status', ['resolved', 'closed'])
            ->count();
        
        $resolutionRate = $assignedCount > 0 
            ? round(($resolvedTotal / $assignedCount) * 100) 
            : 0;
        
        // Average response time - time between creation and first assignment/response
        $avgResponseHours = Ticket::where('assigned_to', $techId)
            ->whereNotNull('created_at')
            ->whereNotNull('assigned_to')
            ->get()
            ->map(function($ticket) {
                return $ticket->created_at->diffInHours($ticket->updated_at);
            })
            ->avg();
        
        $avgResponse = $avgResponseHours 
            ? number_format($avgResponseHours, 1) . 'h' 
            : '0h';
        
        // Global average response time for comparison
        $globalAvgResponse = Ticket::whereNotNull('created_at')
            ->whereNotNull('assigned_to')
            ->get()
            ->map(function($ticket) {
                return $ticket->created_at->diffInHours($ticket->updated_at);
            })
            ->avg();
        
        $responseDiff = $globalAvgResponse && $avgResponseHours 
            ? round($globalAvgResponse - $avgResponseHours, 1) 
            : 0;
        
        $responseDiffText = $responseDiff > 0 
            ? $responseDiff . 'h faster than average' 
            : ($responseDiff < 0 ? abs($responseDiff) . 'h slower than average' : 'average');
        
        $responseDiffIcon = $responseDiff > 0 ? 'arrow-down' : ($responseDiff < 0 ? 'arrow-up' : 'minus');
        $responseDiffColor = $responseDiff > 0 ? 'text-green-600' : ($responseDiff < 0 ? 'text-red-600' : 'text-gray-600');
    @endphp
    
    <div class="bg-white rounded-xl shadow-md p-6 dashboard-card">
        <div class="flex items-center justify-between">
            <div>
                <p class="text-gray-500 text-sm font-medium">Assigned to Me</p>
                <p class="text-3xl font-bold text-gray-800 mt-2">{{ $assignedCount }}</p>
            </div>
            <div class="w-12 h-12 bg-blue-100 rounded-full flex items-center justify-center">
                <i class="fas fa-user-tag text-blue-600 text-xl"></i>
            </div>
        </div>
        <div class="mt-4">
            <span class="text-xs text-blue-600 font-medium">
                <i class="fas fa-clock mr-1"></i>
                {{ $newAssignments }} new {{ Str::plural('assignment', $newAssignments) }}
            </span>
        </div>
    </div>
    
    <div class="bg-white rounded-xl shadow-md p-6 dashboard-card">
        <div class="flex items-center justify-between">
            <div>
                <p class="text-gray-500 text-sm font-medium">In Progress</p>
                <p class="text-3xl font-bold text-gray-800 mt-2">{{ $inProgressCount }}</p>
            </div>
            <div class="w-12 h-12 bg-orange-100 rounded-full flex items-center justify-center">
                <i class="fas fa-spinner text-orange-600 text-xl"></i>
            </div>
        </div>
        <div class="mt-4">
            <span class="text-xs text-orange-600 font-medium">
                <i class="fas fa-hourglass-half mr-1"></i>
                {{ $overdueCount }} {{ Str::plural('ticket', $overdueCount) }} overdue
            </span>
        </div>
    </div>
    
    <div class="bg-white rounded-xl shadow-md p-6 dashboard-card">
        <div class="flex items-center justify-between">
            <div>
                <p class="text-gray-500 text-sm font-medium">Resolved Today</p>
                <p class="text-3xl font-bold text-gray-800 mt-2">{{ $resolvedToday }}</p>
            </div>
            <div class="w-12 h-12 bg-green-100 rounded-full flex items-center justify-center">
                <i class="fas fa-check-double text-green-600 text-xl"></i>
            </div>
        </div>
        <div class="mt-4">
            <span class="text-xs text-green-600 font-medium">
                <i class="fas fa-trophy mr-1"></i>
                {{ $resolutionRate }}% resolution rate
            </span>
        </div>
    </div>
    
    <div class="bg-white rounded-xl shadow-md p-6 dashboard-card">
        <div class="flex items-center justify-between">
            <div>
                <p class="text-gray-500 text-sm font-medium">Avg. Response</p>
                <p class="text-3xl font-bold text-gray-800 mt-2">{{ $avgResponse }}</p>
            </div>
            <div class="w-12 h-12 bg-purple-100 rounded-full flex items-center justify-center">
                <i class="fas fa-gauge-high text-purple-600 text-xl"></i>
            </div>
        </div>
        <div class="mt-4">
            <span class="text-xs {{ $responseDiffColor }} font-medium">
                <i class="fas fa-{{ $responseDiffIcon }} mr-1"></i>
                {{ $responseDiffText }}
            </span>
        </div>
    </div>
</div>

<!-- Additional Stats Row - Priority Breakdown -->
<div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-8">
    @php
        $highPriorityCount = Ticket::where('assigned_to', $techId)
            ->where('priority', 'high')
            ->whereNotIn('status', ['resolved', 'closed'])
            ->count();
        
        $mediumPriorityCount = Ticket::where('assigned_to', $techId)
            ->where('priority', 'medium')
            ->whereNotIn('status', ['resolved', 'closed'])
            ->count();
        
        $lowPriorityCount = Ticket::where('assigned_to', $techId)
            ->where('priority', 'low')  
            ->whereNotIn('status', ['resolved', 'closed'])
            ->count();
    @endphp
</div>

        <!-- Recent Tickets & Quick Actions - FIXED GRID LAYOUT -->
        <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
<div class="lg:col-span-2">
    <div class="bg-white rounded-xl shadow-md overflow-hidden">
        <div class="px-6 py-4 border-b border-gray-200">
            <div class="flex items-center justify-between">
                <h2 class="text-lg font-semibold text-gray-800 flex items-center">
                    <i class="fas fa-clock text-primary mr-2"></i>
                    Your Recent Support Requests
                </h2>
                <a href="{{ route('tickets.index') }}" class="text-primary hover:text-primaryDark text-sm font-medium flex items-center">
                    View All Tickets <i class="fas fa-arrow-right ml-2"></i>
                </a>
            </div>
        </div>

        <div class="divide-y divide-gray-100 max-h-[500px] overflow-y-auto custom-scrollbar">
            @forelse($recentTickets ?? [] as $ticket)
                <div class="relative p-6 hover:bg-gray-50 transition cursor-pointer group" 
                    onclick="window.location.href='{{ route('tickets.my_tickets_view', $ticket->id) }}'">

                    <div class="absolute left-0 top-0 h-full w-1 rounded-l-lg opacity-0 group-hover:opacity-100 transition-opacity duration-200
                        @if($ticket->priority === 'high') bg-red-500
                        @elseif($ticket->priority === 'medium') bg-yellow-500
                        @elseif($ticket->priority === 'low') bg-green-500
                        @endif">
                    </div>

                    <div class="flex items-start justify-between pl-2">
                        <div class="flex-1">

                            <!-- UPDATED BADGE ROW -->
                            <div class="flex items-start justify-between mb-2">

                                <!-- LEFT: Priority + Status -->
                                <div class="flex items-center space-x-2">

                                    <!-- Priority Badge -->
                                    @if($ticket->priority === 'high')
                                        <span class="inline-flex items-center px-3 py-1.5 rounded-full text-xs font-medium bg-red-100 text-red-800">
                                            <span class="w-2 h-2 rounded-full bg-red-500 mr-1.5 animate-pulse"></span>
                                            High Priority
                                        </span>
                                    @elseif($ticket->priority === 'medium')
                                        <span class="inline-flex items-center px-3 py-1.5 rounded-full text-xs font-medium bg-yellow-100 text-yellow-800">
                                            <span class="w-2 h-2 rounded-full bg-yellow-500 mr-1.5"></span>
                                            Medium Priority
                                        </span>
                                    @elseif($ticket->priority === 'low')
                                        <span class="inline-flex items-center px-3 py-1.5 rounded-full text-xs font-medium bg-green-100 text-green-800">
                                            <span class="w-2 h-2 rounded-full bg-green-500 mr-1.5"></span>
                                            Low Priority
                                        </span>
                                    @endif

                                    <!-- Status Badge -->
                                    <span class="inline-flex items-center px-3 py-1.5 rounded-full text-xs font-medium
                                        @if($ticket->status === 'in_progress') bg-blue-100 text-blue-800
                                        @elseif($ticket->status === 'open') bg-green-100 text-green-800
                                        @elseif($ticket->status === 'pending') bg-yellow-100 text-yellow-800
                                        @elseif($ticket->status === 'resolved') bg-purple-100 text-purple-800
                                        @elseif($ticket->status === 'closed') bg-red-100 text-red-800
                                        @endif">

                                        @if($ticket->status === 'in_progress')
                                            <span class="w-2 h-2 rounded-full bg-blue-500 mr-1.5 animate-spin"></span>
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

                                </div>

                                <!-- RIGHT: Ticket Number -->
                                <span class="text-xs text-gray-500 font-mono bg-gray-100 px-3 py-1 rounded-md whitespace-nowrap">
                                    {{ $ticket->ticket_number }}
                                </span>

                            </div>
                            <!-- END UPDATED BADGE ROW -->

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

                            <div class="mt-3">
                                <span class="text-xs text-primary font-medium">
                                    @if($ticket->status === 'pending')
                                        <i class="fas fa-hourglass-start mr-1"></i> Awaiting assignment
                                    @elseif($ticket->status === 'open')
                                        <i class="fas fa-exclamation-circle mr-1"></i> Just opened
                                    @elseif($ticket->status === 'in_progress')
                                        <i class="fas fa-cogs mr-1"></i> In progress
                                    @elseif($ticket->status === 'resolved')
                                        <i class="fas fa-check-circle mr-1"></i> Ready for review
                                    @elseif($ticket->status === 'closed')
                                        <i class="fas fa-check-double mr-1"></i> Closed 
                                        {{ $ticket->resolved_at ? $ticket->resolved_at->diffForHumans() : '' }}
                                    @endif
                                </span>
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
                        <p class="text-gray-500 text-sm mb-4">Create your first support ticket to get help</p>
                        <a href="{{ route('tickets.create') }}" 
                           class="inline-flex items-center space-x-2 bg-primary hover:bg-primaryDark text-white px-6 py-3 rounded-lg font-medium transition shadow-md">
                            <i class="fas fa-plus-circle"></i>
                            <span>Create New Ticket</span>
                        </a>
                    </div>
                </div>
            @endforelse
        </div>

        <div class="px-6 py-3 bg-gray-50 border-t border-gray-200 text-center">
            <a href="{{ route('tickets.index') }}" class="text-primary hover:text-primaryDark text-sm font-medium inline-flex items-center">
                View All Tickets <i class="fas fa-arrow-right ml-2"></i>
            </a>
        </div>
    </div>
</div>
            
            <!-- Technician Quick Actions & Tools - Right Column (1/3) -->
            <div class="space-y-6">
                <!-- Quick Actions -->
                <div class="bg-white rounded-xl shadow-md p-6">
                    <h3 class="text-lg font-semibold text-gray-800 mb-4 flex items-center">
                        <i class="fas fa-bolt text-primary mr-2"></i>
                        Tech Tools
                    </h3>
                    <div class="space-y-3">
                        <a href="/tickets/create" class="flex items-center space-x-3 p-3 bg-primary/5 hover:bg-primary/10 rounded-lg transition group">
                            <div class="w-10 h-10 bg-primary rounded-lg flex items-center justify-center">
                                <i class="fas fa-plus text-white"></i>
                            </div>
                            <div>
                                <p class="font-medium text-gray-900">Create New Ticket</p>
                                <p class="text-sm text-gray-500">Log a new support request</p>
                            </div>
                        </a>
                        
                        <a href="/tickets" class="flex items-center space-x-3 p-3 bg-support/5 hover:bg-support/10 rounded-lg transition group">
                            <div class="w-10 h-10 bg-support rounded-lg flex items-center justify-center">
                                <i class="fas fa-ticket-alt text-white"></i>
                            </div>
                            <div>
                                <p class="font-medium text-gray-900">My Queue</p>
                                <p class="text-sm text-gray-500">{{ $ticketStats['assigned'] ?? 8 }} tickets assigned</p>
                            </div>
                        </a>
                        
                        <a href="{{ route('profile.dashboard') }}" class="flex items-center space-x-3 p-3 bg-gray-100 hover:bg-gray-200 rounded-lg transition group">
                            <div class="w-10 h-10 bg-gray-300 rounded-lg flex items-center justify-center">
                                <i class="fas fa-user-cog text-gray-700"></i>
                            </div>
                            <div>
                                <p class="font-medium text-gray-900">Tech Profile</p>
                                <p class="text-sm text-gray-500">Update availability & skills</p>
                            </div>
                        </a>
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
                <p class="mt-2 text-xs">
                    <i class="fas fa-tools mr-1"></i>
                    Technical Portal v1.0
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
                
                // Close mobile menu when clicking outside
                document.addEventListener('click', function(event) {
                    if (mobileMenu && !mobileMenu.contains(event.target) && 
                        mobileMenuButton && !mobileMenuButton.contains(event.target)) {
                        mobileMenu.classList.add('hidden');
                    }
                });
            }
            
            // User dropdown hover - Using CSS group-hover, no JS needed
            
            // Ticket click - Fix to work with onclick attribute
            document.querySelectorAll('.group[onclick]').forEach(ticket => {
                ticket.addEventListener('click', function(e) {
                    if (!e.target.closest('a') && !e.target.closest('button')) {
                        const onclickAttr = this.getAttribute('onclick');
                        const match = onclickAttr.match(/'(.*?)'/);
                        if (match && match[1]) {
                            window.location.href = match[1];
                        }
                    }
                });
            });
        });
    </script>
</body>
</html>