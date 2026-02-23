<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Create Technician Account - Dataworld Support Portal</title>
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
                    <a href="/dashboard" class="{{ request()->is('dashboard') ? 'text-primary border-b-2 border-primary' : 'text-gray-700 hover:text-primary' }} font-medium transition flex items-center space-x-2 pb-1">
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
                        <div class="absolute right-0 mt-2 w-48 bg-white rounded-lg shadow-lg py-2 z-50 opacity-0 invisible group-hover:opacity-100 group-hover:visible transition-all duration-200">
                            <div class="px-4 py-3 border-b border-gray-100">
                                <p class="text-sm font-medium text-gray-900">{{ auth()->user()->name }}</p>
                                <p class="text-xs text-gray-500 truncate">{{ auth()->user()->email }}</p>
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
    <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
      <div class="flex items-center text-sm text-gray-500 mb-6 bg-gray-50 px-4 py-3 rounded-lg">
            <a href="/dashboard" class="hover:text-primary transition breadcrumb-hover flex items-center">
                <span>Dashboard</span>
            </a>
            <i class="fas fa-chevron-right mx-3 text-xs text-gray-400"></i>
            <a href="create_tech" class="hover:text-primary transition breadcrumb-hover flex items-center">
                <span>Create Tech Account</span>
            </a>
            
    
        </div>        
        <div class="mb-8">
            <div class="flex items-center space-x-4">
                <div class="w-16 h-16 bg-primary/10 rounded-2xl flex items-center justify-center">
                    <i class="fas fa-user-plus text-3xl text-primary"></i>
                </div>
                <div>
                    <h1 class="text-3xl font-bold text-gray-900">Create Technician Account</h1>
                    <p class="text-gray-600 mt-1">Add a new technician to your support team</p>
                </div>
            </div>
        </div>

        <!-- Success Message -->
        @if(session('success'))
        <div class="mb-6 bg-green-100 border-l-4 border-green-500 text-green-700 p-4 rounded-lg flex items-center justify-between" role="alert">
            <div class="flex items-center space-x-3">
                <i class="fas fa-check-circle text-green-500 text-xl"></i>
                <p>{{ session('success') }}</p>
            </div>
            <button type="button" class="text-green-700 hover:text-green-900" onclick="this.parentElement.remove()">
                <i class="fas fa-times"></i>
            </button>
        </div>
        @endif

        <!-- Error Messages -->
        @if($errors->any())
        <div class="mb-6 bg-red-100 border-l-4 border-red-500 text-red-700 p-4 rounded-lg" role="alert">
            <div class="flex items-center space-x-3 mb-2">
                <i class="fas fa-exclamation-circle text-red-500 text-xl"></i>
                <p class="font-semibold">Please fix the following errors:</p>
            </div>
            <ul class="list-disc list-inside ml-6 space-y-1">
                @foreach($errors->all() as $error)
                    <li class="text-sm">{{ $error }}</li>
                @endforeach
            </ul>
        </div>
        @endif

        <!-- Create Tech Form -->
        <div class="bg-white rounded-2xl shadow-lg overflow-hidden card-hover">
            <div class="px-8 py-6 bg-gradient-to-r from-primary to-primaryDark">
                <h2 class="text-xl font-semibold text-white flex items-center space-x-3">
                    <i class="fas fa-user-cog"></i>
                    <span>Technician Information</span>
                </h2>
            </div>
            
            <form action="{{ route('admin.tech.store') }}" method="POST" class="p-8">
                @csrf
                
                <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
                    <!-- Left Column -->
                    <div class="space-y-6">
                        <!-- Full Name -->
                        <div>
                            <label for="name" class="block text-sm font-medium text-gray-700 mb-2">
                                <i class="fas fa-user text-primary mr-2"></i>Full Name <span class="text-red-500">*</span>
                            </label>
                            <input type="text" 
                                   name="name" 
                                   id="name" 
                                   value="{{ old('name') }}"
                                   class="w-full px-4 py-3 border border-gray-300 rounded-xl form-input focus:outline-none focus:border-primary focus:ring-2 focus:ring-primary/20 transition @error('name') border-red-500 @enderror"
                                   placeholder="John Doe"
                                   required
                                   autofocus>
                            @error('name')
                                <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Email Address -->
                        <div>
                            <label for="email" class="block text-sm font-medium text-gray-700 mb-2">
                                <i class="fas fa-envelope text-primary mr-2"></i>Email Address <span class="text-red-500">*</span>
                            </label>
                            <input type="email" 
                                   name="email" 
                                   id="email" 
                                   value="{{ old('email') }}"
                                   class="w-full px-4 py-3 border border-gray-300 rounded-xl form-input focus:outline-none focus:border-primary focus:ring-2 focus:ring-primary/20 transition @error('email') border-red-500 @enderror"
                                   placeholder="tech@dataworld.com"
                                   required>
                            @error('email')
                                <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Company (Optional) -->
                        <div>
                            <label for="company" class="block text-sm font-medium text-gray-700 mb-2">
                                <i class="fas fa-building text-primary mr-2"></i>Company
                            </label>
                            <input type="text" 
                                   name="company" 
                                   id="company" 
                                   value="{{ old('company', 'Dataworld Computer Center') }}"
                                   class="w-full px-4 py-3 border border-gray-300 rounded-xl form-input focus:outline-none focus:border-primary focus:ring-2 focus:ring-primary/20 transition"
                                   placeholder="Company Name">
                            <p class="mt-1 text-xs text-gray-500">
                                <i class="fas fa-info-circle mr-1"></i>
                                Default: Dataworld Computer Center
                            </p>
                        </div>
                    </div>

                    <!-- Right Column -->
                    <div class="space-y-6">
                        <!-- Phone Number -->
                        <div>
                            <label for="phone" class="block text-sm font-medium text-gray-700 mb-2">
                                <i class="fas fa-phone text-primary mr-2"></i>Phone Number
                            </label>
                            <input type="tel" 
                                   name="phone" 
                                   id="phone" 
                                   value="{{ old('phone') }}"
                                   class="w-full px-4 py-3 border border-gray-300 rounded-xl form-input focus:outline-none focus:border-primary focus:ring-2 focus:ring-primary/20 transition"
                                   placeholder="+63 912 345 6789">
                            @error('phone')
                                <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Password -->
                        <div>
                            <label for="password" class="block text-sm font-medium text-gray-700 mb-2">
                                <i class="fas fa-lock text-primary mr-2"></i>Password <span class="text-red-500">*</span>
                            </label>
                            <input type="password" 
                                   name="password" 
                                   id="password" 
                                   class="w-full px-4 py-3 border border-gray-300 rounded-xl form-input focus:outline-none focus:border-primary focus:ring-2 focus:ring-primary/20 transition @error('password') border-red-500 @enderror"
                                   placeholder="••••••••"
                                   required>
                            @error('password')
                                <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Confirm Password -->
                        <div>
                            <label for="password_confirmation" class="block text-sm font-medium text-gray-700 mb-2">
                                <i class="fas fa-lock text-primary mr-2"></i>Confirm Password <span class="text-red-500">*</span>
                            </label>
                            <input type="password" 
                                   name="password_confirmation" 
                                   id="password_confirmation" 
                                   class="w-full px-4 py-3 border border-gray-300 rounded-xl form-input focus:outline-none focus:border-primary focus:ring-2 focus:ring-primary/20 transition"
                                   placeholder="••••••••"
                                   required>
                        </div>
                    </div>
                </div>

                <!-- Form Actions -->
                <div class="mt-8 pt-6 border-t border-gray-200 flex items-center justify-end space-x-4">
                    <a href="{{ route('admin.dashboard') }}" 
                       class="px-6 py-3 border border-gray-300 rounded-xl text-gray-700 font-medium hover:bg-gray-50 transition flex items-center space-x-2">
                        <i class="fas fa-times"></i>
                        <span>Cancel</span>
                    </a>
                    <button type="submit" 
                            class="px-8 py-3 bg-gradient-to-r from-primary to-primaryDark text-white rounded-xl font-medium hover:opacity-90 transition flex items-center space-x-3 shadow-lg hover:shadow-xl">
                        <i class="fas fa-user-plus"></i>
                        <span>Create Technician Account</span>
                    </button>
                </div>
            </form>
        </div>

    </div>

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
            
            // Password strength indicator
            const passwordInput = document.getElementById('password');
            if (passwordInput) {
                passwordInput.addEventListener('input', function() {
                    const password = this.value;
                    let strength = 0;
                    
                    if (password.length >= 8) strength++;
                    if (password.match(/[a-z]+/)) strength++;
                    if (password.match(/[A-Z]+/)) strength++;
                    if (password.match(/[0-9]+/)) strength++;
                    if (password.match(/[$@#&!]+/)) strength++;
                    
                    // You can add visual feedback here
                });
            }

            // Form submission handling for checkboxes
            const form = document.querySelector('form');
            if (form) {
                form.addEventListener('submit', function(e) {
                    // Handle is_active checkbox
                    const isActiveCheckbox = document.getElementById('is_active');
                    if (isActiveCheckbox && !isActiveCheckbox.checked) {
                        // Create hidden input to send false value
                        const hiddenInput = document.createElement('input');
                        hiddenInput.type = 'hidden';
                        hiddenInput.name = 'is_active';
                        hiddenInput.value = '0';
                        form.appendChild(hiddenInput);
                        
                        // Remove the checkbox name so it doesn't submit with value 1
                        isActiveCheckbox.removeAttribute('name');
                    }
                    
                    // Handle email_verified checkbox
                    const emailVerifiedCheckbox = document.getElementById('email_verified');
                    if (emailVerifiedCheckbox && !emailVerifiedCheckbox.checked) {
                        // Create hidden input to send false value
                        const hiddenInput = document.createElement('input');
                        hiddenInput.type = 'hidden';
                        hiddenInput.name = 'email_verified';
                        hiddenInput.value = '0';
                        form.appendChild(hiddenInput);
                        
                        // Remove the checkbox name so it doesn't submit with value 1
                        emailVerifiedCheckbox.removeAttribute('name');
                    }
                });
            }
        });
    </script>
</body>
</html>