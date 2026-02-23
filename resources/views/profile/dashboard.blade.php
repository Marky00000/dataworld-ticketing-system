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
    </style>
</head>
<body class="bg-gray-50 min-h-screen">
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
                    <a href="/dashboard" class="{{ request()->is('dashboard') ? 'text-primary font-medium' : 'text-gray-700 hover:text-primary' }} transition flex items-center space-x-2">
                        <i class="fas fa-home"></i>
                        <span>Dashboard</span>
                    </a>
                    
                    <a href="/tickets" class="{{ request()->is('tickets*') ? 'text-primary font-medium' : 'text-gray-700 hover:text-primary' }} transition flex items-center space-x-2">
                        <i class="fas fa-ticket-alt"></i>
                        <span>My Tickets</span>
                    </a>
                    
                    <a href="/tickets/create" class="{{ request()->is('tickets/create') ? 'text-primary font-medium' : 'text-gray-700 hover:text-primary' }} transition flex items-center space-x-2">
                        <i class="fas fa-plus-circle"></i>
                        <span>New Ticket</span>
                    </a>
                                    
                    
                    <!-- User Dropdown -->
                    <div class="relative group">
                        <button class="flex items-center space-x-3 focus:outline-none">
                            <div class="flex items-center space-x-3">
                                <div class="w-10 h-10 bg-gradient-to-r from-primary to-support rounded-full flex items-center justify-center text-white font-semibold shadow-md group-hover:shadow-lg transition-all">
                                    {{ substr($user->name, 0, 1) }}
                                </div>
                                <div class="text-left hidden lg:block">
                                    <p class="text-sm font-medium text-gray-900">{{ $user->name }}</p>
                                </div>
                            </div>
                            <i class="fas fa-chevron-down text-gray-400 text-sm group-hover:text-primary transition"></i>
                        </button>
                        
                        <!-- Dropdown Menu -->
                        <div class="absolute right-0 mt-2 w-56 bg-white rounded-xl shadow-lg py-2 z-50 opacity-0 invisible group-hover:opacity-100 group-hover:visible transition-all duration-200 border border-gray-100">
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
                            
                            <a href="{{ route('profile.dashboard') }}" class="flex items-center space-x-2 px-4 py-2 text-sm text-gray-700 hover:bg-primary/5 transition">
                                <i class="fas fa-user text-gray-400 w-5"></i>
                                <span>My Profile</span>
                                @if(request()->routeIs('profile.dashboard'))
                                    <span class="ml-auto text-xs text-primary">●</span>
                                @endif
                            </a>

                            @if($user->user_type === 'admin')
                                <a href="{{ route('admin.tech.create') }}" class="flex items-center space-x-2 px-4 py-2 text-sm text-blue-600 hover:bg-blue-50 transition border-t border-gray-100 mt-1 pt-3">
                                    <i class="fas fa-user-plus text-blue-500 w-5"></i>
                                    <span class="font-medium">Create Tech Account</span>
                                </a>
                            @endif
                            
                            <div class="border-t border-gray-100 my-1"></div>
                            
                            <form method="POST" action="{{ route('sign-out') }}" class="w-full">
                                @csrf
                                <button type="submit" class="flex items-center space-x-2 px-4 py-2 text-sm text-red-600 hover:bg-red-50 transition w-full text-left">
                                    <i class="fas fa-sign-out-alt w-5"></i>
                                    <span>Sign Out</span>
                                </button>
                            </form>
                        </div>
                    </div>
                </div>
                
                <!-- Mobile menu button -->
                <div class="md:hidden flex items-center">
                    <button id="mobileMenuButton" class="text-gray-500 hover:text-gray-700 focus:outline-none p-2 hover:bg-gray-100 rounded-lg transition">
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
                        {{ substr($user->name, 0, 1) }}
                    </div>
                    <div>
                        <p class="text-sm font-medium text-gray-900">{{ $user->name }}</p>
                        <p class="text-xs text-gray-500 capitalize">{{ $user->user_type }} Account</p>
                    </div>
                </div>
                
                <a href="/dashboard" class="flex items-center space-x-2 px-2 py-3 {{ request()->is('dashboard') ? 'text-primary bg-primary/5' : 'text-gray-700 hover:bg-gray-50' }} rounded-lg transition">
                    <span>Dashboard</span>
                </a>
                
                <a href="/tickets" class="flex items-center space-x-2 px-2 py-3 {{ request()->is('tickets*') && !request()->is('tickets/create') ? 'text-primary bg-primary/5' : 'text-gray-700 hover:bg-gray-50' }} rounded-lg transition">
                    <span>My Tickets</span>
                </a>
                
                <a href="/tickets/create" class="flex items-center space-x-2 px-2 py-3 {{ request()->is('tickets/create') ? 'text-primary bg-primary/5' : 'text-gray-700 hover:bg-gray-50' }} rounded-lg transition">
                    <span>New Ticket</span>
                </a>
                
                @if($user->user_type === 'admin')
                    <div class="border-t border-gray-100 pt-3 mt-3">
                        <a href="{{ route('admin.tech.create') }}" class="flex items-center space-x-2 px-2 py-3 text-blue-600 hover:bg-blue-50 rounded-lg transition">
                            <i class="fas fa-user-plus w-5"></i>
                            <span class="font-medium">Create Tech Account</span>
                            <span class="ml-auto text-xs bg-blue-100 text-blue-800 px-2 py-0.5 rounded-full">Admin</span>
                        </a>
                    </div>
                @endif
                
                <div class="border-t border-gray-100 pt-3">
                    <a href="{{ route('profile.dashboard') }}" class="flex items-center space-x-2 px-2 py-3 {{ request()->routeIs('profile.dashboard') ? 'text-primary bg-primary/5' : 'text-gray-700 hover:bg-gray-50' }} rounded-lg transition">
                        <i class="fas fa-user w-5"></i>
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
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">

        <!-- Welcome Banner - Static gradient (no animation) -->
        <div class="bg-gradient-to-r from-primary to-primaryDark rounded-2xl p-8 text-white mb-8 shadow-lg">
            <div class="flex flex-col md:flex-row md:items-center justify-between">
                <div>
                    <h1 class="text-3xl md:text-4xl font-bold mb-3">Welcome back, {{ explode(' ', $user->name)[0] }}! 👋</h1>
                    <p class="text-white/90 text-lg">
                        @if($user->user_type === 'admin')
                            Managing the support system for {{ $totalUsers ?? 0 }} users.
                        @elseif($user->user_type === 'tech')
                            You have {{ $activeTickets ?? 0 }} active tickets assigned to you.
                        @else
                            Track your support tickets and manage your account settings.
                        @endif
                    </p>
                </div>
            </div>
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
                    <div class="bg-gradient-to-r from-primary to-primaryDark h-32"></div>
                    <div class="px-6 pb-6 relative -top-16">
                        <div class="flex justify-center mb-4">
                            <div class="w-24 h-24 bg-gradient-to-r from-primary to-support rounded-full flex items-center justify-center text-white text-3xl font-bold avatar-ring shadow-xl">
                                {{ strtoupper(substr($user->name, 0, 1)) }}
                            </div>
                        </div>
                        
                        <div class="text-center -mt-4 mb-6">
                            <h2 class="text-2xl font-bold text-gray-900">{{ $user->name }}</h2>
                            <p class="text-gray-600 mb-3">{{ $user->email }}</p>
                            <div class="flex justify-center space-x-2">
                                <span class="inline-flex items-center px-3 py-1 bg-primary/10 text-primary rounded-full text-sm font-medium">
                                    <i class="fas fa-user-tag mr-1"></i>
                                    {{ ucfirst($user->user_type) }}
                                </span>
                                @if($user->email_verified_at)
                                    <span class="inline-flex items-center px-3 py-1 bg-green-100 text-green-700 rounded-full text-sm font-medium">
                                        <i class="fas fa-check-circle mr-1"></i>
                                        Verified
                                    </span>
                                @endif
                            </div>
                        </div>
                        
                        <div class="space-y-3">
                            <div class="flex items-center justify-between p-4 bg-gray-50 rounded-xl hover:bg-gray-100 transition">
                                <div class="flex items-center space-x-3">
                                    <div class="w-10 h-10 bg-blue-100 rounded-xl flex items-center justify-center">
                                        <i class="fas fa-calendar-alt text-blue-600"></i>
                                    </div>
                                    <div>
                                        <p class="text-xs text-gray-500">Member Since</p>
                                        <p class="font-medium text-gray-900">{{ $user->created_at->format('M d, Y') }}</p>
                                    </div>
                                </div>
                                <span class="text-xs text-gray-400">{{ $user->created_at->diffForHumans() }}</span>
                            </div>
                            
                            @if($user->phone)
                            <div class="flex items-center justify-between p-4 bg-gray-50 rounded-xl hover:bg-gray-100 transition">
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
                            <div class="flex items-center justify-between p-4 bg-gray-50 rounded-xl hover:bg-gray-100 transition">
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
                            
                            <div class="flex items-center justify-between p-4 bg-gray-50 rounded-xl hover:bg-gray-100 transition">
                                <div class="flex items-center space-x-3">
                                    <div class="w-10 h-10 bg-indigo-100 rounded-xl flex items-center justify-center">
                                        <i class="fas fa-star text-indigo-600"></i>
                                    </div>
                                    <div>
                                        <p class="text-xs text-gray-500">Satisfaction</p>
                                        <p class="font-medium text-gray-900">{{ $satisfactionScore ?? '4.8/5.0' }}</p>
                                    </div>
                                </div>
                            </div>
                        </div>
                        
                        <div class="mt-6 grid grid-cols-2 gap-3">
                            <button onclick="window.location.href='/tickets/create'" class="bg-gray-100 hover:bg-gray-200 text-gray-700 px-4 py-3 rounded-xl font-medium flex items-center justify-center space-x-2 transition-all">
                                <i class="fas fa-plus-circle"></i>
                                <span>New</span>
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
                            <span class="text-xs bg-gray-100 text-gray-600 px-3 py-1 rounded-full">
                                Last 30 days
                            </span>
                        </div>
                    </div>
                    <div class="divide-y divide-gray-200 max-h-[400px] overflow-y-auto custom-scrollbar">
                        @forelse($recentActivities ?? [] as $activity)
                            <div class="px-6 py-4 activity-item hover:bg-gray-50 transition">
                                <div class="flex items-start space-x-4">
                                    <div class="w-10 h-10 bg-{{ $activity->type === 'ticket' ? 'blue' : ($activity->type === 'comment' ? 'yellow' : 'green') }}-100 rounded-xl flex items-center justify-center flex-shrink-0">
                                        <i class="fas fa-{{ $activity->type === 'ticket' ? 'ticket-alt' : ($activity->type === 'comment' ? 'comment' : 'check-circle') }} text-{{ $activity->type === 'ticket' ? 'blue' : ($activity->type === 'comment' ? 'yellow' : 'green') }}-600"></i>
                                    </div>
                                    <div class="flex-1 min-w-0">
                                        <div class="flex items-start justify-between">
                                            <div>
                                                <p class="font-medium text-gray-900">{{ $activity->description }}</p>
                                                <p class="text-sm text-gray-600 mt-0.5">{{ $activity->details }}</p>
                                            </div>
                                            <span class="text-xs text-gray-500 whitespace-nowrap ml-4">{{ $activity->created_at->diffForHumans() }}</span>
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
                
                <!-- Quick Stats & Insights -->
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div class="bg-white rounded-2xl shadow-sm p-6 card-hover">
                        <h3 class="font-semibold text-gray-900 mb-4 flex items-center">
                            <i class="fas fa-chart-pie text-primary mr-2"></i>
                            Ticket Statistics
                        </h3>
                        <div class="space-y-4">
                            <div>
                                <div class="flex justify-between text-sm mb-1">
                                    <span class="text-gray-600">Open</span>
                                    <span class="font-medium text-gray-900">{{ $openPercentage ?? 0 }}%</span>
                                </div>
                                <div class="w-full bg-gray-200 rounded-full h-2">
                                    <div class="bg-blue-600 h-2 rounded-full" style="width: {{ $openPercentage ?? 0 }}%"></div>
                                </div>
                            </div>
                            <div>
                                <div class="flex justify-between text-sm mb-1">
                                    <span class="text-gray-600">In Progress</span>
                                    <span class="font-medium text-gray-900">{{ $inProgressPercentage ?? 0 }}%</span>
                                </div>
                                <div class="w-full bg-gray-200 rounded-full h-2">
                                    <div class="bg-yellow-600 h-2 rounded-full" style="width: {{ $inProgressPercentage ?? 0 }}%"></div>
                                </div>
                            </div>
                            <div>
                                <div class="flex justify-between text-sm mb-1">
                                    <span class="text-gray-600">Resolved</span>
                                    <span class="font-medium text-gray-900">{{ $resolvedPercentage ?? 0 }}%</span>
                                </div>
                                <div class="w-full bg-gray-200 rounded-full h-2">
                                    <div class="bg-green-600 h-2 rounded-full" style="width: {{ $resolvedPercentage ?? 0 }}%"></div>
                                </div>
                            </div>
                        </div>
                    </div>
                    
                    <div class="bg-white rounded-2xl shadow-sm p-6 card-hover">
                        <h3 class="font-semibold text-gray-900 mb-4 flex items-center">
                            <i class="fas fa-tachometer-alt text-primary mr-2"></i>
                            Performance Metrics
                        </h3>
                        <div class="space-y-4">
                            <div class="flex items-center justify-between p-3 bg-gray-50 rounded-xl">
                                <div class="flex items-center space-x-3">
                                    <div class="w-10 h-10 bg-green-100 rounded-lg flex items-center justify-center">
                                        <i class="fas fa-clock text-green-600"></i>
                                    </div>
                                    <div>
                                        <p class="text-xs text-gray-500">Avg Response Time</p>
                                        <p class="font-semibold text-gray-900">{{ $avgResponseTime ?? '0h' }}</p>
                                    </div>
                                </div>
                                <span class="text-xs {{ ($responseTrend ?? 0) > 0 ? 'text-green-600' : 'text-red-600' }}">
                                    <i class="fas fa-arrow-{{ ($responseTrend ?? 0) > 0 ? 'up' : 'down' }} mr-1"></i>
                                    {{ abs($responseTrend ?? 0) }}%
                                </span>
                            </div>
                            
                            <div class="flex items-center justify-between p-3 bg-gray-50 rounded-xl">
                                <div class="flex items-center space-x-3">
                                    <div class="w-10 h-10 bg-blue-100 rounded-lg flex items-center justify-center">
                                        <i class="fas fa-check-circle text-blue-600"></i>
                                    </div>
                                    <div>
                                        <p class="text-xs text-gray-500">Resolution Rate</p>
                                        <p class="font-semibold text-gray-900">{{ $resolutionRate ?? 0 }}%</p>
                                    </div>
                                </div>
                                <span class="text-xs text-green-600">
                                    <i class="fas fa-arrow-up mr-1"></i>
                                    {{ $resolutionTrend ?? 0 }}%
                                </span>
                            </div>
                        </div>
                    </div>
                </div>
                
                <!-- Account Settings -->
                <div class="bg-white rounded-2xl shadow-sm overflow-hidden card-hover">
                    <div class="px-6 py-5 border-b border-gray-200">
                        <div class="flex items-center justify-between">
                            <h3 class="text-lg font-semibold text-gray-900 flex items-center">
                                <i class="fas fa-cog text-primary mr-2"></i>
                                Account Settings
                            </h3>
                            <span class="text-xs bg-gray-100 text-gray-600 px-3 py-1 rounded-full">
                                4 options
                            </span>
                        </div>
                    </div>
                    <div class="divide-y divide-gray-200">
                        <div class="px-6 py-4 setting-item hover:bg-gray-50 transition">
                            <div class="flex items-center justify-between">
                                <div class="flex items-center space-x-4">
                                    <div class="w-12 h-12 bg-blue-100 rounded-xl flex items-center justify-center">
                                        <i class="fas fa-shield-alt text-blue-600 text-xl"></i>
                                    </div>
                                    <div>
                                        <p class="font-medium text-gray-900">Account Security</p>
                                        <p class="text-sm text-gray-500">Change password, enable 2FA, security logs</p>
                                    </div>
                                </div>
                                <i class="fas fa-chevron-right text-gray-400 text-sm"></i>
                            </div>
                        </div>
                        
                        <div class="px-6 py-4 setting-item hover:bg-gray-50 transition">
                            <div class="flex items-center justify-between">
                                <div class="flex items-center space-x-4">
                                    <div class="w-12 h-12 bg-green-100 rounded-xl flex items-center justify-center">
                                        <i class="fas fa-bell text-green-600 text-xl"></i>
                                    </div>
                                    <div>
                                        <p class="font-medium text-gray-900">Notifications</p>
                                        <p class="text-sm text-gray-500">Email, push notifications, ticket alerts</p>
                                    </div>
                                </div>
                                <i class="fas fa-chevron-right text-gray-400 text-sm"></i>
                            </div>
                        </div>
                        
                        <div class="px-6 py-4 setting-item hover:bg-gray-50 transition">
                            <div class="flex items-center justify-between">
                                <div class="flex items-center space-x-4">
                                    <div class="w-12 h-12 bg-purple-100 rounded-xl flex items-center justify-center">
                                        <i class="fas fa-envelope text-purple-600 text-xl"></i>
                                    </div>
                                    <div>
                                        <p class="font-medium text-gray-900">Email Preferences</p>
                                        <p class="text-sm text-gray-500">Ticket updates, newsletters, marketing</p>
                                    </div>
                                </div>
                                <i class="fas fa-chevron-right text-gray-400 text-sm"></i>
                            </div>
                        </div>
                        
                        <div class="px-6 py-4 setting-item hover:bg-gray-50 transition">
                            <div class="flex items-center justify-between">
                                <div class="flex items-center space-x-4">
                                    <div class="w-12 h-12 bg-yellow-100 rounded-xl flex items-center justify-center">
                                        <i class="fas fa-globe text-yellow-600 text-xl"></i>
                                    </div>
                                    <div>
                                        <p class="font-medium text-gray-900">Language & Region</p>
                                        <p class="text-sm text-gray-500">Timezone, language, date format</p>
                                    </div>
                                </div>
                                <i class="fas fa-chevron-right text-gray-400 text-sm"></i>
                            </div>
                        </div>
                    </div>
                    <div class="px-6 py-4 bg-gray-50 border-t border-gray-200">
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Footer -->
    <footer class="bg-gray-800 text-gray-400 py-8 mt-12">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex flex-col md:flex-row justify-between items-center">
                <div class="mb-6 md:mb-0">
                    <div class="flex items-center space-x-3 mb-4">
                        <img src="{{ asset('images/dwcc.png') }}" alt="Dataworld Logo" class="h-8 w-auto">
                        <span class="text-white font-semibold text-lg">Dataworld Support</span>
                    </div>
                    <p class="text-sm">© {{ date('Y') }} Dataworld Computer Center. All rights reserved.</p>
                </div>
                <div class="flex space-x-8">
                    <a href="/privacy" class="text-sm hover:text-white transition flex items-center">
                        <i class="fas fa-shield-alt mr-1"></i>
                        Privacy
                    </a>
                    <a href="/terms" class="text-sm hover:text-white transition flex items-center">
                        <i class="fas fa-file-contract mr-1"></i>
                        Terms
                    </a>
                    <a href="/contact" class="text-sm hover:text-white transition flex items-center">
                        <i class="fas fa-envelope mr-1"></i>
                        Contact
                    </a>
                </div>
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
                item.addEventListener('click', function() {
                    const settingText = this.querySelector('.font-medium').textContent;
                    if (settingText.includes('Security')) {
                        window.location.href = '/settings/security';
                    } else if (settingText.includes('Notifications')) {
                        window.location.href = '/settings/notifications';
                    } else if (settingText.includes('Email')) {
                        window.location.href = '/settings/email';
                    } else if (settingText.includes('Language')) {
                        window.location.href = '/settings/language';
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
            
            // Add loading state to buttons
            const buttons = document.querySelectorAll('button[type="submit"]');
            buttons.forEach(button => {
                button.addEventListener('click', function() {
                    if (this.form) {
                        const originalText = this.innerHTML;
                        this.disabled = true;
                        this.innerHTML = '<i class="fas fa-spinner fa-spin mr-2"></i>Loading...';
                        
                        // Re-enable after form submission (if needed)
                        setTimeout(() => {
                            this.disabled = false;
                            this.innerHTML = originalText;
                        }, 5000);
                    }
                });
            });
        });
    </script>
</body>
</html>