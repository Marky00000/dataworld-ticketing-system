<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Manage Categories - Dataworld Support</title>
    <link rel="icon" type="image/png" href="{{ asset('images/logo.png') }}">
    
    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    
    <!-- SweetAlert2 for beautiful alerts -->
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    
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

        /* Modal animations */
        .modal-enter {
            animation: modalEnter 0.3s ease-out;
        }

        @keyframes modalEnter {
            from {
                opacity: 0;
                transform: scale(0.95);
            }
            to {
                opacity: 1;
                transform: scale(1);
            }
        }
    </style>
</head>
<body class="bg-gray-50 min-h-screen flex flex-col">
    <!-- Top Navigation Bar - Modern Updated -->
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
                       class="{{ request()->is('dashboard') ? 'text-primary font-medium' : 'text-gray-700 hover:text-primary' }} transition-all duration-300 flex items-center space-x-2 relative group">
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
                       class="{{ request()->is('tickets') || request()->is('tickets/*') ? 'text-primary font-medium' : 'text-gray-700 hover:text-primary' }} transition-all duration-300 flex items-center space-x-2 relative group">
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
                                    <div class="absolute -bottom-1 -right-1 w-3 h-3 bg-green-500 rounded-full border-2 border-white"></div>
                                </div>
                                <div class="text-left hidden lg:block">
                                    <p class="text-sm font-medium text-gray-900">{{ auth()->user()->name }}</p>
                                </div>
                            </div>
                            <i class="fas fa-chevron-down text-gray-400 text-sm transition-transform duration-300 group-hover:rotate-180"></i>
                        </button>
                        
                        <!-- Dropdown Menu -->
                        <div class="absolute right-0 mt-2 w-64 bg-white rounded-xl shadow-2xl py-2 z-50 opacity-0 invisible group-hover:opacity-100 group-hover:visible transition-all duration-300 border border-primary/10 transform origin-top-right scale-95 group-hover:scale-100">
                            
                            <!-- User info header -->
                            <div class="px-4 py-4 border-b border-gray-100">
                                <div class="flex items-center space-x-3">
                                    <div class="w-12 h-12 bg-gradient-to-br from-primary to-primaryDark rounded-full flex items-center justify-center text-white font-bold text-lg shadow-md">
                                        {{ substr(auth()->user()->name, 0, 1) }}
                                    </div>
                                    <div class="flex-1 min-w-0">
                                        <p class="text-sm font-bold text-gray-900 truncate">{{ auth()->user()->name }}</p>
                                        <p class="text-xs text-gray-500 truncate">{{ auth()->user()->email }}</p>
                                        <span class="inline-flex items-center mt-1 px-2 py-0.5 rounded-full text-xs font-medium 
                                            @if(auth()->user()->user_type === 'admin') bg-blue-100 text-blue-700
                                            @elseif(auth()->user()->user_type === 'tech') bg-purple-100 text-purple-700
                                            @else bg-primary/10 text-primary
                                            @endif">
                                            <i class="fas 
                                                @if(auth()->user()->user_type === 'admin') fa-crown
                                                @elseif(auth()->user()->user_type === 'tech') fa-tools
                                                @else fa-user
                                                @endif mr-1 text-[8px]"></i>
                                            @if(auth()->user()->user_type === 'admin')
                                                Admin Account
                                            @elseif(auth()->user()->user_type === 'tech')
                                                Tech Account
                                            @else
                                                Client Account
                                            @endif
                                        </span>
                                    </div>
                                </div>
                            </div>
                            
                            <!-- Menu items -->
                            <a href="{{ route('profile.dashboard') }}" 
                               class="flex items-center space-x-3 px-4 py-3 text-sm text-gray-700 hover:bg-primary/5 transition-all duration-300 group">
                                <div class="w-8 h-8 rounded-lg bg-gray-100 group-hover:bg-primary/10 flex items-center justify-center transition-colors duration-300">
                                    <i class="fas fa-user text-gray-500 group-hover:text-primary"></i>
                                </div>
                                <span class="flex-1">My Profile</span>
                                <i class="fas fa-chevron-right text-xs text-gray-400 group-hover:text-primary group-hover:translate-x-1 transition-all"></i>
                            </a>

                            @if(auth()->user()->user_type === 'admin')
                            <a href="{{ route('admin.tech.create') }}" 
                               class="flex items-center space-x-3 px-4 py-3 text-sm text-blue-600 hover:bg-blue-50 transition-all duration-300 group border-t border-gray-100 mt-1 pt-3">
                                <div class="w-8 h-8 rounded-lg bg-blue-100 group-hover:bg-blue-200 flex items-center justify-center transition-colors duration-300">
                                    <i class="fas fa-user-plus text-blue-600"></i>
                                </div>
                                <span class="flex-1 font-medium">Create Tech Account</span>
                                <span class="text-xs bg-blue-100 text-blue-800 px-2 py-0.5 rounded-full">Admin</span>
                            </a>
                            @endif
                            
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
                            <span class="inline-flex items-center px-2 py-0.5 rounded-full text-xs font-medium 
                                @if(auth()->user()->user_type === 'admin') bg-blue-100 text-blue-700
                                @elseif(auth()->user()->user_type === 'tech') bg-purple-100 text-purple-700
                                @else bg-primary/10 text-primary
                                @endif">
                                <i class="fas 
                                    @if(auth()->user()->user_type === 'admin') fa-crown
                                    @elseif(auth()->user()->user_type === 'tech') fa-tools
                                    @else fa-user
                                    @endif mr-1 text-[8px]"></i>
                                {{ ucfirst(auth()->user()->user_type) }} Account
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
                </a>
                
                <a href="/tickets" 
                   class="flex items-center space-x-3 px-4 py-3 {{ request()->is('tickets') || request()->is('tickets/*') ? 'text-primary bg-primary/5 border border-primary/20' : 'text-gray-700 hover:bg-gray-50' }} rounded-xl transition-all duration-300 group">
                    <div class="w-10 h-10 {{ request()->is('tickets') || request()->is('tickets/*') ? 'bg-primary/10' : 'bg-gray-100 group-hover:bg-primary/10' }} rounded-xl flex items-center justify-center transition-colors">
                        <i class="fas fa-ticket-alt {{ request()->is('tickets') || request()->is('tickets/*') ? 'text-primary' : 'text-gray-500 group-hover:text-primary' }}"></i>
                    </div>
                    <div class="flex-1">
                        <p class="font-medium {{ request()->is('tickets') || request()->is('tickets/*') ? 'text-primary' : 'text-gray-900' }}">My Tickets</p>
                        <p class="text-xs text-gray-500">View your support tickets</p>
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
                
                <!-- Admin Only Section -->
                @if(auth()->user()->user_type === 'admin')
                <div class="border-t border-gray-200 pt-4 mt-2">
                    <a href="{{ route('admin.tech.create') }}" 
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
                
                <!-- Profile & Sign Out -->
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
    </style>

    <!-- Main Content - flex-1 pushes footer down -->
    <main class="flex-1">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
            <!-- Welcome Banner -->
            <div class="bg-gradient-to-r from-primary to-primaryDark rounded-2xl p-6 text-white mb-8">
                <div class="flex flex-col md:flex-row md:items-center justify-between">
                    <div>
                        <h1 class="text-2xl md:text-3xl font-bold mb-2">Ticket Categories 📁</h1>
                        <p class="text-primary-100">Manage and organize your support ticket categories.</p>
                    </div>
                    <!-- Updated button to open modal -->
                    <a href="javascript:void(0)" onclick="openCreateModal()" class="mt-4 md:mt-0 inline-flex items-center space-x-2 bg-white text-primary px-6 py-3 rounded-lg font-semibold hover:bg-gray-100 transition shadow-lg">
                        <i class="fas fa-plus-circle"></i>
                        <span>Add New Category</span>
                    </a>
                </div>
            </div>

            <!-- Create Category Modal -->
            <div id="createCategoryModal" class="fixed inset-0 z-50 hidden overflow-y-auto" aria-labelledby="modal-title" role="dialog" aria-modal="true">
                <div class="flex items-end justify-center min-h-screen pt-4 px-4 pb-20 text-center sm:block sm:p-0">
                    <!-- Background overlay -->
                    <div class="fixed inset-0 bg-gray-500 bg-opacity-75 transition-opacity backdrop-blur-sm" id="modalBackdrop"></div>

                    <!-- Modal panel -->
                    <div class="inline-block align-bottom bg-white rounded-2xl text-left overflow-hidden shadow-xl transform transition-all sm:my-8 sm:align-middle sm:max-w-lg sm:w-full modal-enter">
                        <form action="{{ route('admin.ticket-categories.store') }}" method="POST">
                            @csrf
                            
                            <!-- Modal header -->
                            <div class="bg-gradient-to-r from-primary to-primaryDark px-6 py-4">
                                <div class="flex items-center justify-between">
                                    <h3 class="text-lg font-semibold text-white flex items-center">
                                        <i class="fas fa-folder-plus mr-2"></i>
                                        Create New Category
                                    </h3>
                                    <button type="button" onclick="closeCreateModal()" class="text-white hover:text-gray-200 transition">
                                        <i class="fas fa-times text-xl"></i>
                                    </button>
                                </div>
                            </div>
                            
                            <!-- Modal body -->
                            <div class="px-6 py-6">
                                <div class="space-y-4">
                                    <div>
                                        <label for="name" class="block text-sm font-medium text-gray-700 mb-1">
                                            Category Name <span class="text-red-500">*</span>
                                        </label>
                                        <input type="text" 
                                               name="name" 
                                               id="name" 
                                               required
                                               class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-primary focus:border-transparent transition"
                                               placeholder="e.g., Network Support, Hardware Issues">
                                        <p class="text-xs text-gray-500 mt-1">Choose a descriptive name for the category</p>
                                    </div>
                                    
                                    <div class="bg-blue-50 rounded-lg p-4">
                                        <div class="flex items-start space-x-3">
                                            <div class="w-8 h-8 bg-blue-100 rounded-full flex items-center justify-center flex-shrink-0">
                                                <i class="fas fa-info-circle text-blue-600"></i>
                                            </div>
                                            <div>
                                                <p class="text-sm font-medium text-blue-800">Category Information</p>
                                                <p class="text-xs text-blue-600 mt-1">Categories help organize tickets and make it easier for users to submit requests under the right topic.</p>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            
                            <!-- Modal footer -->
                            <div class="bg-gray-50 px-6 py-4 flex items-center justify-end space-x-3">
                                <button type="button" 
                                        onclick="closeCreateModal()"
                                        class="px-4 py-2 border border-gray-300 rounded-lg text-gray-700 hover:bg-gray-50 transition font-medium">
                                    Cancel
                                </button>
                                <button type="submit" 
                                        class="px-4 py-2 bg-gradient-to-r from-primary to-primaryDark text-white rounded-lg hover:shadow-lg transition font-medium flex items-center space-x-2">
                                    <i class="fas fa-save"></i>
                                    <span>Save Category</span>
                                </button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>

            <!-- Edit Category Modal -->
            <!-- Edit Category Modal -->
