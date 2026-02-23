<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Create Category - Dataworld Support</title>
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
                            
                            
                            <!-- Add Tech moved to dropdown - Only visible to admin -->
                            @if(auth()->user()->user_type === 'admin')
                            <div class="border-t border-gray-100 my-1"></div>
                            <a href="{{ route('admin.tech.create') }}" class="flex items-center space-x-2 px-4 py-2 text-sm text-blue-600 hover:bg-blue-50 transition">
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
                
                <div class="flex items-center space-x-2 px-2 py-3">
                    <i class="fas fa-bell text-gray-400"></i>
                    <span>Notifications</span>
                    <span class="ml-auto w-6 h-6 bg-red-500 text-white text-xs rounded-full flex items-center justify-center">
                        3
                    </span>
                </div>
                
                <!-- Add Tech in Mobile Menu - Only visible to admin -->
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
                    <a href="/profile" class="flex items-center space-x-2 px-2 py-3 text-gray-700 hover:bg-gray-50 rounded-lg transition">
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

    <!-- Main Content - flex-1 pushes footer down -->
    <main class="flex-1">
        <div class="max-w-3xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
            <!-- Header with Breadcrumb -->
            <div class="mb-8">
                <div class="flex items-center text-sm text-gray-500 mb-2">
                    <a href="{{ route('admin.dashboard') }}" class="hover:text-primary transition">Dashboard</a>
                    <i class="fas fa-chevron-right mx-2 text-xs"></i>
                    <a href="{{ route('admin.ticket-categories') }}" class="hover:text-primary transition">Categories</a>
                    <i class="fas fa-chevron-right mx-2 text-xs"></i>
                    <span class="text-gray-700 font-medium">Create New</span>
                </div>
                
                <div class="flex items-center justify-between">
                    <div>
                        <h1 class="text-2xl md:text-3xl font-bold text-gray-900">Create New Category</h1>
                        <p class="text-gray-600 mt-2">Add a new category to organize support tickets.</p>
                    </div>
                </div>
            </div>

            <!-- Error Messages -->
            @if($errors->any())
                <div class="mb-6 bg-red-100 border-l-4 border-red-500 text-red-700 p-4 rounded-lg flex items-start shadow-md" role="alert">
                    <div class="flex items-start space-x-3">
                        <div class="w-8 h-8 bg-red-200 rounded-full flex items-center justify-center flex-shrink-0 mt-0.5">
                            <i class="fas fa-exclamation-circle text-red-600"></i>
                        </div>
                        <div>
                            <p class="font-medium">Please fix the following errors:</p>
                            <ul class="list-disc list-inside text-sm mt-1">
                                @foreach($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    </div>
                </div>
            @endif

            <!-- Create Category Form -->
            <div class="bg-white rounded-xl shadow-md overflow-hidden">
                <div class="px-6 py-4 border-b border-gray-200 bg-gray-50">
                    <h2 class="text-lg font-semibold text-gray-800">
                        <i class="fas fa-folder-plus text-primary mr-2"></i>
                        Category Information
                    </h2>
                </div>
                
                <div class="p-6">
                    <form action="{{ route('admin.ticket-categories.store') }}" method="POST">
                        @csrf
                        
                        <div class="space-y-6">
                            <!-- Category Name -->
                            <div>
                                <label for="name" class="block text-sm font-medium text-gray-700 mb-2">
                                    Category Name <span class="text-red-500">*</span>
                                </label>
                                <div class="relative">
                                    <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                        <i class="fas fa-folder text-gray-400"></i>
                                    </div>
                                    <input type="text" 
                                           id="name" 
                                           name="name" 
                                           value="{{ old('name') }}"
                                           required
                                           autofocus
                                           class="w-full pl-10 px-4 py-3 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-primary focus:border-transparent @error('name') border-red-500 @enderror"
                                           placeholder="e.g., Network Issues, Billing, Technical Support">
                                </div>
                                @error('name')
                                    <p class="mt-2 text-sm text-red-600 flex items-center">
                                        <i class="fas fa-exclamation-circle mr-1"></i>
                                        {{ $message }}
                                    </p>
                                @enderror
                                <div class="mt-2 flex items-start space-x-2 text-xs text-gray-500">
                                    <i class="fas fa-info-circle mt-0.5"></i>
                                    <span>Category names should be unique, descriptive, and easy to understand. Maximum 255 characters.</span>
                                </div>
                            </div>

                            <!-- Preview Card -->
                            <div class="bg-gray-50 rounded-lg p-4 border border-gray-200">
                                <h3 class="text-sm font-medium text-gray-700 mb-3 flex items-center">
                                    <i class="fas fa-eye mr-2 text-primary"></i>
                                    Preview
                                </h3>
                                <div class="flex items-center space-x-3" id="previewContainer">
                                    <div class="w-10 h-10 bg-primary/10 rounded-lg flex items-center justify-center">
                                        <i class="fas fa-folder text-primary"></i>
                                    </div>
                                    <div>
                                        <span class="text-sm font-medium text-gray-900" id="categoryNamePreview">
                                            {{ old('name') ?: 'New Category Name' }}
                                        </span>
                                        <span class="text-xs text-gray-500 block mt-0.5">
                                            <i class="fas fa-ticket-alt mr-1"></i>
                                            0 tickets
                                        </span>
                                    </div>
                                </div>
                            </div>

                            <!-- Form Actions -->
                            <div class="flex items-center justify-end space-x-4 pt-6 border-t border-gray-200">
                                <a href="{{ route('admin.ticket-categories') }}" 
                                   class="px-6 py-3 border border-gray-300 rounded-lg font-medium text-gray-700 hover:bg-gray-50 transition flex items-center space-x-2">
                                    <i class="fas fa-times"></i>
                                    <span>Cancel</span>
                                </a>
                                <button type="submit" 
                                        class="bg-primary hover:bg-primaryDark text-white px-6 py-3 rounded-lg font-medium flex items-center space-x-2 transition shadow-md hover:shadow-lg">
                                    <i class="fas fa-save"></i>
                                    <span>Create Category</span>
                                </button>
                            </div>
                        </div>
                    </form>
                </div>
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
            
            // Live category name preview
            const categoryNameInput = document.getElementById('name');
            const categoryNamePreview = document.getElementById('categoryNamePreview');
            
            if (categoryNameInput && categoryNamePreview) {
                categoryNameInput.addEventListener('input', function() {
                    if (this.value.trim() === '') {
                        categoryNamePreview.textContent = 'New Category Name';
                    } else {
                        categoryNamePreview.textContent = this.value;
                    }
                });
            }
            
            // Auto-resize textarea (if any)
            const textareas = document.querySelectorAll('textarea');
            textareas.forEach(textarea => {
                textarea.addEventListener('input', function() {
                    this.style.height = 'auto';
                    this.style.height = (this.scrollHeight) + 'px';
                });
            });
        });
    </script>
</body>
</html>