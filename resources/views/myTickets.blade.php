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
                    
                    
                    <!-- Notification Bell -->
                    <div class="relative">
                        <button class="text-gray-600 hover:text-primary transition relative">
                            <i class="fas fa-bell text-xl"></i>
                            <span class="absolute -top-1 -right-1 w-4 h-4 bg-red-500 text-white text-xs rounded-full flex items-center justify-center">
                                3
                            </span>
                        </button>
                    </div>
                    
                    <!-- User Dropdown -->
                    <div class="relative group">
                        <button class="flex items-center space-x-3 focus:outline-none">
                            <div class="flex items-center space-x-3">
                                <div class="w-10 h-10 bg-gradient-to-r from-primary to-support rounded-full flex items-center justify-center text-white font-semibold">
                                    {{ substr(auth()->user()->name, 0, 1) }}
                                </div>
                                <div class="text-left hidden lg:block">
                                    <p class="text-sm font-medium text-gray-900">{{ auth()->user()->name }}</p>
                                    <p class="text-xs text-gray-500">Client Account</p>
                                </div>
                            </div>
                            <i class="fas fa-chevron-down text-gray-400 text-sm"></i>
                        </button>
                        
                        <!-- Dropdown Menu -->
                        <div class="absolute right-0 mt-2 w-48 bg-white rounded-lg shadow-lg py-2 z-50 opacity-0 invisible group-hover:opacity-100 group-hover:visible transition-all duration-200">
                            <div class="px-4 py-3 border-b border-gray-100">
                                <p class="text-sm font-medium text-gray-900">{{ auth()->user()->name }}</p>
                                <p class="text-xs text-gray-500 truncate">{{ auth()->user()->email }}</p>
                                <p class="text-xs text-primary font-medium mt-1">Client Account</p>
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
                
                <a href="/knowledge-base" class="flex items-center space-x-2 px-2 py-3 text-gray-700 hover:bg-gray-50 rounded-lg transition">
                    <i class="fas fa-book text-gray-400"></i>
                    <span>Knowledge Base</span>
                </a>
                
                <div class="flex items-center space-x-2 px-2 py-3">
                    <i class="fas fa-bell text-gray-400"></i>
                    <span>Notifications</span>
                    <span class="ml-auto w-6 h-6 bg-red-500 text-white text-xs rounded-full flex items-center justify-center">
                        3
                    </span>
                </div>
                
                <div class="border-t border-gray-100 pt-3">
                    <a href="/profile" class="flex items-center space-x-2 px-2 py-3 text-gray-700 hover:bg-gray-50 rounded-lg transition">
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

    <!-- Main Content -->
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
        <!-- Header -->
        <div class="flex justify-between items-center mb-8">
            <div>
                <h1 class="text-2xl md:text-3xl font-bold text-gray-900">My Support Tickets</h1>
                <p class="text-gray-600 mt-2">Track and manage all your support requests</p>
            </div>
            <a href="/tickets/create" class="bg-primary hover:bg-blue-700 text-white px-6 py-3 rounded-lg font-medium flex items-center space-x-2">
                <i class="fas fa-plus"></i>
                <span>Create New Ticket</span>
            </a>
        </div>

        <!-- Filters -->
        <div class="bg-white rounded-xl p-4 mb-6 shadow-sm">
            <div class="flex flex-wrap gap-4 items-center">
                <div class="flex space-x-2">
                    <button class="px-4 py-2 bg-primary text-white rounded-lg">All</button>
                    <button class="px-4 py-2 bg-gray-100 hover:bg-gray-200 rounded-lg">Open</button>
                    <button class="px-4 py-2 bg-gray-100 hover:bg-gray-200 rounded-lg">In Progress</button>
                    <button class="px-4 py-2 bg-gray-100 hover:bg-gray-200 rounded-lg">Resolved</button>
                </div>
                
                <div class="ml-auto flex items-center space-x-4">
                    <div class="relative">
                        <input type="text" placeholder="Search tickets..." class="pl-10 pr-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-primary">
                        <i class="fas fa-search absolute left-3 top-3 text-gray-400"></i>
                    </div>
                    <select class="border border-gray-300 rounded-lg px-4 py-2 focus:outline-none focus:ring-2 focus:ring-primary">
                        <option>Sort by: Newest</option>
                        <option>Sort by: Oldest</option>
                        <option>Sort by: Priority</option>
                    </select>
                </div>
            </div>
        </div>

        <!-- Stats Cards -->
        <div class="grid grid-cols-1 md:grid-cols-4 gap-6 mb-8">
            <div class="bg-white rounded-xl p-6 shadow-sm card-hover">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-gray-500 text-sm">Total Tickets</p>
                        <p class="text-2xl font-bold text-gray-900 mt-2">16</p>
                    </div>
                    <div class="w-12 h-12 bg-blue-100 rounded-full flex items-center justify-center">
                        <i class="fas fa-ticket-alt text-blue-600 text-xl"></i>
                    </div>
                </div>
            </div>
            
            <div class="bg-white rounded-xl p-6 shadow-sm card-hover">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-gray-500 text-sm">Active</p>
                        <p class="text-2xl font-bold text-gray-900 mt-2">3</p>
                    </div>
                    <div class="w-12 h-12 bg-yellow-100 rounded-full flex items-center justify-center">
                        <i class="fas fa-clock text-yellow-600 text-xl"></i>
                    </div>
                </div>
            </div>
            
            <div class="bg-white rounded-xl p-6 shadow-sm card-hover">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-gray-500 text-sm">Resolved</p>
                        <p class="text-2xl font-bold text-gray-900 mt-2">12</p>
                    </div>
                    <div class="w-12 h-12 bg-green-100 rounded-full flex items-center justify-center">
                        <i class="fas fa-check-circle text-green-600 text-xl"></i>
                    </div>
                </div>
            </div>
            
            <div class="bg-white rounded-xl p-6 shadow-sm card-hover">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-gray-500 text-sm">Avg. Resolution</p>
                        <p class="text-2xl font-bold text-gray-900 mt-2">8.2h</p>
                    </div>
                    <div class="w-12 h-12 bg-purple-100 rounded-full flex items-center justify-center">
                        <i class="fas fa-bolt text-purple-600 text-xl"></i>
                    </div>
                </div>
            </div>
        </div>

        <!-- Tickets Table -->
        <div class="bg-white rounded-xl shadow-sm overflow-hidden">
            <div class="overflow-x-auto">
                <table class="w-full">
                    <thead class="bg-gray-50">
                        <tr>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Ticket ID</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Subject</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Status</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Priority</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Created</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Last Update</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Actions</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-200">
                        <!-- Ticket 1 -->
                        <tr class="hover:bg-gray-50">
                            <td class="px-6 py-4">
                                <span class="font-medium text-blue-600">#DW-2024-1001</span>
                            </td>
                            <td class="px-6 py-4">
                                <div>
                                    <p class="font-medium text-gray-900">Server Connection Issue</p>
                                    <p class="text-sm text-gray-500">Unable to connect to database server</p>
                                </div>
                            </td>
                            <td class="px-6 py-4">
                                <span class="status-badge status-open">Open</span>
                            </td>
                            <td class="px-6 py-4">
                                <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-red-100 text-red-800">
                                    High
                                </span>
                            </td>
                            <td class="px-6 py-4 text-sm text-gray-500">
                                Today, 10:30 AM
                            </td>
                            <td class="px-6 py-4 text-sm text-gray-500">
                                2 hours ago
                            </td>
                            <td class="px-6 py-4">
                                <a href="/tickets/1001" class="text-primary hover:text-blue-700 font-medium">View</a>
                            </td>
                        </tr>
                        
                        <!-- Ticket 2 -->
                        <tr class="hover:bg-gray-50">
                            <td class="px-6 py-4">
                                <span class="font-medium text-blue-600">#DW-2024-1002</span>
                            </td>
                            <td class="px-6 py-4">
                                <div>
                                    <p class="font-medium text-gray-900">Software License Renewal</p>
                                    <p class="text-sm text-gray-500">Adobe Creative Cloud licenses</p>
                                </div>
                            </td>
                            <td class="px-6 py-4">
                                <span class="status-badge status-in-progress">In Progress</span>
                            </td>
                            <td class="px-6 py-4">
                                <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-yellow-100 text-yellow-800">
                                    Medium
                                </span>
                            </td>
                            <td class="px-6 py-4 text-sm text-gray-500">
                                Yesterday, 2:15 PM
                            </td>
                            <td class="px-6 py-4 text-sm text-gray-500">
                                1 hour ago
                            </td>
                            <td class="px-6 py-4">
                                <a href="/tickets/1002" class="text-primary hover:text-blue-700 font-medium">View</a>
                            </td>
                        </tr>
                        
                        <!-- Ticket 3 -->
                        <tr class="hover:bg-gray-50">
                            <td class="px-6 py-4">
                                <span class="font-medium text-blue-600">#DW-2024-1003</span>
                            </td>
                            <td class="px-6 py-4">
                                <div>
                                    <p class="font-medium text-gray-900">Printer Setup Complete</p>
                                    <p class="text-sm text-gray-500">Network printer configuration</p>
                                </div>
                            </td>
                            <td class="px-6 py-4">
                                <span class="status-badge status-resolved">Resolved</span>
                            </td>
                            <td class="px-6 py-4">
                                <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-green-100 text-green-800">
                                    Low
                                </span>
                            </td>
                            <td class="px-6 py-4 text-sm text-gray-500">
                                3 days ago
                            </td>
                            <td class="px-6 py-4 text-sm text-gray-500">
                                2 days ago
                            </td>
                            <td class="px-6 py-4">
                                <a href="/tickets/1003" class="text-primary hover:text-blue-700 font-medium">View</a>
                            </td>
                        </tr>
                        
                        <!-- Ticket 4 -->
                        <tr class="hover:bg-gray-50">
                            <td class="px-6 py-4">
                                <span class="font-medium text-blue-600">#DW-2024-1004</span>
                            </td>
                            <td class="px-6 py-4">
                                <div>
                                    <p class="font-medium text-gray-900">Email Configuration</p>
                                    <p class="text-sm text-gray-500">New email accounts setup</p>
                                </div>
                            </td>
                            <td class="px-6 py-4">
                                <span class="status-badge status-pending">Pending</span>
                            </td>
                            <td class="px-6 py-4">
                                <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-yellow-100 text-yellow-800">
                                    Medium
                                </span>
                            </td>
                            <td class="px-6 py-4 text-sm text-gray-500">
                                1 week ago
                            </td>
                            <td class="px-6 py-4 text-sm text-gray-500">
                                3 days ago
                            </td>
                            <td class="px-6 py-4">
                                <a href="/tickets/1004" class="text-primary hover:text-blue-700 font-medium">View</a>
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>
            
            <!-- Pagination -->
            <div class="px-6 py-4 border-t border-gray-200">
                <div class="flex items-center justify-between">
                    <div class="text-sm text-gray-500">
                        Showing <span class="font-medium">1</span> to <span class="font-medium">4</span> of <span class="font-medium">16</span> tickets
                    </div>
                    <div class="flex space-x-2">
                        <button class="px-3 py-1 border border-gray-300 rounded-md text-sm hover:bg-gray-50">
                            Previous
                        </button>
                        <button class="px-3 py-1 bg-primary text-white rounded-md text-sm">
                            1
                        </button>
                        <button class="px-3 py-1 border border-gray-300 rounded-md text-sm hover:bg-gray-50">
                            2
                        </button>
                        <button class="px-3 py-1 border border-gray-300 rounded-md text-sm hover:bg-gray-50">
                            3
                        </button>
                        <button class="px-3 py-1 border border-gray-300 rounded-md text-sm hover:bg-gray-50">
                            Next
                        </button>
                    </div>
                </div>
            </div>
        </div>

        <!-- Empty State (if no tickets) -->
        <div id="emptyState" class="hidden bg-white rounded-xl p-12 text-center shadow-sm">
            <div class="w-24 h-24 bg-gray-100 rounded-full flex items-center justify-center mx-auto mb-6">
                <i class="fas fa-ticket-alt text-gray-400 text-3xl"></i>
            </div>
            <h3 class="text-lg font-medium text-gray-900 mb-2">No tickets yet</h3>
            <p class="text-gray-600 mb-6">You haven't created any support tickets yet.</p>
            <a href="/tickets/create" class="bg-primary hover:bg-blue-700 text-white px-6 py-3 rounded-lg font-medium inline-flex items-center space-x-2">
                <i class="fas fa-plus"></i>
                <span>Create Your First Ticket</span>
            </a>
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
                    <a href="/privacy" class="text-sm hover:text-white transition">Privacy Policy</a>
                    <a href="/terms" class="text-sm hover:text-white transition">Terms of Service</a>
                    <a href="/contact" class="text-sm hover:text-white transition">Contact Us</a>
                </div>
            </div>
        </div>
    </footer>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            // User dropdown toggle
            const userMenuBtn = document.getElementById('userMenuBtn');
            const userDropdown = document.getElementById('userDropdown');
            const dropdownArrow = document.getElementById('dropdownArrow');
            
            if (userMenuBtn && userDropdown) {
                userMenuBtn.addEventListener('click', function(e) {
                    e.stopPropagation();
                    userDropdown.classList.toggle('hidden');
                    dropdownArrow.classList.toggle('rotate-180');
                });
                
                // Close dropdown when clicking outside
                document.addEventListener('click', function(e) {
                    const container = document.getElementById('userDropdownContainer');
                    if (!container.contains(e.target)) {
                        userDropdown.classList.add('hidden');
                        dropdownArrow.classList.remove('rotate-180');
                    }
                });
            }
            
            // Filter buttons
            const filterButtons = document.querySelectorAll('.bg-gray-100');
            filterButtons.forEach(button => {
                button.addEventListener('click', function() {
                    filterButtons.forEach(btn => {
                        btn.classList.remove('bg-primary', 'text-white');
                        btn.classList.add('bg-gray-100', 'hover:bg-gray-200');
                    });
                    this.classList.remove('bg-gray-100', 'hover:bg-gray-200');
                    this.classList.add('bg-primary', 'text-white');
                });
            });
            
            // Check if table is empty and show empty state
            const tableRows = document.querySelectorAll('tbody tr');
            const emptyState = document.getElementById('emptyState');
            const table = document.querySelector('table');
            
            if (tableRows.length === 0 && emptyState && table) {
                table.style.display = 'none';
                emptyState.classList.remove('hidden');
            }
        });
    </script>
</body>
</html>