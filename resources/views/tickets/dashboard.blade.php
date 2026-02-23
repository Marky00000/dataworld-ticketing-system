<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard - Dataworld Support</title>
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
                        primary: '#3b82f6',
                        secondary: '#10b981',
                        warning: '#f59e0b',
                        danger: '#ef4444'
                    }
                }
            }
        }
    </script>
    
    <style>
        .card-hover {
            transition: all 0.3s ease;
        }
        .card-hover:hover {
            transform: translateY(-2px);
            box-shadow: 0 10px 25px rgba(0, 0, 0, 0.1);
        }
        
        /* Navbar Styles */
        .nav-link {
            display: flex;
            align-items: center;
            padding: 8px 16px;
            margin: 0 4px;
            border-radius: 8px;
            font-size: 14px;
            font-weight: 500;
            color: #6b7280;
            transition: all 0.2s ease;
            position: relative;
        }
        
        .nav-link:hover {
            color: #3b82f6;
            background-color: #f3f4f6;
        }
        
        .nav-link.active {
            color: #3b82f6;
            background: linear-gradient(135deg, #eff6ff 0%, #dbeafe 100%);
            font-weight: 600;
        }
        
        .nav-link.active::after {
            content: '';
            position: absolute;
            bottom: -8px;
            left: 0;
            right: 0;
            height: 2px;
            background: linear-gradient(90deg, #3b82f6, #60a5fa);
            border-radius: 1px;
        }
        
        .nav-icon {
            width: 16px;
            text-align: center;
            margin-right: 8px;
            font-size: 16px;
        }
    </style>
</head>
<body class="bg-gray-50 min-h-screen">
    <!-- Navigation -->
    <nav class="bg-white shadow-md border-b border-gray-200">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex justify-between h-16">
                <!-- Logo -->
                <div class="flex items-center">
                    <a href="/dashboard" class="flex items-center space-x-2 group">
                        <img src="{{ asset('images/dwcc.png') }}" alt="Dataworld Logo" class="h-8 w-auto">
                        <div class="flex flex-col">
                            <span class="text-gray-800 font-semibold">Support Portal</span>
                            <span class="text-xs text-blue-600 font-medium opacity-0 group-hover:opacity-100 transition-opacity">
                                Dataworld Computer Center
                            </span>
                        </div>
                    </a>
                </div>
                
                <!-- Menu -->
                <div class="flex items-center space-x-1">
                    <a href="/dashboard" 
                       class="nav-link active">
                        <i class="fas fa-home nav-icon"></i>
                        <span>Dashboard</span>
                    </a>
                    <a href="/tickets" 
                       class="nav-link">
                        <i class="fas fa-ticket-alt nav-icon"></i>
                        <span>My Tickets</span>
                    </a>
                    <a href="/tickets/create" 
                       class="nav-link">
                        <i class="fas fa-plus-circle nav-icon"></i>
                        <span>New Ticket</span>
                    </a>
                </div>
                
                <!-- User Menu -->
                <div class="flex items-center">
                    <div class="relative" id="userDropdownContainer">
                        <button id="userMenuBtn" class="flex items-center space-x-3 focus:outline-none group">
                            <div class="relative">
                                <div class="w-10 h-10 bg-gradient-to-r from-blue-500 to-blue-600 rounded-full flex items-center justify-center text-white font-semibold shadow-sm">
                                    {{ strtoupper(substr(auth()->user()->name, 0, 1)) }}
                                </div>
                                <div class="absolute -bottom-1 -right-1 w-4 h-4 bg-green-400 rounded-full border-2 border-white"></div>
                            </div>
                            <div class="text-left hidden lg:block">
                                <p class="text-sm font-medium text-gray-900">{{ auth()->user()->name }}</p>
                                <p class="text-xs text-gray-500 capitalize">{{ auth()->user()->user_type }}</p>
                            </div>
                            <i class="fas fa-chevron-down text-gray-400 text-xs transition-transform duration-200" 
                               id="dropdownArrow"></i>
                        </button>
                        
                        <!-- Dropdown Menu -->
                        <div id="userDropdown" class="absolute right-0 mt-2 w-56 bg-white rounded-lg shadow-lg py-2 hidden z-50 border border-gray-200">
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
                            
                            <a href="/profile" 
                               class="flex items-center space-x-3 px-4 py-3 text-sm text-gray-700 hover:bg-gray-50 transition group">
                                <i class="fas fa-user-circle text-gray-400 group-hover:text-blue-500 transition"></i>
                                <span>My Profile</span>
                            </a>
                            
                            <a href="/settings" 
                               class="flex items-center space-x-3 px-4 py-3 text-sm text-gray-700 hover:bg-gray-50 transition group">
                                <i class="fas fa-cog text-gray-400 group-hover:text-blue-500 transition"></i>
                                <span>Settings</span>
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
                                <button type="submit" 
                                        class="flex items-center space-x-3 px-4 py-3 text-sm text-red-600 hover:bg-red-50 transition w-full text-left group">
                                    <i class="fas fa-sign-out-alt group-hover:scale-110 transition-transform"></i>
                                    <span>Sign Out</span>
                                </button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </nav>

    <!-- Main Content -->
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
        <!-- Welcome Header -->
        <div class="mb-10">
            <h1 class="text-3xl md:text-4xl font-bold text-gray-900 mb-4">
                Welcome back, {{ auth()->user()->name }}! 👋
            </h1>
            <p class="text-lg text-gray-600">
                Here's an overview of your support portal activity and quick access to features.
            </p>
        </div>

        <!-- Quick Stats -->
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6 mb-10">
            <div class="bg-white rounded-xl p-6 shadow-sm card-hover">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-gray-500 text-sm">Open Tickets</p>
                        <p class="text-2xl font-bold text-gray-900 mt-2">3</p>
                    </div>
                    <div class="w-12 h-12 bg-blue-100 rounded-full flex items-center justify-center">
                        <i class="fas fa-ticket-alt text-blue-600 text-xl"></i>
                    </div>
                </div>
                <a href="/tickets" class="text-blue-600 text-sm font-medium mt-4 inline-block">
                    View all →
                </a>
            </div>
            
            <div class="bg-white rounded-xl p-6 shadow-sm card-hover">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-gray-500 text-sm">Awaiting Response</p>
                        <p class="text-2xl font-bold text-gray-900 mt-2">1</p>
                    </div>
                    <div class="w-12 h-12 bg-yellow-100 rounded-full flex items-center justify-center">
                        <i class="fas fa-clock text-yellow-600 text-xl"></i>
                    </div>
                </div>
                <div class="mt-4">
                    <span class="text-xs text-yellow-600 font-medium">
                        <i class="fas fa-exclamation-circle mr-1"></i>
                        Needs your attention
                    </span>
                </div>
            </div>
            
            <div class="bg-white rounded-xl p-6 shadow-sm card-hover">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-gray-500 text-sm">Resolved This Month</p>
                        <p class="text-2xl font-bold text-gray-900 mt-2">12</p>
                    </div>
                    <div class="w-12 h-12 bg-green-100 rounded-full flex items-center justify-center">
                        <i class="fas fa-check-circle text-green-600 text-xl"></i>
                    </div>
                </div>
                <div class="mt-4">
                    <span class="text-xs text-green-600 font-medium">
                        <i class="fas fa-arrow-up mr-1"></i>
                        40% from last month
                    </span>
                </div>
            </div>
            
            <div class="bg-white rounded-xl p-6 shadow-sm card-hover">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-gray-500 text-sm">Avg. Resolution Time</p>
                        <p class="text-2xl font-bold text-gray-900 mt-2">8.2h</p>
                    </div>
                    <div class="w-12 h-12 bg-purple-100 rounded-full flex items-center justify-center">
                        <i class="fas fa-bolt text-purple-600 text-xl"></i>
                    </div>
                </div>
                <div class="mt-4">
                    <span class="text-xs text-green-600 font-medium">
                        <i class="fas fa-arrow-down mr-1"></i>
                        1.3h faster than average
                    </span>
                </div>
            </div>
        </div>

        <!-- Quick Actions -->
        <div class="bg-white rounded-xl p-8 shadow-sm mb-10">
            <h2 class="text-xl font-bold text-gray-900 mb-6">Quick Actions</h2>
            <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                <a href="/tickets/create" class="bg-blue-50 hover:bg-blue-100 rounded-xl p-6 card-hover transition flex flex-col items-center text-center">
                    <div class="w-16 h-16 bg-blue-100 rounded-full flex items-center justify-center mb-4">
                        <i class="fas fa-plus text-blue-600 text-2xl"></i>
                    </div>
                    <h3 class="font-bold text-gray-900 mb-2">Create New Ticket</h3>
                    <p class="text-gray-600 text-sm">Report a new issue or request support</p>
                </a>
                
                <a href="/tickets" class="bg-green-50 hover:bg-green-100 rounded-xl p-6 card-hover transition flex flex-col items-center text-center">
                    <div class="w-16 h-16 bg-green-100 rounded-full flex items-center justify-center mb-4">
                        <i class="fas fa-ticket-alt text-green-600 text-2xl"></i>
                    </div>
                    <h3 class="font-bold text-gray-900 mb-2">View My Tickets</h3>
                    <p class="text-gray-600 text-sm">Track all your support requests</p>
                </a>
                
                <a href="/knowledge-base" class="bg-purple-50 hover:bg-purple-100 rounded-xl p-6 card-hover transition flex flex-col items-center text-center">
                    <div class="w-16 h-16 bg-purple-100 rounded-full flex items-center justify-center mb-4">
                        <i class="fas fa-book text-purple-600 text-2xl"></i>
                    </div>
                    <h3 class="font-bold text-gray-900 mb-2">Knowledge Base</h3>
                    <p class="text-gray-600 text-sm">Find solutions and guides</p>
                </a>
            </div>
        </div>

        <!-- Recent Activity -->
        <div class="grid grid-cols-1 lg:grid-cols-2 gap-8">
            <!-- Recent Tickets -->
            <div class="bg-white rounded-xl shadow-sm p-6">
                <div class="flex items-center justify-between mb-6">
                    <h2 class="text-xl font-bold text-gray-900">Recent Tickets</h2>
                    <a href="/tickets" class="text-blue-600 hover:text-blue-700 text-sm font-medium">
                        View All →
                    </a>
                </div>
                <div class="space-y-4">
                    <div class="flex items-center justify-between p-4 bg-gray-50 rounded-lg">
                        <div>
                            <p class="font-medium text-gray-900">#DW-2024-1001</p>
                            <p class="text-sm text-gray-600">Server Connection Issue</p>
                        </div>
                        <span class="px-3 py-1 bg-red-100 text-red-800 rounded-full text-xs font-medium">
                            High
                        </span>
                    </div>
                    
                    <div class="flex items-center justify-between p-4 bg-gray-50 rounded-lg">
                        <div>
                            <p class="font-medium text-gray-900">#DW-2024-1002</p>
                            <p class="text-sm text-gray-600">Software License Renewal</p>
                        </div>
                        <span class="px-3 py-1 bg-yellow-100 text-yellow-800 rounded-full text-xs font-medium">
                            Medium
                        </span>
                    </div>
                    
                    <div class="flex items-center justify-between p-4 bg-gray-50 rounded-lg">
                        <div>
                            <p class="font-medium text-gray-900">#DW-2024-1003</p>
                            <p class="text-sm text-gray-600">Printer Setup Complete</p>
                        </div>
                        <span class="px-3 py-1 bg-green-100 text-green-800 rounded-full text-xs font-medium">
                            Resolved
                        </span>
                    </div>
                </div>
            </div>

            <!-- Support Status -->
            <div class="bg-white rounded-xl shadow-sm p-6">
                <h2 class="text-xl font-bold text-gray-900 mb-6">Support Status</h2>
                <div class="space-y-6">
                    <div class="flex items-center justify-between">
                        <div class="flex items-center">
                            <div class="w-3 h-3 bg-green-500 rounded-full mr-3"></div>
                            <span class="text-gray-700">System Status</span>
                        </div>
                        <span class="font-medium text-green-600">All Systems Operational</span>
                    </div>
                    
                    <div class="flex items-center justify-between">
                        <span class="text-gray-700">Current Response Time</span>
                        <span class="font-medium">Under 1 hour</span>
                    </div>
                    
                    <div class="flex items-center justify-between">
                        <span class="text-gray-700">Support Hours</span>
                        <span class="font-medium">24/7 Available</span>
                    </div>
                    
                    <div class="pt-6 border-t border-gray-200">
                        <h3 class="font-medium text-gray-900 mb-3">Need Immediate Help?</h3>
                        <div class="space-y-2">
                            <div class="flex items-center">
                                <i class="fas fa-phone text-blue-600 mr-3"></i>
                                <span class="text-sm">1-800-DATAWORLD</span>
                            </div>
                            <div class="flex items-center">
                                <i class="fas fa-envelope text-blue-600 mr-3"></i>
                                <span class="text-sm">support@dataworld.com</span>
                            </div>
                        </div>
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
        });
    </script>
</body>
</html>