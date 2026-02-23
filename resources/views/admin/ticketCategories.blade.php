<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Manage Categories - Dataworld Support</title>
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
    </style>
</head>
<body class="bg-gray-50 min-h-screen flex flex-col">
    <!-- Top Navigation Bar -->
    <nav class="bg-white shadow-lg border-b border-gray-200 sticky top-0 z-50">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex justify-between h-16">
                <!-- Logo -->
                <div class="flex items-center">
                    <a href="{{ route('admin.dashboard') }}" class="flex items-center space-x-2 group">
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
                    <a href="{{ route('admin.dashboard') }}" class="{{ request()->routeIs('admin.dashboard') ? 'text-primary border-b-2 border-primary' : 'text-gray-700 hover:text-primary' }} font-medium transition flex items-center space-x-2 pb-1">
                        <i class="fas fa-home"></i>
                        <span>Dashboard</span>
                    </a>

                    <a href="{{ route('tickets.index') }}" class="{{ request()->routeIs('tickets.*') ? 'text-primary border-b-2 border-primary' : 'text-gray-700 hover:text-primary' }} font-medium transition flex items-center space-x-2 pb-1">
                        <i class="fas fa-ticket-alt"></i>
                        <span>Tickets</span>
                    </a>

                    <a href="{{ route('admin.ticket-categories') }}" class="{{ request()->routeIs('admin.ticket-categories*') ? 'text-primary border-b-2 border-primary' : 'text-gray-700 hover:text-primary' }} font-medium transition flex items-center space-x-2 pb-1">
                        <i class="fas fa-folder"></i>
                        <span>Categories</span>
                    </a>
                    
                    <a href="{{ route('admin.tech.create') }}" class="{{ request()->routeIs('admin.tech.create') ? 'text-primary border-b-2 border-primary' : 'text-gray-700 hover:text-primary' }} font-medium transition flex items-center space-x-2 pb-1">
                        <i class="fas fa-user-plus"></i>
                        <span>Add Tech</span>
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
                                </div>
                            </div>
                            <i class="fas fa-chevron-down text-gray-400 text-sm"></i>
                        </button>
                        
                        <!-- Dropdown Menu -->
                        <div class="absolute right-0 mt-2 w-56 bg-white rounded-lg shadow-lg py-2 z-50 opacity-0 invisible group-hover:opacity-100 group-hover:visible transition-all duration-200">
                            <div class="px-4 py-3 border-b border-gray-100">
                                <p class="text-sm font-medium text-gray-900">{{ auth()->user()->name }}</p>
                                <p class="text-xs text-gray-500 truncate">{{ auth()->user()->email }}</p>
                                <p class="text-xs text-primary font-medium mt-1 capitalize">{{ auth()->user()->user_type }} Account</p>
                            </div>
                            
                            <a href="{{ route('profile.dashboard') }}" class="flex items-center space-x-2 px-4 py-2 text-sm text-gray-700 hover:bg-gray-50 transition">
                                <i class="fas fa-user text-gray-400"></i>
                                <span>My Profile</span>
                            </a>
                            
                            <a href="/settings" class="flex items-center space-x-2 px-4 py-2 text-sm text-gray-700 hover:bg-gray-50 transition">
                                <i class="fas fa-cog text-gray-400"></i>
                                <span>Settings</span>
                            </a>
                            
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
                
                <a href="{{ route('admin.dashboard') }}" class="flex items-center space-x-2 px-2 py-3 {{ request()->routeIs('admin.dashboard') ? 'text-primary bg-primary/5' : 'text-gray-700 hover:bg-gray-50' }} rounded-lg transition">
                    <i class="fas fa-home"></i>
                    <span>Dashboard</span>
                </a>
                
                <a href="{{ route('tickets.index') }}" class="flex items-center space-x-2 px-2 py-3 {{ request()->routeIs('tickets.*') ? 'text-primary bg-primary/5' : 'text-gray-700 hover:bg-gray-50' }} rounded-lg transition">
                    <i class="fas fa-ticket-alt"></i>
                    <span>Tickets</span>
                </a>
                
                <a href="{{ route('admin.ticket-categories') }}" class="flex items-center space-x-2 px-2 py-3 {{ request()->routeIs('admin.ticket-categories*') ? 'text-primary bg-primary/5' : 'text-gray-700 hover:bg-gray-50' }} rounded-lg transition">
                    <i class="fas fa-folder"></i>
                    <span>Categories</span>
                </a>
                
                <a href="{{ route('admin.tech.create') }}" class="flex items-center space-x-2 px-2 py-3 {{ request()->routeIs('admin.tech.create') ? 'text-primary bg-primary/5' : 'text-gray-700 hover:bg-gray-50' }} rounded-lg transition">
                    <i class="fas fa-user-plus"></i>
                    <span>Add Tech</span>
                </a>
                
                <div class="border-t border-gray-100 pt-3 mt-3">
                    <a href="/profile" class="flex items-center space-x-2 px-2 py-3 text-gray-700 hover:bg-gray-50 rounded-lg transition">
                        <i class="fas fa-user text-gray-400"></i>
                        <span>My Profile</span>
                    </a>
                    
                    <a href="/settings" class="flex items-center space-x-2 px-2 py-3 text-gray-700 hover:bg-gray-50 rounded-lg transition">
                        <i class="fas fa-cog text-gray-400"></i>
                        <span>Settings</span>
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
                    <a href="{{ route('admin.ticket-categories.create') }}" class="mt-4 md:mt-0 inline-flex items-center space-x-2 bg-white text-primary px-6 py-3 rounded-lg font-semibold hover:bg-gray-100 transition shadow-lg">
                        <i class="fas fa-plus-circle"></i>
                        <span>Add New Category</span>
                    </a>
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
                                            <a href="{{ route('admin.ticket-categories.edit', $category->id) }}" 
                                               class="w-8 h-8 bg-blue-50 hover:bg-blue-100 rounded-lg flex items-center justify-center text-blue-600 hover:text-blue-700 transition"
                                               title="Edit Category">
                                                <i class="fas fa-edit"></i>
                                            </a>
                                            <form action="{{ route('admin.ticket-categories.destroy', $category->id) }}" 
                                                  method="POST" 
                                                  onsubmit="return confirm('Are you sure you want to delete this category? This action cannot be undone.');"
                                                  class="inline">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" 
                                                        class="w-8 h-8 bg-red-50 hover:bg-red-100 rounded-lg flex items-center justify-center text-red-600 hover:text-red-700 transition"
                                                        title="Delete Category"
                                                        {{ $ticketCount > 0 ? 'disabled' : '' }}
                                                        @if($ticketCount > 0)
                                                            onclick="event.preventDefault(); alert('Cannot delete category with existing tickets. Please reassign or delete the tickets first.');"
                                                        @endif>
                                                    <i class="fas fa-trash"></i>
                                                </button>
                                            </form>
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
                                            <a href="{{ route('admin.ticket-categories.create') }}" 
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
                
                @if(method_exists($categories, 'links') && $categories->hasPages())
                    <div class="px-6 py-4 bg-gray-50 border-t border-gray-200">
                        <div class="flex items-center justify-between">
                            <div class="text-sm text-gray-600">
                                Showing <span class="font-medium">{{ $categories->firstItem() ?? 0 }}</span>
                                to <span class="font-medium">{{ $categories->lastItem() ?? 0 }}</span>
                                of <span class="font-medium">{{ $categories->total() }}</span> categories
                            </div>
                            <div class="flex items-center space-x-2">
                                {{ $categories->links() }}
                            </div>
                        </div>
                    </div>
                @endif
            </div>
        </div>
    </main>

    <!-- Footer - mt-auto pushes it to bottom -->
    <footer class="bg-gray-900 text-gray-400 py-8 mt-auto">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="border-t border-gray-800 pt-8 text-center text-sm">
                <p>
                    © {{ date('Y') }} Dataworld Computer Center. All rights reserved.
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
                
                // Close mobile menu when clicking outside
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