<div id="editCategoryModal" class="fixed inset-0 z-50 hidden overflow-y-auto" aria-labelledby="modal-title" role="dialog" aria-modal="true">
    <div class="flex items-end justify-center min-h-screen pt-4 px-4 pb-20 text-center sm:block sm:p-0">
        <div class="fixed inset-0 bg-gray-500 bg-opacity-75 transition-opacity backdrop-blur-sm" id="editModalBackdrop"></div>
        
        <div class="inline-block align-bottom bg-white rounded-2xl text-left overflow-hidden shadow-xl transform transition-all sm:my-8 sm:align-middle sm:max-w-lg sm:w-full modal-enter">
            <form id="editCategoryForm" method="POST">
                @csrf
                @method('PUT')
                
                <div class="bg-gradient-to-r from-primary to-primaryDark px-6 py-4">
                    <div class="flex items-center justify-between">
                        <h3 class="text-lg font-semibold text-white flex items-center">
                            <i class="fas fa-edit mr-2"></i>
                            Edit Category
                        </h3>
                        <button type="button" onclick="closeEditModal()" class="text-white hover:text-gray-200 transition">
                            <i class="fas fa-times text-xl"></i>
                        </button>
                    </div>
                </div>
                
                <div class="px-6 py-6">
                    <div class="space-y-4">
                        <div>
                            <label for="edit_name" class="block text-sm font-medium text-gray-700 mb-1">
                                Category Name <span class="text-red-500">*</span>
                            </label>
                            <input type="text" 
                                   name="name" 
                                   id="edit_name" 
                                   required
                                   class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-primary focus:border-transparent transition"
                                   placeholder="Enter category name">
                        </div>
                        
                        <!-- Removed description field -->
                        
                        <div class="bg-blue-50 rounded-lg p-4">
                            <div class="flex items-start space-x-3">
                                <div class="w-8 h-8 bg-blue-100 rounded-full flex items-center justify-center flex-shrink-0">
                                    <i class="fas fa-info-circle text-blue-600"></i>
                                </div>
                                <div>
                                    <p class="text-sm font-medium text-blue-800">Category Information</p>
                                    <p class="text-xs text-blue-600 mt-1">Update the category name as needed. This will affect all tickets associated with this category.</p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                
                <div class="bg-gray-50 px-6 py-4 flex items-center justify-end space-x-3">
                    <button type="button" 
                            onclick="closeEditModal()"
                            class="px-4 py-2 border border-gray-300 rounded-lg text-gray-700 hover:bg-gray-50 transition font-medium">
                        Cancel
                    </button>
                    <button type="submit" 
                            class="px-4 py-2 bg-gradient-to-r from-primary to-primaryDark text-white rounded-lg hover:shadow-lg transition font-medium flex items-center space-x-2">
                        <i class="fas fa-save"></i>
                        <span>Update Category</span>
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

            <!-- Delete Category Modal -->
<div id="deleteCategoryModal" class="fixed inset-0 z-50 hidden overflow-y-auto" aria-labelledby="modal-title" role="dialog" aria-modal="true">
    <div class="flex items-center justify-center min-h-screen pt-4 px-4 pb-20 text-center sm:block sm:p-0">
        <!-- Background overlay -->
        <div class="fixed inset-0 bg-gray-500 bg-opacity-75 transition-opacity backdrop-blur-sm" id="deleteModalBackdrop"></div>

        <!-- Modal panel -->
        <div class="inline-block align-bottom bg-white rounded-2xl text-left overflow-hidden shadow-xl transform transition-all sm:my-8 sm:align-middle sm:max-w-lg sm:w-full modal-enter">
            <form id="deleteCategoryForm" method="POST">
                @csrf
                @method('DELETE')
                
                <!-- Modal header - Red gradient for danger -->
                <div class="bg-gradient-to-r from-red-500 to-red-600 px-6 py-4">
                    <div class="flex items-center justify-between">
                        <h3 class="text-lg font-semibold text-white flex items-center">
                            <i class="fas fa-exclamation-triangle mr-2"></i>
                            Delete Category
                        </h3>
                        <button type="button" onclick="closeDeleteModal()" class="text-white hover:text-gray-200 transition">
                            <i class="fas fa-times text-xl"></i>
                        </button>
                    </div>
                </div>
                
                <!-- Modal body -->
                <div class="px-6 py-6">
                    <div class="flex flex-col items-center text-center">
                        <!-- Warning icon with animation -->
                        <div class="w-20 h-20 bg-red-100 rounded-full flex items-center justify-center mb-4 animate-pulse">
                            <i class="fas fa-trash-alt text-red-500 text-3xl"></i>
                        </div>
                        
                        <h4 class="text-xl font-bold text-gray-800 mb-2">Are you absolutely sure?</h4>
                        
                        <p class="text-gray-600 mb-4">
                            This action <span class="font-semibold text-red-600">cannot</span> be undone. This will permanently delete the category:
                        </p>
                        
                        <!-- Category details card - removed ID -->
                        <div class="bg-gray-50 rounded-xl p-4 w-full mb-4 border border-gray-200">
                            <div class="flex items-center justify-center">
                                <span class="text-sm font-medium text-gray-500 mr-2">Category:</span>
                                <span class="text-sm font-semibold text-gray-800" id="deleteCategoryName"></span>
                            </div>
                        </div>
                        
                        <!-- Warning about tickets -->
                        <div class="bg-yellow-50 rounded-lg p-4 w-full border border-yellow-200">
                            <div class="flex items-start space-x-3">
                                <div class="w-8 h-8 bg-yellow-100 rounded-full flex items-center justify-center flex-shrink-0">
                                    <i class="fas fa-exclamation-circle text-yellow-600"></i>
                                </div>
                                <div class="text-left">
                                    <p class="text-sm font-medium text-yellow-800">Warning</p>
                                    <p class="text-xs text-yellow-700 mt-1">
                                        Any tickets associated with this category will need to be reassigned to another category.
                                    </p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                
                <!-- Modal footer -->
                <div class="bg-gray-50 px-6 py-4 flex items-center justify-end space-x-3">
                    <button type="button" 
                            onclick="closeDeleteModal()"
                            class="px-4 py-2 border border-gray-300 rounded-lg text-gray-700 hover:bg-gray-50 transition font-medium">
                        Cancel
                    </button>
                    <button type="submit" 
                            class="px-4 py-2 bg-gradient-to-r from-red-500 to-red-600 text-white rounded-lg hover:shadow-lg transition font-medium flex items-center space-x-2">
                        <i class="fas fa-trash-alt"></i>
                        <span>Yes, Delete Category</span>
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

            <!-- Stats Cards -->
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6 mb-8">
                <div class="bg-white rounded-xl shadow-md p-6 dashboard-card">
                    <div class="flex items-center justify-between">
                        <div>
                            <p class="text-gray-500 text-sm font-medium">Total Categories</p>
                            <p class="text-3xl font-bold text-gray-800 mt-2">{{ $categories->total() ?? 0 }}</p>
                        </div>
                        <div class="w-12 h-12 bg-blue-100 rounded-full flex items-center justify-center">
                            <i class="fas fa-folder text-blue-600 text-xl"></i>
                        </div>
                    </div>
                    <div class="mt-4">
                        <span class="text-xs text-gray-500 font-medium">
                            <i class="fas fa-layer-group mr-1"></i>
                            Organized support topics
                        </span>
                    </div>
                </div>
                
                <div class="bg-white rounded-xl shadow-md p-6 dashboard-card">
                    <div class="flex items-center justify-between">
                        <div>
                            <p class="text-gray-500 text-sm font-medium">With Tickets</p>
                            <p class="text-3xl font-bold text-gray-800 mt-2">{{ $categories->where('tickets_count', '>', 0)->count() ?? 0 }}</p>
                        </div>
                        <div class="w-12 h-12 bg-green-100 rounded-full flex items-center justify-center">
                            <i class="fas fa-ticket-alt text-green-600 text-xl"></i>
                        </div>
                    </div>
                    <div class="mt-4">
                        <span class="text-xs text-green-600 font-medium">
                            <i class="fas fa-check-circle mr-1"></i>
                            Categories in use
                        </span>
                    </div>
                </div>
                
                <div class="bg-white rounded-xl shadow-md p-6 dashboard-card">
                    <div class="flex items-center justify-between">
                        <div>
                            <p class="text-gray-500 text-sm font-medium">Empty Categories</p>
                            <p class="text-3xl font-bold text-gray-800 mt-2">{{ $categories->where('tickets_count', 0)->count() ?? 0 }}</p>
                        </div>
                        <div class="w-12 h-12 bg-orange-100 rounded-full flex items-center justify-center">
                            <i class="fas fa-folder-open text-orange-600 text-xl"></i>
                        </div>
                    </div>
                    <div class="mt-4">
                        <span class="text-xs text-orange-600 font-medium">
                            <i class="fas fa-info-circle mr-1"></i>
                            No tickets assigned
                        </span>
                    </div>
                </div>
                
                <div class="bg-white rounded-xl shadow-md p-6 dashboard-card">
                    <div class="flex items-center justify-between">
                        <div>
                            <p class="text-gray-500 text-sm font-medium">Most Used</p>
                            @php
                                $mostUsed = $categories->sortByDesc('tickets_count')->first();
                            @endphp
                            <p class="text-lg font-bold text-gray-800 mt-2 truncate max-w-[150px]">{{ $mostUsed->name ?? 'N/A' }}</p>
                        </div>
                        <div class="w-12 h-12 bg-purple-100 rounded-full flex items-center justify-center">
                            <i class="fas fa-star text-purple-600 text-xl"></i>
                        </div>
                    </div>
                    <div class="mt-4">
                        <span class="text-xs text-purple-600 font-medium">
                            <i class="fas fa-ticket-alt mr-1"></i>
                            {{ $mostUsed->tickets_count ?? 0 }} tickets
                        </span>
                    </div>
                </div>
            </div>

            <!-- Success Message -->
            @if(session('success'))
                <div class="mb-6 bg-green-100 border-l-4 border-green-500 text-green-700 p-4 rounded-lg flex items-center justify-between shadow-md" role="alert">
                    <div class="flex items-center space-x-3">
                        <div class="w-8 h-8 bg-green-200 rounded-full flex items-center justify-center">
                            <i class="fas fa-check-circle text-green-600 text-xl"></i>
                        </div>
                        <div>
                            <p class="font-medium">{{ session('success') }}</p>
                            <p class="text-xs text-green-600 mt-0.5">Category has been updated successfully.</p>
                        </div>
                    </div>
                    <button type="button" class="text-green-700 hover:text-green-900 transition" onclick="this.parentElement.remove()">
                        <i class="fas fa-times"></i>
                    </button>
                </div>
            @endif

            <!-- Error Message -->
            @if(session('error'))
                <div class="mb-6 bg-red-100 border-l-4 border-red-500 text-red-700 p-4 rounded-lg flex items-center justify-between shadow-md" role="alert">
                    <div class="flex items-center space-x-3">
                        <div class="w-8 h-8 bg-red-200 rounded-full flex items-center justify-center">
                            <i class="fas fa-exclamation-circle text-red-600 text-xl"></i>
                        </div>
                        <div>
                            <p class="font-medium">{{ session('error') }}</p>
                            <p class="text-xs text-red-600 mt-0.5">Please resolve the issue and try again.</p>
                        </div>
                    </div>
                    <button type="button" class="text-red-700 hover:text-red-900 transition" onclick="this.parentElement.remove()">
                        <i class="fas fa-times"></i>
                    </button>
                </div>
            @endif

            <!-- Categories Table -->
            <div class="bg-white rounded-xl shadow-md overflow-hidden">
                <div class="px-6 py-4 border-b border-gray-200 bg-gray-50">
                    <div class="flex items-center justify-between">
                        <h2 class="text-lg font-semibold text-gray-800">
                            <i class="fas fa-list-ul text-primary mr-2"></i>
                            All Categories
                        </h2>
                        <div class="text-sm text-gray-500">
                            <i class="fas fa-sort mr-1"></i>
                            Sorted by name
                        </div>
                    </div>
                </div>
                
                <div class="overflow-x-auto custom-scrollbar">
                    <table class="w-full">
                        <thead class="bg-gray-50">
                            <tr>
                                <th class="px-6 py-4 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">ID</th>
                                <th class="px-6 py-4 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Category Name</th>
                                <th class="px-6 py-4 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Created Date</th>
                                <th class="px-6 py-4 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Tickets</th>
                                <th class="px-6 py-4 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Status</th>
                                <th class="px-6 py-4 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Actions</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-gray-200">
                            @forelse($categories as $category)
                                <tr class="hover:bg-gray-50 transition group">
                                    <td class="px-6 py-4 text-sm font-mono text-gray-500">#{{ $category->id }}</td>
                                    <td class="px-6 py-4 text-sm font-medium text-gray-900">
                                        <div class="flex items-center">
                                            <div class="w-8 h-8 bg-primary/10 rounded-lg flex items-center justify-center mr-3 group-hover:bg-primary/20 transition">
                                                <i class="fas fa-folder text-primary text-sm"></i>
                                            </div>
                                            {{ $category->name }}
                                        </div>
                                    </td>
                                    <td class="px-6 py-4 text-sm text-gray-500">
                                        {{ $category->created_at ? $category->created_at->format('M d, Y') : 'N/A' }}
                                        <span class="text-xs text-gray-400 block">
                                            {{ $category->created_at ? $category->created_at->diffForHumans() : '' }}
                                        </span>
                                    </td>
                                    <td class="px-6 py-4 text-sm">
                                        @php
                                            $ticketCount = $category->tickets_count ?? $category->tickets()->count();
                                        @endphp
                                        <span class="status-badge {{ $ticketCount > 0 ? 'bg-blue-100 text-blue-800' : 'bg-gray-100 text-gray-600' }}">
                                            <i class="fas {{ $ticketCount > 0 ? 'fa-ticket-alt' : 'fa-folder-open' }} mr-1"></i>
                                            {{ $ticketCount }} {{ Str::plural('ticket', $ticketCount) }}
                                        </span>
                                    </td>
                                    <td class="px-6 py-4 text-sm">
                                        @if($ticketCount > 0)
                                            <span class="flex items-center text-green-600">
                                                <span class="w-2 h-2 bg-green-500 rounded-full mr-2"></span>
                                                In Use
                                            </span>
                                        @else
                                            <span class="flex items-center text-gray-500">
                                                <span class="w-2 h-2 bg-gray-400 rounded-full mr-2"></span>
                                                Empty
                                            </span>
                                        @endif
                                    </td>
                                    <td class="px-6 py-4 text-sm">
                                        <div class="flex items-center space-x-3">
                                           <button onclick="openEditModal('{{ $category->id }}', '{{ $category->name }}')" 
                                                    class="w-8 h-8 bg-blue-50 hover:bg-blue-100 rounded-lg flex items-center justify-center text-blue-600 hover:text-blue-700 transition"
                                                    title="Edit Category">
                                                <i class="fas fa-edit"></i>
                                            </button>
                                            
                                            @if($ticketCount > 0)
                                                <button onclick="showCannotDeleteAlert()" 
                                                        class="w-8 h-8 bg-gray-100 rounded-lg flex items-center justify-center text-gray-400 cursor-not-allowed"
                                                        title="Cannot delete category with existing tickets">
                                                    <i class="fas fa-trash"></i>
                                                </button>
                                            @else
                                                <button onclick="openDeleteModal('{{ $category->id }}', '{{ $category->name }}')" 
                                                        class="w-8 h-8 bg-red-50 hover:bg-red-100 rounded-lg flex items-center justify-center text-red-600 hover:text-red-700 transition"
                                                        title="Delete Category">
                                                    <i class="fas fa-trash"></i>
                                                </button>
                                            @endif
                                        </div>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="6" class="px-6 py-16 text-center">
                                        <div class="flex flex-col items-center justify-center">
                                            <div class="w-24 h-24 bg-gray-100 rounded-full flex items-center justify-center mb-4">
                                                <i class="fas fa-folder-open text-gray-400 text-4xl"></i>
                                            </div>
                                            <h3 class="text-lg font-medium text-gray-700 mb-2">No categories yet</h3>
                                            <p class="text-gray-500 text-sm mb-6 max-w-md">Get started by creating your first ticket category. Categories help organize support requests efficiently.</p>
                                            <a href="javascript:void(0)" onclick="openCreateModal()" 
                                               class="inline-flex items-center space-x-2 bg-primary hover:bg-primaryDark text-white px-6 py-3 rounded-lg font-medium transition shadow-md hover:shadow-lg">
                                                <i class="fas fa-plus-circle"></i>
                                                <span>Create First Category</span>
                                            </a>
                                        </div>
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
                
                <!-- Pagination -->
                @if(method_exists($categories, 'hasPages') && $categories->hasPages())
                    <div class="px-6 py-4 border-t border-gray-200 bg-gray-50">
                        <div class="flex flex-col sm:flex-row items-center justify-between gap-4">
                            <div class="text-sm text-gray-600">
                                Showing <span class="font-semibold text-gray-900">{{ $categories->firstItem() ?? 0 }}</span> 
                                to <span class="font-semibold text-gray-900">{{ $categories->lastItem() ?? 0 }}</span> 
                                of <span class="font-semibold text-gray-900">{{ $categories->total() }}</span> categories
                            </div>
                            
                            <div class="flex items-center space-x-2">
                                {{-- Previous Page Link --}}
                                @if($categories->onFirstPage())
                                    <span class="inline-flex items-center justify-center w-10 h-10 bg-gray-100 text-gray-400 rounded-lg cursor-not-allowed">
                                        <i class="fas fa-chevron-left"></i>
                                    </span>
                                @else
                                    <a href="{{ $categories->previousPageUrl() }}" class="inline-flex items-center justify-center w-10 h-10 bg-white border border-gray-300 text-gray-700 rounded-lg hover:bg-primary hover:text-white hover:border-primary transition-all duration-200">
                                        <i class="fas fa-chevron-left"></i>
                                    </a>
                                @endif

                                {{-- Pagination Elements --}}
                                @php
                                    $start = max($categories->currentPage() - 2, 1);
                                    $end = min($start + 4, $categories->lastPage());
                                    $start = max(min($start, $categories->lastPage() - 4), 1);
                                @endphp

                                @if($start > 1)
                                    <a href="{{ $categories->url(1) }}" class="inline-flex items-center justify-center w-10 h-10 bg-white border border-gray-300 text-gray-700 rounded-lg hover:bg-primary hover:text-white hover:border-primary transition-all duration-200 font-medium">1</a>
                                    @if($start > 2)
                                        <span class="inline-flex items-center justify-center w-10 h-10 text-gray-500">...</span>
                                    @endif
                                @endif

                                @for($page = $start; $page <= $end; $page++)
                                    @if($page == $categories->currentPage())
                                        <span class="inline-flex items-center justify-center w-10 h-10 bg-primary text-white rounded-lg font-medium shadow-md">{{ $page }}</span>
                                    @else
                                        <a href="{{ $categories->url($page) }}" class="inline-flex items-center justify-center w-10 h-10 bg-white border border-gray-300 text-gray-700 rounded-lg hover:bg-primary hover:text-white hover:border-primary transition-all duration-200 font-medium">{{ $page }}</a>
                                    @endif
                                @endfor

                                @if($end < $categories->lastPage())
                                    @if($end < $categories->lastPage() - 1)
                                        <span class="inline-flex items-center justify-center w-10 h-10 text-gray-500">...</span>
                                    @endif
                                    <a href="{{ $categories->url($categories->lastPage()) }}" class="inline-flex items-center justify-center w-10 h-10 bg-white border border-gray-300 text-gray-700 rounded-lg hover:bg-primary hover:text-white hover:border-primary transition-all duration-200 font-medium">{{ $categories->lastPage() }}</a>
                                @endif

                                {{-- Next Page Link --}}
                                @if($categories->hasMorePages())
                                    <a href="{{ $categories->nextPageUrl() }}" class="inline-flex items-center justify-center w-10 h-10 bg-white border border-gray-300 text-gray-700 rounded-lg hover:bg-primary hover:text-white hover:border-primary transition-all duration-200">
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
    <footer class="bg-gray-900 text-gray-400 py-8 mt-auto">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="border-t border-gray-800 pt-8 text-center text-sm">
                <p>
                    © {{ date('Y') }} Dataworld Computer Center. All rights reserved.
                </p>
            </div>
        </div>
    </footer>

    <!-- Modal Functions JavaScript -->
    <script>
        // Create Modal Functions
        function openCreateModal() {
            document.getElementById('createCategoryModal').classList.remove('hidden');
            document.body.style.overflow = 'hidden';
        }
        
        function closeCreateModal() {
            document.getElementById('createCategoryModal').classList.add('hidden');
            document.body.style.overflow = 'auto';
        }
        
        // Edit Modal Functions
function openEditModal(categoryId, categoryName) {
    const form = document.getElementById('editCategoryForm');
    form.action = `/admin/ticket-categories/${categoryId}`;
    document.getElementById('edit_name').value = categoryName;
    document.getElementById('editCategoryModal').classList.remove('hidden');
    document.body.style.overflow = 'hidden';
}
        
        function closeEditModal() {
            document.getElementById('editCategoryModal').classList.add('hidden');
            document.body.style.overflow = 'auto';
        }
        
        // Delete Modal Functions
        function openDeleteModal(categoryId, categoryName) {
            const form = document.getElementById('deleteCategoryForm');
            form.action = `/admin/ticket-categories/${categoryId}`;
            document.getElementById('deleteCategoryName').textContent = categoryName;
            document.getElementById('deleteCategoryModal').classList.remove('hidden');
            document.body.style.overflow = 'hidden';
        }
        
        function closeDeleteModal() {
            document.getElementById('deleteCategoryModal').classList.add('hidden');
            document.body.style.overflow = 'auto';
        }
        
        function showCannotDeleteAlert() {
            Swal.fire({
                title: 'Cannot Delete Category',
                text: 'This category has existing tickets. Please reassign or delete the tickets first.',
                icon: 'warning',
                confirmButtonColor: '#6366f1',
                confirmButtonText: 'OK',
                background: '#ffffff',
                backdrop: 'rgba(0,0,0,0.4)'
            });
        }
        
        // Close modals when clicking outside
        document.addEventListener('click', function(event) {
            const createModal = document.getElementById('createCategoryModal');
            const editModal = document.getElementById('editCategoryModal');
            const deleteModal = document.getElementById('deleteCategoryModal');
            
            if (event.target.id === 'modalBackdrop') {
                closeCreateModal();
            }
            
            if (event.target.id === 'editModalBackdrop') {
                closeEditModal();
            }
            
            if (event.target.id === 'deleteModalBackdrop') {
                closeDeleteModal();
            }
        });
        
        // Close modals with Escape key
        document.addEventListener('keydown', function(event) {
            if (event.key === 'Escape') {
                closeCreateModal();
                closeEditModal();
                closeDeleteModal();
            }
        });

        // Original DOM Content Loaded functions
        document.addEventListener('DOMContentLoaded', function() {
            // Mobile menu toggle
            const mobileMenuButton = document.getElementById('mobileMenuButton');
            const mobileMenu = document.getElementById('mobileMenu');
            
            if (mobileMenuButton && mobileMenu) {
                mobileMenuButton.addEventListener('click', function() {
                    mobileMenu.classList.toggle('hidden');
                });
                
                document.addEventListener('click', function(event) {
                    if (!mobileMenu.contains(event.target) && !mobileMenuButton.contains(event.target)) {
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
            
            // Auto-hide alerts after 5 seconds
            const alerts = document.querySelectorAll('[role="alert"]');
            alerts.forEach(alert => {
                setTimeout(() => {
                    alert.style.transition = 'opacity 0.5s ease';
                    alert.style.opacity = '0';
                    setTimeout(() => {
                        alert.remove();
                    }, 500);
                }, 5000);
            });
        });
    </script>
</body>
</html>